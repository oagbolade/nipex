<?php
	//Get required files
	require_once '../config.php'; 
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
		if (!empty($_POST['firstYear'])) {
			$data[] = ['validationString' => 'non empty', 'dataName' => 'firstYear', 'dataValue' => $_POST['firstYear']];
		}else{
			$data[] = ['validationString' => 'sanitize', 'dataName' => 'firstYear', 'dataValue' => $_POST['firstYear']];
		}
		if (!empty($_POST['companyType'])) {
			$data[] = ['validationString' => 'non empty', 'dataName' => 'companyType', 'dataValue' => $_POST['companyType']];
		}else{
			$data[] = ['validationString' => 'sanitize', 'dataName' => 'companyType', 'dataValue' => $_POST['companyType']];
		}
		if (!empty($_POST['countryRegistration'])) {
			$data[] = ['validationString' => 'non empty', 'dataName' => 'countryRegistration', 'dataValue' => $_POST['countryRegistration']];
		}else{
			$data[] = ['validationString' => 'sanitize', 'dataName' => 'countryRegistration', 'dataValue' => $_POST['countryRegistration']];
		}
		if (!empty($_POST['registrationYear'])) {
			$data[] = ['validationString' => 'non empty', 'dataName' => 'registrationYear', 'dataValue' => $_POST['registrationYear']];
		}else{
			$data[] = ['validationString' => 'sanitize', 'dataName' => 'registrationYear', 'dataValue' => $_POST['registrationYear']];
		}
		$data[] = ['validationString' => 'sanitize', 'dataName' => 'associatedName', 'dataValue' => $_POST['associatedName']];
		$data[] = ['validationString' => 'sanitize', 'dataName' => 'cacNumber', 'dataValue' => $_POST['cacNumber']];
		$data[] = ['validationString' => 'sanitize', 'dataName' => 'additionalComment', 'dataValue' => $_POST['additionalComment']];
		
		$owners = [];
		$directors = $_POST['director']; $nationalitys = $_POST['nationality'];
		$genders = $_POST['gender']; $ownerships = $_POST['ownership'];
		for ($i=0; $i < count($directors); $i++) { 
			$owners[] = [
				"no"=>$i,
				"director" => $FormValidator->getSanitizeData($directors[$i]),
				"nationality" => $FormValidator->getSanitizeData($nationalitys[$i]),
				"gender" => $FormValidator->getSanitizeData($genders[$i]),
				"ownership" => $FormValidator->getSanitizeData($ownerships[$i])
			];	
		}
		
		//Validate sent data
		$validationResult = $FormValidator->formValidation($data);
		if($validationResult['error']){
			if (!empty($_POST['firstYear'])) {
				if(!$validationResult['data']['firstYear']) $dataError[] = "Indicate when your business commenced";
			}
			if (!empty($_POST['companyType'])) {
				if(!$validationResult['data']['companyType']) $dataError[] = "Indicate your company type";
			}
			if (!empty($_POST['countryRegistration'])) {
				if(!$validationResult['data']['countryRegistration']) $dataError[] = "Indicate the country of registration";
			}
			if (!empty($_POST['registrationYear'])) {
				if(!$validationResult['data']['registrationYear']) $dataError[] = "Indicate registration year";
			}
			if (!empty($_POST['cacNumber'])) {
				if(!$validationResult['data']['cacNumber']) $dataError[] = "Provide your CAC Number";
			}
			$_SESSION['dataError'] = $dataError;
		  	header("Location: .");
	  	exit();
  	}
  	$result = $validationResult['data'];

		// Perform page action
		$DbHandle = new DBHandler($PDO, "login", __FILE__);
		$User = new Users($DbHandle);
		$vendorDetails = $User->userDetails($_SESSION['nipexLogin']['email']);
		$DbHandle->setTable("que_legal");

		$data = [
			'business_commencement_year'=>$result['firstYear'], 
			'company_type'=>$result['companyType'], 
			'country_of_registration'=>$result['countryRegistration'], 
			'cac_no'=>$result['cacNumber'], 
			'registration_year'=>$result['registrationYear'], 
			'comments'=>$result['additionalComment'], 
			'associated_company'=>$result['associatedName'], 
			'shareholder'=>json_encode($owners), 
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
		$_SESSION['response'] = "Legal has been successfully $response";
		header("Location: .");
	  exit();
	}
	else {
		$_SESSION['spoofing']="CSRF suspected in  ". __FILE__;
		$_SESSION['dataError']=TRUE;
		header("Location: .");
		exit();
	}