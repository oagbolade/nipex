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
		$data[] = ['validationString' => 'non empty', 'dataName' => 'report', 'dataValue' => $_POST['report']];
		$data[] = ['validationString' => 'in list', 'dataName' => 'auditID', 'dataValue' => $_POST['auditID'], 'dataList'=>Functions::numericArray($DbHandle, 'audit_report', 'id')];
		$noDocumentError = [];
		if($_FILES['upload']['name'][0]){
			$documents = $_POST['document'];
			$uploads = $_FILES['upload'];
			for ($i=0; $i < count($_POST['document'] ); $i++) { 
				if(($uploads['name'][$i] && !$documents[$i]) || (!isset($uploads['name'][$i]) && $documents[$i])){
					$noDocumentError[] = "Document ".($i+1)." was not properly uploaded";
				} 
			}
			
			//Prepare uploaded file for validation
			$noOfFiles = count($uploads['name']);
			$uploadFiles = [];
			for ($i = 0; $i < $noOfFiles; $i++) { 
				$uploadFiles[] = [
					'name'=>$uploads['name'][$i], 'type'=>$uploads['type'][$i], 'tmp_name'=>$uploads['tmp_name'][$i], 
					'error'=>$uploads['error'][$i], 'size'=>$uploads['size'][$i]];
			}	
		}
		
		//Validate uploaded files
		$file = [];
		if($_FILES['upload']['name'][0]){
			foreach ($uploadFiles as $anUpload) {
				$thisFile = $FormValidator->formValidationFile($anUpload, ['pdf'], 1100000); 
				$file[] = ['ext'=>$thisFile['data']['ext'], 'tmp_name'=>$anUpload['tmp_name']];
				if($thisFile['error']) $noDocumentError[] = $thisFile['error']; 
			}	
		}
		
		//Validate sent data
		$validationResult = $FormValidator->formValidation($data);
		
		//Check if there is error in data and uploaded file
		if($validationResult['error'] || $noDocumentError){
			if($validationResult['error']){
				if(!$validationResult['data']['report']) $dataError[] = "Audit report is compulsory";
				$_SESSION['dataError'] = $dataError;	
			}
			if($noDocumentError){
				foreach ($noDocumentError as $aDocumentError) {
					$_SESSION['dataError'][] = $aDocumentError;
				}
			}
	  	header("Location: ".URL."audit-report-submission/?audit={$_POST['auditID']}");
	  	exit();
  	}
  	$result = $validationResult['data'];
		
		//move file and prepare json data
		$json = "";
		if($file){
			$kanter = 0;
			$jsonData = [];
			foreach ($file as $aFile) {
				$filename = ($kanter+1)."{$result['auditID']}.{$aFile['ext']}";
				$jsonData[] = [
					'file caption'=>$FormValidator->getSanitizeData($documents[$kanter]),
					'filename' => $filename];
				++$kanter;
				copy($aFile['tmp_name'], ROOT."document/audit-document/$filename");	
			}
			$json = json_encode($jsonData); 
		}
				
		//Update audit_report data
		$DbHandle->setTable('audit_report');
		$data = [
			'submission_date'=>'NOW()',
			'report'=>$result['report'],
			'upload' => $json,
			'auditor_for_report'=>$_SESSION['nipexLogin']['id']];
		$DbHandle->updateData(__LINE__, $data, ['id'=>$result['auditID']]);
		$auditInfo = $DbHandle->iRetrieveData(__LINE__, ['id'=>$result['auditID']]);
		
		//Update audit table
		$DbHandle->setTable('audit');
		$data = [
			'vendor_id'=>$auditInfo[0]['vendor_id'], 
			'date'=>'NOW()',
			'supervising_officer_show'=>'yes'];
		$DbHandle->createData(__LINE__, $data);
		
		//Send mail to supervisor
		$DbHandle->setTable("login");
		if($reviewOfficers = $DbHandle->iRetrieveData(__LINE__, ['authority'=>'supervising officer', 'status'=>'active'])){
			$loginUrl="<a style='color:#fff; text-decoration:underline;' href='".URL."'>login</a>";
			foreach ($reviewOfficers as $aReviewOfficer) {
				$officerDetails = $User->userDetails($aReviewOfficer['email']);
				$message = Functions::emailHead(URL);
				$message.="
					<p style='margin-bottom:20px;'>Good Day {$officerDetails['name']}  </p>
					<p style='margin-bottom:8px;'>
						This is to let you know that an audit report has been uploaded on ".SITENAME."
						and it is awaiting your action. Please $loginUrl at the earliest possible time to 
						do the needful
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
					$subject="Audit Report awaiting your review";
			  	$headers  = 'MIME-Version: 1.0' . "\r\n";
			  	$headers .= 'Content-type: text/html; charset=iso-8859-1' . "\r\n";
			  	$headers .= "From: ".SITENAME." <noreply@".URLEMAIL.">" . "\r\n";
					mail($aReviewOfficer['email'], $subject, $message, $headers);
				}
			}
		}

		$_SESSION['response'] = "The audit report has been successfully uploaded";		
		header("Location: ".URL."audit-report-submission/?audit={$_POST['auditID']}");
	  exit();
	}
	else {
		$_SESSION['spoofing']="CSRF suspected in  ". __FILE__;
		$_SESSION['dataError']=TRUE;
		header("Location: ".URL."audit-report-submission/?audit={$_POST['auditID']}");
		exit();
	}