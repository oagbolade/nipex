<?php
	//Get required files
	require_once '../db-config.php';
	
	//Initialization
	$response = "";
	$constant = [
		'url' => URL, 'urlemail' => URLEMAIL, 'contactemail' => CONTACTEMAIL, 
		'development' => DEVELOPMENT, 'directory' => ROOT.'error', 'sitename' => SITENAME];
	$pageName = "Fee Management";
	
	//Lock up page
	$DbHandle = new DBHandler($PDO, "login", __FILE__);
	$User = new Users($DbHandle);
	$userDetails = $User->userDetails($_SESSION['nipexLogin']['email']); 
	$Authenication = new Authentication($DbHandle);
	$Authenication->setConstants($constant);
	$Authenication->keyToPage();
	$Authenication->pageAccessor(['IT'], $userDetails['authority']);
	
	$_SESSION['token'] = md5(TOKENRAW);
	
	$Tag = new Tag(URL);
	$head = $Tag->createHead(SITENAME." | Home ", "nav-md home-page", ['css' => ['css/nprogress.css']]);
	$menu = $Tag->createSideBar($PDO, $userDetails['email'], ['parent'=>'Fee Management', 'child'=>'']);
	$mastHead = $Tag->createMastHead($PDO, $userDetails['email']);
	$slogan = $Tag->createFooterSlogan();
	$footer = $Tag->createFooter(['js/custom.js']);
	
	//Error in data sent for processing
	if(isset($_SESSION['dataError'])){
		if(!isset($_SESSION['spoofing'])){
			$content = "<ul>";
			foreach ($_SESSION['dataError'] as $aMessage) {
				$content .= "<li class='text-left'>$aMessage</li>";	
			}
			$content .= "</ul>";
			$response = $Tag->createAlert("", $content, 'danger', false);
		}
		else{
			$functions = new Functions();
			$ErrorAlerter = new ErrorAlert($_SESSION['spoofing'], $functions, $constant);
			$ErrorAlerter->sendAlerts();
			$response = $Tag->createAlert("System Error", "Ouch we are sorry something went wrong, we think your internet connection may be slow", 'danger', true);
			unset($_SESSION['spoofing']);
		}
		unset($_SESSION['dataError']);
	}
	
	//Response after data processing
	if(isset($_SESSION['response'])){
		$response = $Tag->createAlert("", $_SESSION['response'], 'success', false);
		unset($_SESSION['response']);
	}
	
	$action = "value='create'";
	$fee = "";
	$amount = "";
	$buttonCaption = "Create";
	$sessionCaption = "Fee Creation";
	$feeID = "";
	$disabledFee = "";
	if(isset($_GET['feeID']) && in_array($_GET['feeID'], Functions::numericArray($DbHandle, 'fee', 'id'))){
		$action = "value='edit'";
		$buttonCaption = "Change";
		$sessionCaption = "Change Fee";
		$feeID = "<input type='hidden' name='id' value='{$_GET['feeID']}'/>";
		$DbHandle->setTable('fee');
		$feeInfo = $DbHandle->iRetrieveData(__LINE__, ['id'=>$_GET['feeID']]);
		$disabledFee = ($feeInfo[0]['fee']=='subscription' || $feeInfo[0]['fee']=='renewal') ? "disabled" : "";
		$fee = "value = '{$feeInfo[0]['fee']}'";
		$amount = "value = '{$feeInfo[0]['amount']}'";	
	}
	
	//Generate table existing fees
	$table = "
		<table class='table table-striped'>
      <thead>
        <tr>
          <th>#</th>
          <th>Fee name</th>
          <th>Amount</th>
          <th></th>
          <th></th>
        </tr>
      </thead>
      <tbody>
   ";
	 $DbHandle->setTable("fee");
	 if($feeCollection = $DbHandle->iRetrieveData(__LINE__)){
	 	$kanter = 0;
	 		foreach ($feeCollection as $aFee) {
	 			$disabled = ($aFee['fee']=='subscription' || $aFee['fee']=='renewal') ? "disabled" : ""; 
				 $table .="
					<tr>
	          <th scope='row'>".++$kanter."</th>
	          <td>{$aFee['fee']}</td>
	          <td> &#8358;".number_format($aFee['amount'],2)."</td>
	          <td><a class='btn btn-warning' href='".URL."fee-management/?feeID={$aFee['id']}'>Edit</a></td>
	          <td>
	          	<form class='form-horizontal form-label-left' method='post' action='".htmlentities('processor.php')."'>
              	<input type='hidden' name='token' value='{$_SESSION['token']}'/>
              	<input type='hidden' name='id' value='{$aFee['id']}'/>
              	<button $disabled type='submit' value='delete' name='action' class='btn btn-danger'>Delete</button>
              </form>
            </td>
	        </tr> 
				 ";
			 }
	 }
   $table .="     
      </tbody>
    </table>
	";
