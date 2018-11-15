<?php
	//Get required files
	require_once '../db-config.php';
	
	//Initialization
	$response = "";
	$constant = [
		'url' => URL, 'urlemail' => URLEMAIL, 'contactemail' => CONTACTEMAIL, 'salt' => SALT, 
		'development' => DEVELOPMENT, 'directory' => ROOT.'error', 'sitename' => SITENAME];
	$pageName = "Approve Payment";
	
	//Lock up page
	$DbHandle = new DBHandler($PDO, "login", __FILE__);
	$User = new Users($DbHandle); 
	$Authentication = new Authentication($DbHandle);
	$Authentication->setConstants($constant);
	$Authentication->keyToPage();
	$userDetails = $User->userDetails($_SESSION['nipexLogin']['email']);
	$Authentication->pageAccessor(['finance'], $userDetails['authority']);
	
	$_SESSION['token'] = md5(TOKEN);
	
	$Tag = new Tag(URL);
	$head = $Tag->createHead(SITENAME." | Approve Payment ", "nav-md view-staff-page", ['css' => ['css/nprogress.css']]);
	
	$menu = $Tag->createSideBar($PDO, $userDetails['email'], ['parent'=>'Staff Admin', 'child'=>'View Staff']);
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
			$response = $Tag->createAlert("", $content, 'danger', true);
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
		$response = $Tag->createAlert("", $_SESSION['response'], 'success', true);
		unset($_SESSION['response']);
	}
	
	//Get list of all payment
	$DbHandle->setTable('payment');
	$table ="
		<table class='table table-striped'>
      <thead>
        <tr>
          <th>#</th>
          <th>Company</th>
          <th>Contact</th>
          <th>Amount</th>
          <th>Item</th>
          <th>Payment Details</th>
          <th></th>
        </tr>
      </thead>
      <tbody>
	";
	if($paymentCollection = $DbHandle->iRetrieveData(__LINE__, ['item'=>'subscription', 'approver'=>'IS NULL'])){
		$kanter = 0;
		foreach ($paymentCollection as $aPayment) {
			$companyDetails = $User->userDetails($User->getEmailFrmID($aPayment['login_id']));
			$pymtInfo = json_decode($aPayment['other'], true);
			$table .="
				<tr>
          <td>". ++$kanter ."</th>
          <td>{$companyDetails['company_name']}</td>
          <td>{$companyDetails['email']}<br/>{$companyDetails['phone_no']}</td>
          <td>".number_format($aPayment['amount'],2)."</td>
          <td>". ucfirst($aPayment['item']) ."</td>
          <td>
          	RRR: {$pymtInfo['RRR']}<br/>
          	Bank Name: {$pymtInfo['Bank Name']}<br/>
          	Account Name: {$pymtInfo['Account Name']}<br/>
          	Account No: {$pymtInfo['Account No']}<br/>
          </td>
          <td>
          	<form action='". htmlspecialchars("processor.php") ."' method='post'>
        			<input type='hidden' name='token' value='{$_SESSION['token']}' />
        			<input type='hidden' name='id' value='{$aPayment['id']}' />
        			<button class='btn btn-primary btn-sm' type='submit' name='action'>Approve</button>
          	</form>
          </td>
        </tr>
			";
		}
	}
	
	$table .= "</tbody></table>";