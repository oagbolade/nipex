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
	$pageName = "Login Details";
	
	//Lock up page
	$DbHandle = new DBHandler($PDO, "login", __FILE__);
	$User = new Users($DbHandle);
	$userDetails = $User->userDetails($_SESSION['nipexLogin']['email']); 
	$Authenication = new Authentication($DbHandle);
	$Authenication->setConstants($constant);
	$Authenication->keyToPage();
	$Authenication->pageAccessor(['vendor'], $userDetails['authority']);
	
	//Check if the access to this script is coming from its index's page
  if(isset($_POST['token']) && $_POST['token']==$_SESSION['token']){
  	unset($_SESSION['token']);
		
		//Get validator to validate data sent to this script
		$FormValidator = new Validator();
		
		//Prepare form data for Validator
		$data[] = ['validationString'=>'password rule', 'dataName'=>'newPassword', 'dataValue'=>$_POST['newPassword']];
		
		//Validate sent data
		$otherError = false;
		$passwordDiff = false;
		if($_POST['newPassword'] != $_POST['repeatNewPassword']){
			$otherError = true;
			$passwordDiff = true;
		}
		$oldPasswordWrong = false;
		if(crypt($_POST['oldPassword'], SALT) != $userDetails['password']){
			$otherError = true;
			$oldPasswordWrong = true;
		}
		$validationResult = $FormValidator->formValidation($data);
		if($validationResult['error'] || $otherError){
			if(!$validationResult['data']['newPassword']) $dataError[] = "Invalid password";
			if($passwordDiff) $dataError[] = "New password and repeat new password differs";
			if($oldPasswordWrong) $dataError[] = "Old password failed";
			$_SESSION['dataError'] = $dataError;
	  	header("Location: .");
	  	exit();
  	}
		
		//Perform page action
		$DbHandle = new DBHandler($PDO, "login", __FILE__);
		$data = ['password' => crypt($validationResult['data']['newPassword'], SALT)];
		$criteria = ['email' => $_SESSION['nipexLogin']['email']];
		$DbHandle->updateData(__LINE__, $data, $criteria);
		
		//Generate response to be sent back
		$_SESSION['response'] = "Password has been successfully changed, you will be automatically logout of the system";
		header("Location: .");
	  exit();
	}
	else {
		$_SESSION['spoofing']="CSRF suspected in  ". __FILE__;
		$_SESSION['dataError']=TRUE;
		header("Location: .");
		exit();
	}