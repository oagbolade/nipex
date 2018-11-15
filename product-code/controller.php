<?php
	//Get required files
	require_once '../db-config.php';
	
	//Initialization
	$response = "";
	$constant = [
		'url' => URL, 'urlemail' => URLEMAIL, 'contactemail' => CONTACTEMAIL, 
		'development' => DEVELOPMENT, 'directory' => ROOT.'error', 'sitename' => SITENAME];
	$pageName = "Product & Service Code";
	
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
	$menu = $Tag->createSideBar($PDO, $userDetails['email'], ['parent'=>'Product & Service Code', 'child'=>'']);
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
	$code ="";
	$service = "";
	$buttonCaption = "Create";
	$sessionCaption = "Create Product/Service Code";
	$inputID = "";
	$categoryOption = "<option value=''>Pick a Category</option>";
	foreach (Functions::dprCategoryCollection(false) as $aCategoryKey => $aCategoryValue) {
		$categoryOption .= "<option value='$aCategoryKey'>$aCategoryValue</option>";
	}
	if(isset($_GET['id']) && in_array($_GET['id'], Functions::numericArray($DbHandle, 'product_code', 'id'))){
		$action = "value='edit'";
		$buttonCaption = "Change";
		$sessionCaption = "Change Product/Service Code";
		$inputID = "<input type='hidden' name='id' value='{$_GET['id']}'/>";
		$DbHandle->setTable('product_code');
		$serviceInfo = $DbHandle->iRetrieveData(__LINE__, ['id'=>$_GET['id']]);
		$code = "value = '{$serviceInfo[0]['code']}'";
		$service = "value = '{$serviceInfo[0]['service']}'";
		$categoryOption = "";
		foreach (Functions::dprCategoryCollection(false) as $aCategoryKey => $aCategoryValue) {
			if($aCategoryKey == $serviceInfo[0]['category']){
				$categoryOption .= "<option selected value='$aCategoryKey'>$aCategoryValue</option>";
			}
			else {
				$categoryOption .= "<option value='$aCategoryKey'>$aCategoryValue</option>";				
			}
		}	
	}
	
	//Generate table existing fees
	$table = "
		<table class='table table-striped'>
      <thead>
        <tr>
          <th>#</th>
          <th>Code</th>
          <th>Service</th>
          <th>Category</th>
          <th></th>
          <th></th>
        </tr>
      </thead>
      <tbody>
   ";
	 $DbHandle->setTable("product_code");
	 if($serviceCollection = $DbHandle->iRetrieveData(__LINE__, [], [], ['code'=>'ASC'])){
	 	$categories = Functions::dprCategoryCollection(false);
	 	$kanter = 0;
	 		foreach ($serviceCollection as $aService) {
	 			//var_dump($aService); exit;
				 $table .="
					<tr>
	          <th scope='row'>".++$kanter."</th>
	          <td>{$aService['code']}</td>
	          <td>{$aService['service']}</td>
	          <td>{$categories[$aService['category']]}</td>
	          <td>
	          	<a class='btn btn-warning' href='".URL."product-code/?id={$aService['id']}'>
	          		Edit
	          	</a>
	          </td>
	          <td>
	          	<form class='form-horizontal form-label-left' method='post' action='".htmlentities('processor.php')."'>
              	<input type='hidden' name='token' value='{$_SESSION['token']}'/>
              	<input type='hidden' name='id' value='{$aService['id']}'/>
              	<button type='submit' value='delete' name='action' class='btn btn-danger'>Delete</button>
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
