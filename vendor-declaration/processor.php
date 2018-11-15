<?php
	//Get required files
	require_once '../config.php'; 
	require_once '../db-config.php'; 
	
	//Turn off magic quotes
	Functions::magicQuotesOff();
	
	//Check if the access to this script is coming from its index's page
  	if(isset($_POST['token']) && $_POST['token']==$_SESSION['token']){
	  	// unset($_SESSION['token']);
		
		//Initialization
		$response = "";
		$constant = [
			'url' => URL, 'urlemail' => URLEMAIL, 'contactemail' => CONTACTEMAIL, 
			'development' => DEVELOPMENT, 'sitename' => SITENAME];
		
		//Get validator to validate data sent to this script
		$FormValidator = new Validator();

		//Prepare form data for Validator
		if (!empty($_POST['completedName'])) {
			$data[] = ['validationString' => 'non empty', 'dataName' => 'completedName', 'dataValue' => $_POST['completedName']];
		}else{
			$data[] = ['validationString' => 'sanitize', 'dataName' => 'completedName', 'dataValue' => $_POST['completedName']];
		}
		if (!empty($_POST['completedPosition'])) {
			$data[] = ['validationString' => 'non empty', 'dataName' => 'completedPosition', 'dataValue' => $_POST['completedPosition']];
		}else{
			$data[] = ['validationString' => 'sanitize', 'dataName' => 'completedPosition', 'dataValue' => $_POST['completedPosition']];
		}
		if (!empty($_POST['completedDate'])) {
			$data[] = ['validationString' => 'non empty', 'dataName' => 'completedDate', 'dataValue' => $_POST['completedDate']];
		}else{
			$data[] = ['validationString' => 'sanitize', 'dataName' => 'completedDate', 'dataValue' => $_POST['completedDate']];
		}
		if (!empty($_POST['completedNumber'])) {
			$data[] = ['validationString' => 'gsm phone', 'dataName' => 'completedNumber', 'dataValue' => $_POST['completedNumber']];
		}else{
			$data[] = ['validationString' => 'sanitize', 'dataName' => 'completedNumber', 'dataValue' => $_POST['completedNumber']];
		}
		if (!empty($_POST['lastChangedName'])) {
			$data[] = ['validationString' => 'non empty', 'dataName' => 'lastChangedName', 'dataValue' => $_POST['lastChangedName']];
		}else{
			$data[] = ['validationString' => 'sanitize', 'dataName' => 'lastChangedName', 'dataValue' => $_POST['lastChangedName']];
		}
		if (!empty($_POST['lastChangedPosition'])) {
			$data[] = ['validationString' => 'non empty', 'dataName' => 'lastChangedPosition', 'dataValue' => $_POST['lastChangedPosition']];
		}else{
			$data[] = ['validationString' => 'sanitize', 'dataName' => 'lastChangedPosition', 'dataValue' => $_POST['lastChangedPosition']];
		}
		if (!empty($_POST['lastChangedDate'])) {
			$data[] = ['validationString' => 'non empty', 'dataName' => 'lastChangedDate', 'dataValue' => $_POST['lastChangedDate']];
		}else{
			$data[] = ['validationString' => 'sanitize', 'dataName' => 'lastChangedDate', 'dataValue' => $_POST['lastChangedDate']];
		}
		if (!empty($_POST['lastChangedDate'])) {
			$data[] = ['validationString' => 'gsm phone', 'dataName' => 'lastChangedNumber', 'dataValue' => $_POST['lastChangedNumber']];
		}else{
			$data[] = ['validationString' => 'sanitize', 'dataName' => 'lastChangedNumber', 'dataValue' => $_POST['lastChangedNumber']];
		}
		
		//Validate sent data
		$validationResult = $FormValidator->formValidation($data);
		if($validationResult['error']){
			if (!empty($_POST['completedName'])) {
				if(!$validationResult['data']['completedName']) $dataError[] = "Provide the name of the person that completed the questionnaire";
			}
			if (!empty($_POST['completedPosition'])) {
				if(!$validationResult['data']['completedPosition']) $dataError[] = "Provide the position of the person that completed the questionnaire";
			}
			if (!empty($_POST['completedDate'])) {
				if(!$validationResult['data']['completedDate']) $dataError[] = "Provide the date when the person completed the questionnaire";
			}
			if (!empty($_POST['completedNumber'])) {
				if(!$validationResult['data']['completedNumber']) $dataError[] = "Provide the phone number of the person that completed the questionnaire";
			}
			if (!empty($_POST['lastChangedName'])) {
				if(!$validationResult['data']['lastChangedName']) $dataError[] = "Provide the name of the last person that edited the questionnaire";
			}
			if (!empty($_POST['lastChangedPosition'])) {
				if(!$validationResult['data']['lastChangedPosition']) $dataError[] = "Provide the position of the last person that edited the questionnaire";
			}
			if (!empty($_POST['lastChangedDate'])) {
				if(!$validationResult['data']['lastChangedDate']) $dataError[] = "Provide the date when the last person edited the questionnaire";
			}
			if (!empty($_POST['lastChangedNumber'])) {
				if(!$validationResult['data']['lastChangedNumber']) $dataError[] = "Provide the phone number of the last person that edited the questionnaire";
			}
			$_SESSION['dataError'] = $dataError;
		  	header("Location: .");
	  	exit();
  	}
  		$result = $validationResult['data'];

		// Perform page action
		$DbHandle = new DBHandler($PDO, "login", __FILE__);
		$User = new Users($DbHandle);
		$vendorDetails = $User->userDetails($_SESSION['nipexLogin']['email']);
		$DbHandle->setTable("que_declaration");

		$completedBy = json_encode([
			'Name'=>$result['completedName'], 
			'Position'=>$result['completedPosition'], 
			'Date'=>$result['completedDate'], 
			'Phone Number'=>$result['completedNumber']
		]);
		$lastChangedBy = json_encode([
			'Name'=>$result['lastChangedName'], 
			'Position'=>$result['lastChangedPosition'], 
			'Date'=>$result['lastChangedDate'], 
			'Phone Number'=>$result['lastChangedNumber']
		]);

		$data = [
			'completed_by'=>$completedBy, 
			'last_changed_by'=>$lastChangedBy, 
		];

		if($genContent = $DbHandle->iRetrieveData(__LINE__, ["vendor_id"=>$vendorDetails["vendor_id"]])){
			$criteria = ['vendor_id'=>$vendorDetails["vendor_id"]];
			$DbHandle->updateData(__LINE__, $data, $criteria);
			$response = "updated";
		}
		else{
			$data["vendor_id"] = $vendorDetails["vendor_id"];
			$DbHandle->createData(__LINE__, $data);
			$response = "accepted";
		}

		//Generate response to be sent back
		$_SESSION['response'] = "Declaration has been successfully $response";
		header("Location: .");
	  exit();
	}
	else {
		$_SESSION['spoofing']="CSRF suspected in  ". __FILE__;
		$_SESSION['dataError']=TRUE;
		header("Location: .");
		exit();
	}