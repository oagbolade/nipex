<?php
	//Get required files
	require_once '../db-config.php';
	
	//Initialization
	$response = "";
	$constant = [
		'url' => URL, 'urlemail' => URLEMAIL, 'contactemail' => CONTACTEMAIL, 'salt' => SALT, 
		'development' => DEVELOPMENT, 'directory' => ROOT.'error', 'sitename' => SITENAME];
	$pageName = "Vendor Creation";
	
	//Lock up page
	$DbHandle = new DBHandler($PDO, "login", __FILE__);
	$User = new Users($DbHandle); 
	$Authentication = new Authentication($DbHandle);
	$Authentication->setConstants($constant);
	$Authentication->keyToPage();
	$userDetails = $User->userDetails($_SESSION['nipexLogin']['email']);
	$Authentication->pageAccessor(['IT'], $userDetails['authority']);
	
	$_SESSION['token'] = md5(TOKENRAW);
	
	$Tag = new Tag(URL);
	$head = $Tag->createHead(SITENAME." | Vendor Creation ", "nav-md view-staff-page", ['css' => ['css/nprogress.css']]);
	
	$menu = $Tag->createSideBar($PDO, $userDetails['email'], ['parent'=>'Vendors For Creation', 'child'=>'']);
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
	
	$disabled ="";
	//Response after data processing
	if(isset($_SESSION['response'])){
		$response = $Tag->createAlert("", $_SESSION['response'], 'success', true);
		unset($_SESSION['response']);
		$disabled = "disabled";
	}
	
	//Get member type
	$option = "<option value=''>Select One</option>";
	foreach (Functions::authorities() as $anAuthority) {
		if(!($anAuthority == "pre-vendor" ||  $anAuthority == "vendor")){
			$option .= "<option value = '$anAuthority'>". ucwords($anAuthority) ."</option>";	
		}
	} 
	
	//Get vendor id
	$DbHandle->setTable('payment');
	$permittedIDs = [];
	if($paymentCollection = $DbHandle->iRetrieveData(__LINE__, ['vendor'=>'no', 'approver'=>'IS NOT NULL'])){
		foreach ($paymentCollection as $aPayment) {
			$permittedIDs[] = $aPayment['id'];
		}
	}
	if(isset($_GET['id']) && in_array($_GET['id'], $permittedIDs)){
		$paymentDetails = $DbHandle->iRetrieveData(__LINE__, ['id'=>$_GET['id']]);
		$paymentDetails = $paymentDetails[0];
		$companyDetails = $User->userDetails($User->getEmailFrmID($paymentDetails['login_id']));
		$finaceDetails = $User->userDetails($User->getEmailFrmID($paymentDetails['approver']));
		$companyName = $companyDetails['company_name'];
		$companyEmail = $companyDetails['email'];
		$companyPhone = $companyDetails['phone_no'];
		$approver = "Payment approved by {$finaceDetails['name']} on ".date("jS F Y",strtotime($aPayment['approval_date']));
	}
	else {
		header("Location: ".URL."vendor-creation-list");
		exit;	
	}
	
	//End of validity Period
	$validityPeriod = date("Y-m-d",(time() + (365*24*60*60)));