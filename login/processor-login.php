<?php
	//Get required files
	require_once '../config.php'; 
	require_once '../db-config.php'; 
	
	//Turn off magic quotes
	Functions::magicQuotesOff();
	
	//Check if the access to this script is coming from login page
  if(isset($_POST['token']) && $_POST['token'] == $_SESSION['token']){
  	unset($_SESSION['token']);
		//Get validator to validate data sent to this script
		$FormValidator = new Validator();
		
		//Prepare form data for Validator
		if(filter_var($_POST['loginUsername'], FILTER_VALIDATE_EMAIL)){
			$isEmail = true;
			$data[] = ['validationString' => 'email', 'dataName' => 'usernameEmail', 'dataValue' => $_POST['loginUsername']];	
		}
		else {
			$isEmail = false;
			$data[] = ['validationString' => 'non empty', 'dataName' => 'usernameEmail', 'dataValue' => $_POST['loginUsername']];
		}
		$data[] = ['validationString' => 'non empty', 'dataName' => 'password', 'dataValue' => $_POST['loginPassword']];
		
		//Validate sent data
		$validationResult = $FormValidator->formValidation($data);
		if($validationResult['error']){
			$_SESSION['dataError'] = ['form' => 'login', 'message' => ['Login failed']];
	  	header("Location: ".URL);
	  	exit();
  	}
		
		$DbHandle = new DBHandler($PDO, "login", __FILE__);
		$User = new Users($DbHandle);
		$Authenicator = new Authentication($DbHandle);
		$constant = ['salt' => SALT,' url' => URL, 'urlemail' => URLEMAIL, 'contactemail' => CONTACTEMAIL, 'development' => DEVELOPMENT];
		$Authenicator->setConstants($constant);
		$userEmail = $validationResult['data']['usernameEmail'];
		if(!$isEmail) $userEmail = $User->getEmailFrmUsername($validationResult['data']['usernameEmail']);
		if($Authenicator->loginUser($userEmail, $validationResult['data']['password'])){
			$userDetails = $User->userDetails($userEmail);
			//var_dump($userDetails); exit;
			if($userDetails['default_password'] == 'yes'){
				$_SESSION['nipexLogin'] = [];
				header("Location: ".URL."password-change/?email=". urlencode($userDetails['email']) ."&token=". urlencode($userDetails['token']));
			}
			else {
				if($userDetails['authority'] == 'pre-vendor'){
					if(!$userDetails['document']){
						header("Location: ".URL."prevendor-checklist?token={$userDetails['token']}&email={$userDetails['email']}");
					}
					else {
						$outStandingDoc = false;
						foreach (json_decode($userDetails['document'], true) as $aDocument) {
							if($aDocument == "no"){
								$outStandingDoc = true;
								break;
							}
						}
						if($outStandingDoc){
							header("Location: ".URL."prevendor-checklist?token={$userDetails['token']}&email={$userDetails['email']}");
						}
						else {
							header("Location: ".URL."prevendor-payment?token={$userDetails['token']}&email={$userDetails['email']}");	
						}						
					}
				}
				else {
					$redirect = "home";
					//if($userDetails['user_type'] == 'logger') $redirect = "application-payment";
					//if($userDetails['user_type'] == 'applicant') $redirect = "application";
					header("Location: ".URL."$redirect");					
				}
			}
		}
		else {
			$_SESSION['dataError'] = ['form' => 'login', 'message' => ['Login failed']];
			header("Location: ".URL."login");
		}
	  exit();
	}
	else {
		$_SESSION['spoofing']="CSRF suspected in  ". __FILE__;
		$_SESSION['dataError']=TRUE;
		header("Location: .");
		exit();
	}