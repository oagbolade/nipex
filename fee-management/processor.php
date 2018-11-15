<?php
	//Get required files
	require_once '../db-config.php'; 
	
	//Turn off magic quotes
	Functions::magicQuotesOff();
	
	//Initialization
	$response = "";
	$constant = [
		'url' => URL, 'urlemail' => URLEMAIL, 'contactemail' => CONTACTEMAIL, 
		'development' => DEVELOPMENT, 'directory' => ROOT.'error', 'sitename' => SITENAME];
	
	//Lock up page
	$DbHandle = new DBHandler($PDO, "login", __FILE__);
	$User = new Users($DbHandle);
	$userDetails = $User->userDetails($_SESSION['nipexLogin']['email']); 
	$Authenication = new Authentication($DbHandle);
	$Authenication->setConstants($constant);
	$Authenication->keyToPage();
	$Authenication->pageAccessor(['IT'], $userDetails['authority']);
	
	//Check if the access to this script is coming from its index's page
  if(isset($_POST['token']) && $_POST['token']==$_SESSION['token']){
  	unset($_SESSION['token']);
		
		//Get validator to validate data sent to this script
		$FormValidator = new Validator();
		
		$DbHandle->setTable('fee');
		
		if($_POST['action'] == 'create'){
			//Prepare form data for Validator
			$data[] = ['validationString' => 'non empty', 'dataName' => 'fee', 'dataValue' => $_POST['fee']];
			$data[] = ['validationString'=>'number', 'dataName'=>'amount', 'dataValue'=>$_POST['amount']];
			
			//Validate sent data
			$validationResult = $FormValidator->formValidation($data);
			if($validationResult['error']){
				if(!$validationResult['data']['fee']) $dataError[] = "Fee name is compulsory ";
				if(!$validationResult['data']['amount']) $dataError[] = "Invalid amount";
				$_SESSION['dataError'] = $dataError;
		  	header("Location: .");
		  	exit();
	  	}
			$result = $validationResult['data'];
			$DbHandle->createData(__LINE__, ['fee'=>$result['fee'], 'amount'=>$result['amount']]);
			$response = "A new fee has been successfully created";
		}

		if($_POST['action'] == 'edit'){
			//Prepare form data for Validator
			$data[] = ['validationString' => 'non empty', 'dataName' => 'fee', 'dataValue' => $_POST['fee']];
			$data[] = ['validationString'=>'number', 'dataName'=>'amount', 'dataValue'=>$_POST['amount']];
			$data[] = ['validationString'=>'in list', 'dataName'=>'id', 'dataValue'=>$_POST['id'], 'dataList'=>Functions::numericArray($DbHandle, 'fee', 'id')];
			
			//Validate sent data
			$validationResult = $FormValidator->formValidation($data);
			if($validationResult['error']){
				if(!$validationResult['data']['fee']) $dataError[] = "Fee name is compulsory ";
				if(!$validationResult['data']['amount']) $dataError[] = "Invalid amount";
				if(!$validationResult['data']['id']) $dataError[] = "Invalid fee id";
				$_SESSION['dataError'] = $dataError;
		  	header("Location: .");
		  	exit();
	  	}
			$result = $validationResult['data'];
			$DbHandle->updateData(__LINE__, ['fee'=>$result['fee'], 'amount'=>$result['amount']], ['id'=>$result['id']]);
			$response = "A fee has been successfully changed";
		}

		if($_POST['action'] == 'delete'){
			//Prepare form data for Validator
			$data[] = ['validationString'=>'in list', 'dataName'=>'id', 'dataValue'=>$_POST['id'], 'dataList'=>Functions::numericArray($DbHandle, 'fee', 'id')];
			
			//Validate sent data
			$validationResult = $FormValidator->formValidation($data);
			if($validationResult['error']){
				if(!$validationResult['data']['id']) $dataError[] = "Invalid fee id";
				$_SESSION['dataError'] = $dataError;
		  	header("Location: .");
		  	exit();
	  	}
			$result = $validationResult['data'];
			$DbHandle->deleteData(__LINE__, ['id'=>$result['id']]);
			$response = "A fee has been successfully deleted";
		}
		
		//Generate response to be sent back
		$_SESSION['response'] = $response;
		header("Location: .");
	  exit();
	}
	else {
		$_SESSION['spoofing']="CSRF suspected in  ". __FILE__;
		$_SESSION['dataError']=TRUE;
		header("Location: .");
		exit();
	}