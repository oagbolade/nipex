<?php
	//Get required files
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
		$DbHandle = new DBHandler($PDO, "login", __FILE__);
		$User = new Users($DbHandle);
		$Functions = new Functions();
		
		//Get validator to validate data sent to this script
		$FormValidator = new Validator();
		
		//Prepare form data for Validator
		$allIDs = Functions::numericArray($DbHandle, 'audit_report', 'id');
		$data[] = ['validationString' => 'in list', 'dataName' => 'reportID', 'dataValue' => $_POST['reportID'], 'dataList'=>$allIDs];
		$data[] = ['validationString' => 'non empty', 'dataName' => 'auditDate', 'dataValue' => $_POST['auditDate']];
				
		//Validate sent data
		$validationResult = $FormValidator->formValidation($data);
		
		if($validationResult['error']){
			if(!$validationResult['data']['reportID']) $dataError[] = "Invalid vendor";
			if(!$validationResult['data']['auditDate']) $dataError[] = "Schedule date is compulsory";
			$_SESSION['dataError'] = $dataError;
	  	header("Location: .");
	  	exit();
  	}
  	$result = $validationResult['data'];
		
		//Update audit date
		$DbHandle->setTable('audit_report');
		$DbHandle->updateData(__LINE__, ['audit_date'=>$result['auditDate'], 'auditor_for_date'=>$_SESSION['nipexLogin']['id']], ['id'=>$result['reportID']]);
		$vendorID = $DbHandle->iRetrieveData(__LINE__, ['id'=>$result['reportID']]);		
		$DbHandle->setTable('vendor');
		$loginID = $DbHandle->iRetrieveData(__LINE__, ['id'=>$vendorID[0]['vendor_id']]);
		$vendorDetails = $User->userDetails($User->getEmailFrmID($loginID[0]['login_id']));

		//Send mail to vendor
		$message = Functions::emailHead(URL);
		$message.="
			<p style='margin-bottom:20px;'>Good Day</p>
			<p style='margin-bottom:8px;'>
				This is to let you know that an audit has been scheduled for your company on
				".date("",strtotime($result['auditDate'])).". This is in completion of the process
				of been a vendor on ".SITENAME."
			</p>
			<p style='margin-bottom:8px;'>
				<span style='font-weight:bold;'>NB</span><br/>
			   If you did not have an account on ".SITENAME." please ignore this mail. Please do 
			   not reply to this mail as it is sent from an unmonitored address. You can contact us via 
			   ".CONTACTEMAIL."
			</p>
		";
		$message .= Functions::footerHead(URL);
		if(!DEVELOPMENT){
			$subject="Audit Date";
	  	$headers  = 'MIME-Version: 1.0' . "\r\n";
	  	$headers .= 'Content-type: text/html; charset=iso-8859-1' . "\r\n";
	  	$headers .= "From: ".SITENAME." <noreply@".URLEMAIL.">" . "\r\n";
			mail($vendorDetails['email'], $subject, $message, $headers);
		}
		
		$_SESSION['response'] = "An audit date of ".date("",strtotime($result['auditDate']))." been successfully scheduled for $company";		
		header("Location: .");
	  exit();
	}
	else {
		$_SESSION['spoofing']="CSRF suspected in  ". __FILE__;
		$_SESSION['dataError']=TRUE;
		header("Location: .");
		exit();
	}