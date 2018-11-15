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
		$DbHandle->setTable("que_personnel");
		$content = $DbHandle->iRetrieveData(__LINE__, ["vendor_id"=>$vendorDetails["vendor_id"]]);
		$newExecutives = [];
		if($executives = json_decode($content[0]['executives'], true)){
			foreach ($executives as $anExecutives) {
				if($anExecutives['no'] != $_GET['executive']) $newExecutives[] = $anExecutives;
			}
		}
		$DbHandle->updateData(__LINE__, ['executives'=>json_encode($newExecutives)], ['vendor_id'=>$_GET['vendor']]);
		header("Location: ".URL."vendor-personnel#companyExecutives");
		exit();
	}
	else {
		header("Location: .");
		exit();
	}