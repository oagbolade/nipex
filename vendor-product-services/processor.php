<?php
	//Get required files
	require_once '../config.php'; 
	require_once '../db-config.php'; 
	
	//Turn off magic quotes
	Functions::magicQuotesOff();
	
	//Check if the access to this script is coming from its index's page
  if(isset($_POST['token']) && $_POST['token']==$_SESSION['token']){
  	unset($_SESSION['token']);
		
		$DbHandle = new DBHandler($PDO, "login", __FILE__);
		$User = new Users($DbHandle);
		$vendorDetails = $User->userDetails($_SESSION['nipexLogin']['email']);
		
		if($_POST['action'] == 'create'){
			//Get validator to validate data sent to this script
			$FormValidator = new Validator();			
	
			//Data validation
			$file = $FormValidator->formValidationFile($_FILES['dprCertificate0'], ['pdf'], 1100000);
			if($file['error']){
				$dataError[] = $file['error'];
			}
			if(!isset($_POST['productCode0'])){
				$dataError[] = 'No product code was choosen';
			}
			else {
				$productCode = $FormValidator->getSanitizeData($_POST['productCode0']);
			}
			
			//Check for error
			if(isset($dataError)){
				$_SESSION['dataError'] = $dataError;
		  	header("Location: .");
		  	exit();
			}
	
			//Perform page action
			$DbHandle->setTable('que_product_and_services');
			$filename= "{$vendorDetails['vendor_id']}$productCode.{$file['data']['ext']}";
			copy($_FILES['dprCertificate0']['tmp_name'], ROOT."document/dpr-document/$filename");
	 		$data = [
	 			'vendor_id'=>$vendorDetails["vendor_id"], 'products_code'=>$productCode, 
	 			'certificate'=>$filename, 'date_created'=>"NOW()"];
			$DbHandle->createData(__LINE__, $data);
			$response = "uploaded";
		}
		
		if($_POST['action'] == 'delete'){
			//Get validator to validate data sent to this script
			$FormValidator = new Validator();
			
			//prepare data for validation
			$data[] = ['validationString'=>'in list', 'dataName'=>'id', 'dataValue'=>$_POST['id'], 'dataList'=>Functions::numericArray($DbHandle, 'que_product_and_services', 'id')];
	
			//Validate sent data
			$validationResult = $FormValidator->formValidation($data);
			if($validationResult['error']){
				if(!$validationResult['data']['id']) $dataError[] = "Invalid DPR certificate";
				$_SESSION['dataError'] = $dataError;
			  	header("Location: .");
			  	exit();
	  	}
	  	$result = $validationResult['data'];
	
			//Perform page action
			$DbHandle->setTable('que_product_and_services');
			$dpr = $DbHandle->iRetrieveData(__LINE__, ['id' => $result['id']]);
			$DbHandle->deleteData(__LINE__, ['id' => $result['id']]);
			$response = "deleted";
			unlink(ROOT."document/dpr-document/{$dpr[0]['certificate']}");
		}		
		
		//Generate response to be sent back
		$_SESSION['response'] = "DPR Certificate successfully $response";
		header("Location: .");
	  exit();
	}
	else {
		$_SESSION['spoofing']="CSRF suspected in  ". __FILE__;
		$_SESSION['dataError']=TRUE;
		header("Location: .");
		exit();
	}