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
		
		//List of staff email
		$allStaff = $User->allUserDetails('staff');
		$allStaffEmail = [];
		if($allStaff){
			foreach ($allStaff as $aStaff) {
				$allStaffEmail[] = $aStaff['email'];
			}
		}
		
		//List of all action
		$allAction = ['delete', 'active', 'inactive'];
		
		//Get validator to validate data sent to this script
		$FormValidator = new Validator();
		
		//Prepare form data for Validator
		$data[] = ['validationString'=>'in list', 'dataName'=>'staffEmail', 'dataValue'=>$_POST['staffEmail'], 'dataList'=>$allStaffEmail];
		$data[] = ['validationString'=>'in list', 'dataName'=>'action', 'dataValue'=>$_POST['action'], 'dataList'=>$allAction];
		
		//Validate sent data
		$validationResult = $FormValidator->formValidation($data);
		if($validationResult['error']){
			if(!$validationResult['data']['staffEmail']) $dataError[] = "Invalid staff";
			if(!$validationResult['data']['action']) $dataError[] = "Invalid action";
			$_SESSION['dataError'] = $dataError;
	  	header("Location: .");
	  	exit();
  	}
		$result = $validationResult['data'];
		
		$userDetails = $User->userDetails($result['staffEmail']);
		//Check action
		if($result['action'] == 'delete'){
			$User->deleteUser($result['staffEmail'], URL, $userDetails['authority']);
		}
		else {
			$DbHandle->updateData(__LINE__, ['status' => $result['action']], ['email' => $result['staffEmail']]);
		}
		
		//Generate response to be sent back
		if($result['action'] == 'delete') $performedAction = "deleted";
		if($result['action'] == 'active') $performedAction = "activated";
		if($result['action'] == 'inactive') $performedAction = "deactivated";
		$_SESSION['response'] = "{$userDetails['name']} has been successfully $performedAction";
		
		header("Location: .");
	  exit();
	}
	else {
		$_SESSION['spoofing']="CSRF suspected in  ". __FILE__;
		$_SESSION['dataError']=TRUE;
		header("Location: .");
		exit();
	}