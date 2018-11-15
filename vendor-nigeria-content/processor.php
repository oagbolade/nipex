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
		if($_POST['nigeriaContent'] == 'yes'){
			$data[] = ['validationString' => 'in list', 'dataName' => 'nigeriaContent', 'dataValue' => $_POST['nigeriaContent'], 'dataList'=>['no', 'yes']];
			$data[] = ['validationString' => 'sanitize', 'dataName' => 'nigeriaContact', 'dataValue' => $_POST['nigeriaContact']];
			if($_POST['emailAddress']) $data[] = ['validationString' => 'email', 'dataName' => 'emailAddress', 'dataValue' => $_POST['emailAddress']];
			$data[] = ['validationString' => 'sanitize', 'dataName' => 'contactTelephone', 'dataValue' => $_POST['contactTelephone']];
			if(isset($_POST['pensionScheme'])) $data[] = ['validationString' => 'in list', 'dataName' => 'pensionScheme', 'dataValue' => $_POST['pensionScheme'], 'dataList'=>['yes', 'no']];
		}
		else {
			$data[] = ['validationString' => 'in list', 'dataName' => 'nigeriaContent', 'dataValue' => $_POST['nigeriaContent'], 'dataList'=>['no', 'yes']];
		}
		//Validate sent data
		$validationResult = $FormValidator->formValidation($data);
		
		if($validationResult['error']){
			if(!$validationResult['data']['emailAddress']) $dataError[] = "Invalid email";
			if(!$validationResult['data']['pensionScheme']) $dataError[] = "Invalid pension scheme choice";
			if(!$validationResult['data']['nigeriaContent']) $dataError[] = "Invalid 'HAVE NIGERIA CONTENT' choice";
			$_SESSION['dataError'] = $dataError;
	  	header("Location: .");
	  	exit();
  	}
  	$result = $validationResult['data'];

		//Perform page action
		$DbHandle = new DBHandler($PDO, "login", __FILE__);
		$User = new Users($DbHandle);
		$vendorDetails = $User->userDetails($_SESSION['nipexLogin']['email']);
		$DbHandle->setTable("que_nigeria_content");
		
		$data = ['nigerian_content_policy'=>$result['nigeriaContent']];
		if($_POST['nigeriaContent'] == 'yes'){
			$data['nigerian_contact_name']=$result['nigeriaContact']; 
			$data['email']=$result['emailAddress']; 
			$data['contact_phone']=$result['contactTelephone']; 
			if(isset($_POST['pensionScheme'])) $data['pension_scheme']=$result['pensionScheme'];
		} 
		if($_POST['nigeriaContent'] == 'no'){
			$data['nigerian_contact_name']=$data['email']=$_POST['emailAddress']= 
			$data['contact_phone']=$data['pension_scheme']=null;
		}
		
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
		$_SESSION['response'] = "Nigerian content has been successfully $response";
		header("Location: .");
	  exit();
	}
	else {
		$_SESSION['spoofing']="CSRF suspected in  ". __FILE__;
		$_SESSION['dataError']=TRUE;
		header("Location: .");
		exit();
	}