<?php
	//Get required files
	require_once '../config.php'; 
	require_once '../db-config.php'; 

	//Turn off magic quotes
	Functions::magicQuotesOff();

	//Check if the access to this script is coming from its index's page
  if(isset($_POST['token']) && $_POST['token']==$_SESSION['token']){
  	// unset($_SESSION['token']);
		//Initialization
		$response = "";
		$constant = [
			'url' => URL, 'urlemail' => URLEMAIL, 'contactemail' => CONTACTEMAIL, 
			'development' => DEVELOPMENT, 'sitename' => SITENAME];
		
		//Get validator to validate data sent to this script
		$FormValidator = new Validator();
		
		//Prepare form data for Validator		
		$data[] = ['validationString'=>'sanitize', 'dataName' => 'title', 'dataValue' => $_POST['title']];
		$data[] = ['validationString'=>'sanitize', 'dataName' => 'firstName', 'dataValue' => $_POST['firstName']];
		$data[] = ['validationString'=>'sanitize', 'dataName'=>'surname', 'dataValue'=>$_POST['surname']];
		$data[] = ['validationString'=>'sanitize', 'dataName'=>'jobTitle', 'dataValue'=>$_POST['jobTitle']];
		$data[] = ['validationString'=>'sanitize', 'dataName'=>'addressLine1', 'dataValue'=>$_POST['addressLine1']];
		$data[] = ['validationString'=>'sanitize', 'dataName'=>'town', 'dataValue'=>$_POST['town']];
		$data[] = ['validationString'=>'sanitize', 'dataName'=>'country', 'dataValue'=>$_POST['country']];
		$data[] = ['validationString'=>'sanitize', 'dataName'=>'state', 'dataValue'=>$_POST['state']];
		$data[] = ['validationString'=>'sanitize', 'dataName'=>'telephone', 'dataValue'=>$_POST['telephone']];
		if (!empty($_POST['email'])) {
			$data[] = ['validationString'=>'email', 'dataName'=>'email', 'dataValue'=>$_POST['email']];
		}else{
			$data[] = ['validationString'=>'sanitize', 'dataName'=>'email', 'dataValue'=>$_POST['email']];
		}
		$data[] = ['validationString'=>'sanitize', 'dataName'=>'currentStaff', 'dataValue'=>$_POST['currentStaff']];
		$data[] = ['validationString'=>'sanitize', 'dataName'=>'prevStaff', 'dataValue'=>$_POST['prevStaff']];
		$data[] = ['validationString'=>'sanitize', 'dataName'=>'pastTwoYearStaff', 'dataValue'=>$_POST['pastTwoYearStaff']];
		$data[] = ['validationString'=>'sanitize', 'dataName'=>'postCode', 'dataValue'=>$_POST['postCode']];
		$data[] = ['validationString'=>'sanitize', 'dataName'=>'addressLine2', 'dataValue'=>$_POST['addressLine2']];
		$data[] = ['validationString'=>'sanitize', 'dataName'=>'comment', 'dataValue'=>$_POST['comment']];
		$data[] = ['validationString'=>'sanitize', 'dataName'=>'otherNames', 'dataValue'=>$_POST['otherNames']];
		$data[] = ['validationString'=>'sanitize', 'dataName'=>'currentProStaff', 'dataValue'=>$_POST['currentProStaff']];
		$data[] = ['validationString'=>'sanitize', 'dataName'=>'prevProStaff', 'dataValue'=>$_POST['prevProStaff']];
		$data[] = ['validationString'=>'sanitize', 'dataName'=>'pastTwoYearProStaff', 'dataValue'=>$_POST['pastTwoYearProStaff']];
		$data[] = ['validationString'=>'sanitize', 'dataName'=>'currentNProStaff', 'dataValue'=>$_POST['currentNProStaff']];
		$data[] = ['validationString'=>'sanitize', 'dataName'=>'prevNProStaff', 'dataValue'=>$_POST['prevNProStaff']];
		$data[] = ['validationString'=>'sanitize', 'dataName'=>'pastTwoYearNProStaff', 'dataValue'=>$_POST['pastTwoYearNProStaff']];
		$data[] = ['validationString'=>'sanitize', 'dataName'=>'currentPermanentStaff', 'dataValue'=>$_POST['currentPermanentStaff']];
		$data[] = ['validationString'=>'sanitize', 'dataName'=>'pastTwoYearPermanentStaff', 'dataValue'=>$_POST['pastTwoYearPermanentStaff']];
		$data[] = ['validationString'=>'sanitize', 'dataName'=>'pastTwoYearProStaff', 'dataValue'=>$_POST['pastTwoYearProStaff']];
		$data[] = ['validationString'=>'sanitize', 'dataName'=>'prevPermanentStaff', 'dataValue'=>$_POST['prevPermanentStaff']];
		$data[] = ['validationString'=>'sanitize', 'dataName'=>'currentContractStaff', 'dataValue'=>$_POST['currentContractStaff']];
		$data[] = ['validationString'=>'sanitize', 'dataName'=>'prevContractStaff', 'dataValue'=>$_POST['prevContractStaff']];
		$data[] = ['validationString'=>'sanitize', 'dataName'=>'pastTwoYearContractStaff', 'dataValue'=>$_POST['pastTwoYearContractStaff']];
		$data[] = ['validationString'=>'sanitize', 'dataName'=>'currentExpatriateStaff', 'dataValue'=>$_POST['currentExpatriateStaff']];
		$data[] = ['validationString'=>'sanitize', 'dataName'=>'prevExpatriateStaff', 'dataValue'=>$_POST['prevExpatriateStaff']];
		$data[] = ['validationString'=>'sanitize', 'dataName'=>'pastTwoYearExpatriateStaff', 'dataValue'=>$_POST['pastTwoYearExpatriateStaff']];
		$data[] = ['validationString'=>'sanitize', 'dataName'=>'currentCommentsStaff', 'dataValue'=>$_POST['currentCommentsStaff']];
		$data[] = ['validationString'=>'sanitize', 'dataName'=>'prevCommentStaff', 'dataValue'=>$_POST['prevCommentStaff']];
		$data[] = ['validationString'=>'sanitize', 'dataName'=>'pastTwoYearCommentsStaff', 'dataValue'=>$_POST['pastTwoYearCommentsStaff']];
		// Executive Personnel
		$function = new Functions();

		$executives = [];
		$executivePosition = $_POST['executivePosition'];
		$executiveTitle = $_POST['executiveTitle'];
		$executiveFirstName = $_POST['executiveFirstName'];
		$executiveSurname = $_POST['executiveSurname'];
		$executiveEmail = $_POST['executiveEmail'];
		$executiveNationality = $_POST['executiveNationality'];
		$executiveOtherName = $_POST['executiveOtherName'];
		for ($i=0; $i < count($executivePosition); $i++) { 
			$executives[] = [
				"no"=>$i,
				"executivePosition" => $FormValidator->getSanitizeData($executivePosition[$i]),
				"executiveTitle" => $FormValidator->getSanitizeData($executiveTitle[$i]),
				"executiveFirstName" => $FormValidator->getSanitizeData($executiveFirstName[$i]),
				"executiveSurname" => $FormValidator->getSanitizeData($executiveSurname[$i]),
				"executiveEmail" => $FormValidator->getSanitizeData($executiveEmail[$i]),
				"executiveNationality" => $FormValidator->getSanitizeData($executiveNationality[$i]),
				"executiveOtherName" => $FormValidator->getSanitizeData($executiveOtherName[$i])
			];	
		}
		
		//Validate sent data
		$validationResult = $FormValidator->formValidation($data);
		if($validationResult['error']){
			if (!empty($_POST['email'])) {
				if(!$validationResult['data']['email']) $dataError[] = "Invalid Email";
			}
			$_SESSION['dataError'] = $dataError;
	  	header("Location: .");
	  	exit();
		}
  	$result = $validationResult['data'];

		//Perform page action
		$DbHandle = new DBHandler($PDO, "login", __FILE__);
		$User = new Users($DbHandle);
		$vendorDetails = $User->userDetails($_SESSION['nipexLogin']['email']);
		$DbHandle->setTable("que_personnel");
		
		$parameter = [
			'Number of staff'=>'Staff', 
			'Number of professional staff'=>'ProStaff', 
			'Number of non-professional staff'=>'NProStaff', 
			'Number of permanent staff'=>'PermanentStaff', 
			'Number of contract staff'=>'ContractStaff', 
			'Number of expatriate staff'=>'ExpatriateStaff', 
			'Additional information/Comments'=>'CommentsStaff'
		];
		foreach ($parameter as $key => $value) {
			$currentYear[$key] = $result["current$value"];
			$previousYear[$key] = $result["prev$value"];
			$lastTwoYears[$key] = $result["pastTwoYear$value"]; 
		}
		//var_dump($currentYear, $previousYear, $currentYear); exit;

		$data = [
			'title'=>$result['title'], 
			'first_name'=>$result['firstName'], 
			'surname'=>$result['surname'], 
			'other_name'=>$result['otherNames'], 
			'job_title'=>$result['jobTitle'],
			'address_1'=>$result['addressLine1'],
			'address_2'=>$result['addressLine2'],
			'town'=>$result['town'], 
			'state'=>$result['state'], 
			'country'=>$result['country'], 
			'postcode'=>$result['postCode'], 
			'phone'=>$result['telephone'], 
			'email'=>$result['email'], 
			'comments'=>$result['comment'], 
			'executives'=>json_encode($executives),
			'current_year'=>json_encode($currentYear), 
			'previous_year'=>json_encode($previousYear), 
			'last_two_years'=>json_encode($lastTwoYears)
		];

		if($nigContent = $DbHandle->iRetrieveData(__LINE__, ["vendor_id"=>$vendorDetails["vendor_id"]])) {
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
		$_SESSION['response'] = "Personnel has been successfully $response";
		header("Location: .");
	  exit();
	}
	else {
		$_SESSION['spoofing']="CSRF suspected in  ". __FILE__;
		$_SESSION['dataError']=TRUE;
		header("Location: .");
		exit();
	}