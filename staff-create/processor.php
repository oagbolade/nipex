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
		
		//Get validator to validate data sent to this script
		$FormValidator = new Validator();
		
		//Prepare form data for Validator
		$data[] = ['validationString' => 'non empty', 'dataName' => 'username', 'dataValue' => $_POST['username']];
		$data[] = ['validationString' => 'name', 'dataName' => 'name', 'dataValue' => $_POST['name']];
		$data[] = ['validationString'=>'email', 'dataName'=>'email', 'dataValue'=>$_POST['email']];
		$data[] = ['validationString' => 'sanitize', 'dataName' => 'phone', 'dataValue' => $_POST['phone']];
		$data[] = ['validationString'=>'password rule', 'dataName'=>'password', 'dataValue'=>$_POST['password']];
		$data[] = ['validationString'=>'in list', 'dataName'=>'authority', 'dataValue'=>$_POST['authority'], 'dataList'=>Functions::authorities()];
		
		//Validate sent data
		$validationResult = $FormValidator->formValidation($data);
		if($validationResult['error']){
			if(!$validationResult['data']['username']) $dataError[] = "Username is compulsory";
			if(!$validationResult['data']['name']) $dataError[] = "Name  is compulsory";
			if(!$validationResult['data']['email']) $dataError[] = "Email  is compulsory";
			if(!$validationResult['data']['phone']) $dataError[] = "Phone  is compulsory";
			if(!$validationResult['data']['password']) $dataError[] = "Invalid password";
			if(!$validationResult['data']['authority']) $dataError[] = "Invalid staff authority";
			$_SESSION['dataError'] = $dataError;
	  	header("Location: .");
	  	exit();
  	}
		$result = $validationResult['data'];
		
		//Create logger
		$DbHandle = new DBHandler($PDO, "login", __FILE__);
		$User = new Users($DbHandle);
		$Functions = new Functions();
		$data = [
			'username' => $result['username'], 
			'name' => $result['name'], 
			'email' => $result['email'], 
			'password' => $result['password'],
			'phone' => $result['phone'],
			'authority' => $result['authority']
		];
		if($created = $User->createLogger($Functions, $data, __LINE__, $result['authority'])){
			$_SESSION['response'] = "New user {$result['name']}
			created with authority of {$result['authority']}";
			if(DEVELOPMENT) $_SESSION['response'] = $created;
		}
		else {
			$_SESSION['response'] = "Sorry user can not be created either email or username is associated with another user";
		}
		
		//Generate response to be sent back
		header("Location: .");
	  exit();
	}
	else {
		$_SESSION['spoofing']="CSRF suspected in  ". __FILE__;
		$_SESSION['dataError']=TRUE;
		header("Location: .");
		exit();
	}