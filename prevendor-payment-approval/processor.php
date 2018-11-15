<?php
	//Get required files
	require_once '../db-config.php'; 
	
	//Turn off magic quotes
	Functions::magicQuotesOff();
	
	//Check if the access to this script is coming from its index's page
  if(isset($_POST['token']) && $_POST['token']==$_SESSION['token']){
  	unset($_SESSION['token']);
		
		//Initialization
		$response = "";
		$constant = [
			'url' => URL, 'urlemail' => URLEMAIL, 'contactemail' => CONTACTEMAIL, 
			'development' => DEVELOPMENT, 'sitename' => SITENAME];
		$DbHandle = new DBHandler($PDO, "login", __FILE__);
		$User = new Users($DbHandle);
		$Functions = new Functions();
		
		//List of staff email
		$DbHandle->setTable('payment');
		$allPymtIDs = [];
		if($allPymtInfo = $DbHandle->retrieveData(__LINE__)){
			foreach ($allPymtInfo as $aPymtInfo) {
				$allPymtIDs[] = $aPymtInfo['id'];
			}
		}
		
		//Get validator to validate data sent to this script
		$FormValidator = new Validator();
		
		//Prepare form data for Validator
		$data[] = ['validationString'=>'in list', 'dataName'=>'id', 'dataValue'=>$_POST['id'], 'dataList'=>$allPymtIDs];
		
		//Validate sent data
		$validationResult = $FormValidator->formValidation($data);
		if($validationResult['error']){
			if(!$validationResult['data']['id']) $dataError[] = "Invalid id";
			$_SESSION['dataError'] = $dataError;
	  	header("Location: .");
	  	exit();
  	}
		$result = $validationResult['data'];
		
		$DbHandle->updateData(__LINE__, ['approver'=>$_SESSION['nipexLogin']['id'], 'approval_date'=>"NOW()"], ['id'=>$result['id']]);
		$_SESSION['response'] = "Vendor subscription fee has been successfully approved";
		header("Location: .");
	  exit();
	}
	else {
		$_SESSION['spoofing']="CSRF suspected in  ". __FILE__;
		$_SESSION['dataError']=TRUE;
		header("Location: .");
		exit();
	}