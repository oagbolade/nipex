<?php
	//Get required files
	require_once '../db-config.php'; 
	
	//Turn off magic quotes
	Functions::magicQuotesOff();
	
	//Check if the access to this script is coming from login page
  if(isset($_POST['token']) && $_POST['token']==$_SESSION['token']){
  	unset($_SESSION['token']);
		//Get validator to validate data sent to this script
		$FormValidator = new Validator();
		
		//Check if password supplied are equal
		$passwordDiffError = false;
		if($_POST['newPassword'] != $_POST['repeatNewPassword']) $passwordDiffError = true;
		
		//Prepare form data for Validator
		$data[] = ['validationString'=>'non empty', 'dataName'=>'companyName', 'dataValue'=>$_POST['companyName']];
		$data[] = ['validationString'=>'non empty', 'dataName'=>'phoneNo', 'dataValue'=>$_POST['phoneNo']];
		$data[] = ['validationString'=>'non empty', 'dataName'=>'rcNo', 'dataValue'=>$_POST['rcNo']];		
		$data[] = ['validationString'=>'email', 'dataName'=>'companyEmail', 'dataValue'=>$_POST['companyEmail']];		
		$data[] = ['validationString'=>'password rule', 'dataName'=>'password', 'dataValue'=>$_POST['newPassword']];
		
		//Validate sent data
		$validationResult = $FormValidator->formValidation($data);
		if($validationResult['error'] || $passwordDiffError){
    	$_SESSION['dataError']['form'] = 'register';
			if(!$validationResult['data']['companyName']) $dataError[] = "Company name is compulsory";
			if(!$validationResult['data']['phoneNo']) $dataError[] = "Phone no is compulsory";
			if(!$validationResult['data']['rcNo']) $dataError[] = "RC Number is compulsory";
			if(!$validationResult['data']['companyEmail']) $dataError[] = "Invalid email";
			if(!$validationResult['data']['password']) $dataError[] = "Invalid password (minimum 8 characters)";
			if($_POST['newPassword'] != $_POST['repeatNewPassword']) $dataError[] = "Password and repeated password differs";
			$_SESSION['dataError'] = ['form' => 'register', 'message' => $dataError];
	  	header("Location: ".URL."login#signup");
	  	exit();
  	}
		
		$DbHandle = new DBHandler($PDO, "login", __FILE__);
		$User = new Users($DbHandle);
		$functions = new Functions();
		$value = $validationResult['data'];
		$data = [
			'company name' => $value['companyName'],
			'company phone' => $value['phoneNo'],
			'rc no' => $value['rcNo'],
			'email' => $value['companyEmail'], 
			'password' => $value['password'],
			];
		if($response = $User->createLogger($functions, $data, __LINE__, 'pre-vendor')){
			$_SESSION['response'] = ['form' => 'register', 'message' => "Check your company's email '{$_POST['newEmail']}' for <strong>activation link </strong> and the list of mandatory documents/information"];
			if(DEVELOPMENT) $_SESSION['response']['message'] = $response;
		}
		else {
			$_SESSION['dataError'] = ['form' => 'register', 'message' => ["{$_POST['companyEmail']} is associated with another company"]];
		}
		header("Location: ".URL."login#signup");
	  exit();
	}
	else {
		$_SESSION['spoofing']="CSRF suspected in  ". __FILE__;
		$_SESSION['dataError']=TRUE;
		header("Location: .");
		exit();
	}