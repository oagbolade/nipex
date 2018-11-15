<?php
	//Get required files
	require_once '../config.php'; 
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
	$Authenication->pageAccessor(['vendor'], $userDetails['authority']);
	
	//Check if the access to this script is coming from its index's page
  if(isset($_POST['token']) && $_POST['token']==$_SESSION['token']){
  	unset($_SESSION['token']);
		
		//Get validator to validate data sent to this script
		$FormValidator = new Validator();
		
		//Prepare form data for Validator
		$data[] = ['validationString' => 'in list', 'dataName' => 'documentedQms', 'dataValue' => $_POST['documentedQms'], 'dataList'=>['yes', 'no']];
		$data[] = ['validationString' => 'in list', 'dataName' => 'policyObjective', 'dataValue' => $_POST['policyObjective'], 'dataList'=>['yes', 'no']];
		$data[] = ['validationString' => 'in list', 'dataName' => 'documentedPolicy', 'dataValue' => $_POST['documentedPolicy'], 'dataList'=>['yes', 'no']];
		$data[] = ['validationString' => 'in list', 'dataName' => 'systemCertified', 'dataValue' => $_POST['systemCertified'], 'dataList'=>['yes', 'no']];
		$data[] = ['validationString' => 'in list', 'dataName' => 'partyAccreditation', 'dataValue' => $_POST['partyAccreditation'], 'dataList'=>['yes', 'no']];
		
		$data[] = ['validationString' => 'sanitize', 'dataName' => 'lastReviewDate', 'dataValue' => $_POST['lastReviewDate']];
		$data[] = ['validationString' => 'sanitize', 'dataName' => 'relevantStandard', 'dataValue' => $_POST['relevantStandard']];
		$data[] = ['validationString' => 'sanitize', 'dataName' => 'certifyingAuthority', 'dataValue' => $_POST['certifyingAuthority']];
		$data[] = ['validationString' => 'sanitize', 'dataName' => 'certificateNumber', 'dataValue' => $_POST['certificateNumber']];
		$data[] = ['validationString' => 'sanitize', 'dataName' => 'responsibleForQms', 'dataValue' => $_POST['responsibleForQms']];
		$data[] = ['validationString' => 'sanitize', 'dataName' => 'contactNumber', 'dataValue' => $_POST['contactNumber']];
		if (!empty($_POST['contactEmail'])) {
			$data[] = ['validationString' => 'email', 'dataName' => 'contactEmail', 'dataValue' => $_POST['contactEmail']];
		}else{
			$data[] = ['validationString' => 'sanitize', 'dataName' => 'contactEmail', 'dataValue' => $_POST['contactEmail']];
		}
		$data[] = ['validationString' => 'sanitize', 'dataName' => 'comments', 'dataValue' => $_POST['comments']];

		// Validate sent data
		$validationResult = $FormValidator->formValidation($data);
		if($validationResult['error']){
			if(!$validationResult['data']['documentedQms']) $dataError[] = "choose an option from documented quality management";
			if(!$validationResult['data']['documentedPolicy']) $dataError[] = "choose an option from documented policy";
			if(!$validationResult['data']['policyObjective']) $dataError[] = "choose an option from aware of  policy";
			if(!$validationResult['data']['systemCertified']) $dataError[] = "choose an option from system certified";
			if(!$validationResult['data']['partyAccreditation']) $dataError[] = "choose an option from third party accreditation";
			if(!$validationResult['data']['contactEmail']) $dataError[] = "Invalid email";
			$_SESSION['dataError'] = $dataError;
	  	header("Location: .");
	  	exit();
		}
		$result = $validationResult['data'];
		
		//Perform page action
		$DbHandle = new DBHandler($PDO, "login", __FILE__);
		$User = new Users($DbHandle);
		$vendorDetails = $User->userDetails($_SESSION['nipexLogin']['email']);
		$DbHandle->setTable("que_quality_management");
		$data = [ 
			'quality_mgt_system'=>$result['documentedQms'], 'quality_policy'=>$result['documentedPolicy'], 
			'last_review_date'=>$result['lastReviewDate'], 'staff_aware_policy'=>$result['policyObjective'], 
			'certified_system'=>$result['systemCertified'],'third_party_accreditation'=>$result['partyAccreditation'],
			'responsible_for_qms'=>$result['responsibleForQms'],'phone'=>$result['contactNumber'], 
			'email'=>$result['contactEmail'], 'comments'=>$result['comments'],'relevant_standard'=>$result['relevantStandard'],
			'certifying_authority'=>$result['certifyingAuthority'], 'certificate_number'=>$result['certificateNumber']];
		
		if ($nigContent = $DbHandle->iRetrieveData(__LINE__, ["vendor_id"=>$vendorDetails["vendor_id"]])) {
			$criteria = ['vendor_id'=>$vendorDetails["vendor_id"]];
			$DbHandle->updateData(__LINE__, $data, $criteria);
			$response = "updated";
		}else{
			$data["vendor_id"] = $vendorDetails["vendor_id"];
			$data["date_created"] = "NOW()";
			$DbHandle->createData(__LINE__, $data);
			$response = "created";
		}

		//Generate response to be sent back
		$_SESSION['response'] = "Quality management has been successfully $response";
		header("Location: .");
	  exit();
	}
	else {
		$_SESSION['spoofing']="CSRF suspected in  ". __FILE__;
		$_SESSION['dataError']=TRUE;
		header("Location: .");
		exit();
	}