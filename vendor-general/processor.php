<?php
	//Get required files
	require_once '../config.php'; 
	require_once '../db-config.php'; 
	
	$response = "";
	$constant = [
		'url' => URL, 'urlemail' => URLEMAIL, 'contactemail' => CONTACTEMAIL, 
		'development' => DEVELOPMENT, 'directory' => ROOT.'error', 'sitename' => SITENAME];
	
	//Lock up page
	$DbHandle = new DBHandler($PDO, "login", __FILE__);
	$User = new Users($DbHandle);
	$userDetails = $User->userDetails($_SESSION['nipexLogin']['email']); 
	$vendorDetails = $User->userDetails($_SESSION['nipexLogin']['email']);
	$Authenication = new Authentication($DbHandle);
	$Authenication->setConstants($constant);
	$Authenication->keyToPage();
	$Authenication->pageAccessor(['vendor'], $userDetails['authority']);
	
	//Turn off magic quotes
	Functions::magicQuotesOff();
	
	//Check if the access to this script is coming from its index's page
  if(isset($_POST['token']) && $_POST['token']==$_SESSION['token']){
  	unset($_SESSION['token']);		
		
		//Get validator to validate data sent to this script
		$FormValidator = new Validator();
		
		//Prepare form data for Validator
		if(!empty($_POST['companyName'])){
			$data[] = ['validationString'=>'non empty', 'dataName' => 'companyName', 'dataValue' => $_POST['companyName']];
		}
		if(!empty($_POST['headOfficeAddress'])){
			$data[] = ['validationString'=>'non empty', 'dataName'=>'headOfficeAddress', 'dataValue'=>$_POST['headOfficeAddress']];
		}
		if(!empty($_POST['townCity'])){
			$data[] = ['validationString'=>'non empty', 'dataName'=>'townCity', 'dataValue'=>$_POST['townCity']];
		}
		if(!empty($_POST['stateCounty'])){
			$data[] = ['validationString'=>'non empty', 'dataName'=>'stateCounty', 'dataValue'=>$_POST['stateCounty']];
		}
		if(!empty($_POST['telephone1'])){
			$data[] = ['validationString'=>'non empty', 'dataName'=>'telephone1', 'dataValue'=>$_POST['telephone1']];
		}
		if(!empty($_POST['emailAddress'])){
			$data[] = ['validationString'=>'email', 'dataName'=>'emailAddress', 'dataValue'=>$_POST['emailAddress']];
		}
		if(!empty($_POST['country'])){
			$data[] = ['validationString'=>'in list', 'dataName'=>'country', 'dataValue'=>$_POST['country'], 'dataList'=>Functions::countryCollection()];
		}
		$data[] = ['validationString'=>'sanitize', 'dataName'=>'postCode', 'dataValue'=>$_POST['postCode']];
		$data[] = ['validationString'=>'sanitize', 'dataName'=>'telephone2', 'dataValue'=>$_POST['telephone2']];
		$data[] = ['validationString'=>'sanitize', 'dataName'=>'operationalAddress', 'dataValue'=>$_POST['operationalAddress']];
		$data[] = ['validationString'=>'sanitize', 'dataName'=>'website', 'dataValue'=>$_POST['website']];
		$data[] = ['validationString'=>'sanitize', 'dataName'=>'previousCompanyAddress', 'dataValue'=>$_POST['previousCompanyAddress']];
		$data[] = ['validationString'=>'sanitize', 'dataName'=>'previousCompanyName', 'dataValue'=>$_POST['previousCompanyName']];
		$data[] = ['validationString'=>'sanitize', 'dataName'=>'additionalInformation', 'dataValue'=>$_POST['additionalInformation']];
		
		//Validate sent data
		$validationResult = $FormValidator->formValidation($data);
		if($validationResult['error']){
			if(!$validationResult['data']['companyName']) $dataError[] = "Company name is required";
			if(!$validationResult['data']['headOfficeAddress']) $dataError[] = "Head office Address is required";
			if(!$validationResult['data']['townCity']) $dataError[] = "Town/City is required";
			if(!$validationResult['data']['stateCounty']) $dataError[] = "State/County is required";
			if(!$validationResult['data']['country']) $dataError[] = "Invalid country";
			if(!$validationResult['data']['telephone1']) $dataError[] = "Telephone is required";
			if(!$validationResult['data']['emailAddress']) $dataError[] = "Email Address is invalid";
			$_SESSION['dataError'] = $dataError;
		  	header("Location: .");
		  	exit();
  	}
  	$result = $validationResult['data'];

		//Perform page action
		$DbHandle = new DBHandler($PDO, "login", __FILE__);
		$User = new Users($DbHandle);
		$vendorDetails = $User->userDetails($_SESSION['nipexLogin']['email']); 

		$DbHandle->setTable("que_general");
		$data = [
			'head_office_address' => $result['headOfficeAddress'], 
			'town_city' => $result['townCity'], 
			'post_code' => $result['postCode'], 
			'state_county' => $result['stateCounty'],
			'country' => $result['country'],
			'telephone1' => $result['telephone1'],
			'telephone2' => $result['telephone2'],
			'operational_address' => $result['operationalAddress'],
			'email' => $result['emailAddress'],
			'website' => $result['website'],
			'previous_company_name' => $result['previousCompanyName'],
			'previous_company_address' => $result['previousCompanyAddress'],
			'additional_information' => $result['additionalInformation']
     ];
		if($genContent = $DbHandle->iRetrieveData(__LINE__, ["vendor_id"=>$vendorDetails["vendor_id"]])){
			$criteria = ['vendor_id'=>$vendorDetails["vendor_id"]];
			$DbHandle->updateData(__LINE__, $data, $criteria);
			$response = "updated";
		}
		else{
			$data["vendor_id"] = $vendorDetails["vendor_id"];
			$data["date_created"] = "NOW()";
			$DbHandle->createData(__LINE__, $data);
			$response = "created";
		}
		
		//Generate response to be sent back
		$_SESSION['response'] = "Your data have been $response successfully";
		header("Location: .");
	  exit();
	}
	else {
		$_SESSION['spoofing']="CSRF suspected in  ". __FILE__;
		$_SESSION['dataError']=TRUE;
		header("Location: .");
		exit();
	}