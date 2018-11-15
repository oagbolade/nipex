<?php
	//Get required files
	require_once '../db-config.php'; 
	
	//Turn off magic quotes
	Functions::magicQuotesOff();

	//Initialization
	$response = "";
	$constant = [
		'url' => URL, 'urlemail' => URLEMAIL, 'contactemail' => CONTACTEMAIL, 
		'development' => DEVELOPMENT, 'sitename' => SITENAME];
	
	//Lock up page
	$DbHandle = new DBHandler($PDO, "login", __FILE__);
	$User = new Users($DbHandle);
	$vendorDetails = $User->userDetails($_SESSION['nipexLogin']['email']); 
	$Authenication = new Authentication($DbHandle);
	$Authenication->setConstants($constant);
	$Authenication->keyToPage();
	$Authenication->pageAccessor(['vendor'], $vendorDetails['authority']);
			
	//Get validator to validate data sent to this script
	$FormValidator = new Validator();
	
	//Get parameter sent by user
	if(isset($_GET['vendor']) && $_GET['vendor'] == $vendorDetails['vendor_id']){
		$DbHandle->setTable("que_legal");
		$content = $DbHandle->iRetrieveData(__LINE__, ["vendor_id"=>$vendorDetails["vendor_id"]]);
		$newOwners = [];
		if($owners = json_decode($content[0]['shareholder'], true)){
			foreach ($owners as $anOwner) {
				if($anOwner['no'] != $_GET['director']) $newOwners[] = $anOwner;
			}
		}
		$DbHandle->updateData(__LINE__, ['shareholder'=>json_encode($newOwners)], ['vendor_id'=>$_GET['vendor']]);
		header("Location: ".URL."vendor-legal#companyOwner");
		exit();
	}
	else {
		header("Location: .");
		exit();
	}