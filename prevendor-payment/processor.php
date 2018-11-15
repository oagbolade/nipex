<?php
	//Get required files
	require_once '../db-config.php';
	
	//Turn off magic quotes
	Functions::magicQuotesOff();
	
	//Check if the access to this script is coming from login page
  if(isset($_POST['token']) && $_POST['token']==$_SESSION['token']){
  	unset($_SESSION['token']);
		
		$DbHandle = new DBHandler($PDO, "login", __FILE__);
		
		//Get validator to validate data sent to this script
		$FormValidator = new Validator();

		//Prepare form data for Validator     
		$data[] = ['validationString'=>'number', 'dataName'=>'amount', 'dataValue'=>$_POST['amount']];
		$data[] = ['validationString'=>'non empty', 'dataName'=>'remitaRef', 'dataValue'=>$_POST['remitaRef']];
		$data[] = ['validationString'=>'non empty', 'dataName'=>'bankName', 'dataValue'=>$_POST['bankName']];		
		$data[] = ['validationString'=>'non empty', 'dataName'=>'accountName', 'dataValue'=>$_POST['accountName']];		
		$data[] = ['validationString'=>'non empty', 'dataName'=>'accountNo', 'dataValue'=>$_POST['accountNo']];
		$data[] = ['validationString'=>'email', 'dataName'=>'email', 'dataValue'=>$_POST['email']];
		
		//Validate sent data
		$validationResult = $FormValidator->formValidation($data);
		if($validationResult['error']){
			if(!$validationResult['data']['amount']) $dataError[] = "Amount is compulsory";
			if(!$validationResult['data']['remitaRef']) $dataError[] = "RRR is compulsory";
			if(!$validationResult['data']['bankName']) $dataError[] = "Bank name is compulsory";
			if(!$validationResult['data']['accountName']) $dataError[] = "Account name is compulsory";
			if(!$validationResult['data']['accountNo']) $dataError[] = "Account No is compulsory";
			if(!$validationResult['data']['email']) $dataError[] = "Invalid Email";
			$_SESSION['dataError'] =  $dataError;
	  	header("Location: ".URL."prevendor-payment?token={$_POST['getToken']}&email={$_POST['email']}");
	  	exit();
  	}
		$result = $validationResult['data'];
		$otherInfo = json_encode([
			'Amount'=>$result['amount'], 
			'RRR'=>$result['remitaRef'], 
			'Bank Name'=>$result['bankName'], 
			'Account Name'=>$result['accountName'], 
			'Account No'=>$result['accountNo'],
			'Status'=>'Under Consideration'
			]);
		$User = new Users($DbHandle);
		$data = [
			'login_id'=>$User->getIDFrmEmailOrUsername($result['email']), 
			'amount'=>$result['amount'], 
			'item'=>'subscription', 
			'other'=>$otherInfo, 
			'date'=>'NOW()'
		];
		
		$DbHandle->setTable('payment');
		$DbHandle->createData(__LINE__, $data);
		
		$_SESSION['response'] = ['status'=>'success', 'message'=>'Your payment details has been save on the system, immediately our Finance Department approve the payment you will be notify via mail. You can also login to check anytime'];
		header("Location: ".URL."prevendor-payment?token={$_POST['getToken']}&email={$_POST['email']}");
	  exit();
	}
	else {
		$_SESSION['spoofing']="CSRF suspected in  ". __FILE__;
		$_SESSION['dataError']=TRUE;
		header("Location: .");
		exit();
	}