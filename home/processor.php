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
		$data[] = ['validationString' => 'email', 'dataName' => 'email', 'dataValue' => $_POST['email']];
		$data[] = ['validationString'=>'password rule', 'dataName'=>'email', 'dataValue'=>$_POST['password']];
		
		//Validate sent data
		$validationResult = $FormValidator->formValidation($data);
		if($validationResult['error']){
			if(!$validationResult['data']['email']) $dataError[] = "Invalid email";
			if(!$validationResult['data']['password']) $dataError[] = "Invalid password";
			$_SESSION['dataError'] = $dataError;
	  	header("Location: .");
	  	exit();
  	}
		
		//Perform page action
		$DbHandle = new DBHandler($PDO, "login", __FILE__);
		
		//Generate response to be sent back
		$_SESSION['response'] = "the response";
		header("Location: .");
	  exit();
	}
	else {
		$_SESSION['spoofing']="CSRF suspected in  ". __FILE__;
		$_SESSION['dataError']=TRUE;
		header("Location: .");
		exit();
	}