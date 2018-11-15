<?php
	//Get required files
	require_once '../db-config.php'; 
	
	//Turn off magic quotes
	Functions::magicQuotesOff();
	
	//Check if the access to this script is coming from password change index page
  if(isset($_POST['token']) && $_POST['token']==$_SESSION['token']){
  	unset($_SESSION['token']);
		//Get validator to validate data sent to this script
		$FormValidator = new Validator();
		
		//Check if password supplied are equal
		$passwordDiffError = false;
		if($_POST['password'] != $_POST['repeatPassword']) $passwordDiffError = true;
		
		//Prepare form data for Validator
		$data[] = ['validationString' => 'email', 'dataName' => 'email', 'dataValue' => $_POST['email']];
		$data[] = ['validationString'=>'password rule', 'dataName'=>'password', 'dataValue'=>$_POST['password']];
		
		//Validate sent data
		$validationResult = $FormValidator->formValidation($data);
		if($validationResult['error'] || $passwordDiffError){
			if(!$validationResult['data']['email']) $dataError[] = "Invalid email";
			if(!$validationResult['data']['password']) $dataError[] = "Invalid password (must be minimum 8 characters)";
			if($_POST['password'] != $_POST['repeatNewPassword']) $dataError[] = "Password and repeated password differs";
			$_SESSION['dataError'] = $dataError;
	  	header("Location: ".URL."password-change/?token=". urlencode($_POST['resetToken']) ."&email=". urlencode($_POST['email']));
	  	exit();
  	}
		$result = $validationResult['data'];
		
		$DbHandle = new DBHandler($PDO, "login", __FILE__);
		$DbHandle->updateData(__LINE__, ['password' => crypt($_POST['password'], SALT), 'default_password' => 'no'], ['email' => $_POST['email']]);
		$_SESSION['response'] = "Your password has been successfully changed. You can now <a style='text-decoration:underline;' href='". URL ."'>LOGIN</a> with your new password";
		header("Location: .");
	  exit();
	}
	else {
		$_SESSION['spoofing']="CSRF suspected in  ". __FILE__;
		$_SESSION['dataError']=TRUE;
		header("Location: .");
		exit();
	}