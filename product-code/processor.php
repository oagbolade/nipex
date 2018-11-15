<?php
	//Get required files
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
	$Authenication->pageAccessor(['IT'], $userDetails['authority']);
	
	//Check if the access to this script is coming from its index's page
  if(isset($_POST['token']) && $_POST['token']==$_SESSION['token']){
  	unset($_SESSION['token']);
		
		//Get validator to validate data sent to this script
		$FormValidator = new Validator();
		
		$DbHandle->setTable('product_code');
		
		if($_POST['action'] == 'create'){
			//Prepare form data for Validator
			$data[] = ['validationString' => 'non empty', 'dataName' => 'code', 'dataValue' => $_POST['code']];
			$data[] = ['validationString'=>'non empty', 'dataName'=>'service', 'dataValue'=>$_POST['service']];
			$data[] = ['validationString'=>'in list', 'dataName'=>'category', 'dataValue'=>$_POST['category'], 'dataList'=>Functions::dprCategoryCollection()];
			
			//Validate sent data
			$validationResult = $FormValidator->formValidation($data);
			if($validationResult['error']){
				if(!$validationResult['data']['code']) $dataError[] = "Code is compulsory ";
				if(!$validationResult['data']['service']) $dataError[] = "Service is compulsory";
				if(!$validationResult['data']['category']) $dataError[] = "Invalid category";
				$_SESSION['dataError'] = $dataError;
		  	header("Location: .");
		  	exit();
	  	}
			$result = $validationResult['data'];
			$data = [
				'code'=>$result['code'], 
				'service'=>$result['service'],
				'category'=>$result['category'],
			];
			$DbHandle->createData(__LINE__, $data);
			$response = "A new product/service has been successfully created";
		}

		if($_POST['action'] == 'edit'){
			//Prepare form data for Validator
			$data[] = ['validationString' => 'non empty', 'dataName' => 'code', 'dataValue' => $_POST['code']];
			$data[] = ['validationString'=>'non empty', 'dataName'=>'service', 'dataValue'=>$_POST['service']];
			$data[] = ['validationString'=>'in list', 'dataName'=>'category', 'dataValue'=>$_POST['category'], 'dataList'=>Functions::dprCategoryCollection()];
			$data[] = ['validationString'=>'in list', 'dataName'=>'id', 'dataValue'=>$_POST['id'], 'dataList'=>Functions::numericArray($DbHandle, 'product_code', 'id')];
			
			//Validate sent data
			$validationResult = $FormValidator->formValidation($data);
			if($validationResult['error']){
				if(!$validationResult['data']['code']) $dataError[] = "Code is compulsory ";
				if(!$validationResult['data']['service']) $dataError[] = "Product/Service is compulsory";
				if(!$validationResult['data']['category']) $dataError[] = "Invalid category";
				if(!$validationResult['data']['id']) $dataError[] = "Invalid product/service id";
				$_SESSION['dataError'] = $dataError;
		  	header("Location: .");
		  	exit();
	  	}
			$result = $validationResult['data'];
			$data = [
				'code'=>$result['code'], 
				'service'=>$result['service'],
				'category'=>$result['category'],
			];
			$DbHandle->updateData(__LINE__, $data, ['id'=>$result['id']]);
			$response = "A product/service has been successfully changed";
		}

		if($_POST['action'] == 'delete'){
			//Prepare form data for Validator
			$data[] = ['validationString'=>'in list', 'dataName'=>'id', 'dataValue'=>$_POST['id'], 'dataList'=>Functions::numericArray($DbHandle, 'product_code', 'id')];
			
			//Validate sent data
			$validationResult = $FormValidator->formValidation($data);
			if($validationResult['error']){
				if(!$validationResult['data']['id']) $dataError[] = "Invalid product/service id";
				$_SESSION['dataError'] = $dataError;
		  	header("Location: .");
		  	exit();
	  	}
			$result = $validationResult['data'];
			$DbHandle->deleteData(__LINE__, ['id'=>$result['id']]);
			$response = "A service/product has been successfully deleted";
		}
		
		//Generate response to be sent back
		$_SESSION['response'] = $response;
		header("Location: .");
	  exit();
	}
	else {
		$_SESSION['spoofing']="CSRF suspected in  ". __FILE__;
		$_SESSION['dataError']=TRUE;
		header("Location: .");
		exit();
	}