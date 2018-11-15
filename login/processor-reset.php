<?php
	//Get required files
	require_once 'db-config.php'; 
	
	//Turn off magic quotes
	Functions::magicQuotesOff();
	
	//Check if the access to this script is coming from login page
  if(isset($_POST['token']) && $_POST['token']==$_SESSION['token']){
  	unset($_SESSION['token']);
		//Get validator to validate data sent to this script
		$FormValidator = new Validator();
		
		//Prepare form data for Validator
		$data[] = ['validationString' => 'email', 'dataName' => 'email', 'dataValue' => $_POST['resetEmail']];
		
		//Validate sent data
		$validationResult = $FormValidator->formValidation($data);
		if($validationResult['error']){
			$_SESSION['dataError'] = ['form' => 'password reset', 'message' => ['Invalid email']];
	  	header("Location: ".URL);
	  	exit();
  	}
		
		$DbHandle = new DBHandler($PDO, "login", __FILE__);
		$User = new Users($DbHandle, __FILE__);
		if($User->isEmailUsed($validationResult['data']['email'])){
			$Authenicator = new Authentication($DbHandle);
			$constant = ['salt' => SALT, 'url' => URL, 'urlemail' => URLEMAIL, 'contactemail' => CONTACTEMAIL, 'development' => DEVELOPMENT, 'sitename' =>SITENAME];
			$Authenicator->setConstants($constant);
			$functions = new Functions();
			$link = $Authenicator->sendResetCode($functions, $validationResult['data']['email']);
			if(!DEVELOPMENT) $link = "";
			$message = "
			Please check your email <span class='al-emphasis'>{$validationResult['data']['email']}</span>, the password reset
			code will be sent to it within the next 5 minutes. If the mail is not in your inbox check your spam folder and 
			please kindly whitelist our mail to prevent it from been filtered by your email program in the future.
			$link
		";	
		}
		else {
			$message = "
				<span class='al-emphasis'>{$validationResult['data']['email']}</span> is not associated with any account on our 
				system
			";
		}
		$_SESSION['response'] = ['form' => 'password reset', 'message' => $message];
		header("Location: ".URL);
	  exit();
	}
	else {
		$_SESSION['spoofing']="CSRF suspected in  ". __FILE__;
		$_SESSION['dataError']=TRUE;
		header("Location: .");
		exit();
	}