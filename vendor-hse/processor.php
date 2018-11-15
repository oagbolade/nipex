<?php
	//Get required files
	require_once '../config.php'; 
	require_once '../db-config.php'; 

	//Turn off magic quotes
	Functions::magicQuotesOff();
	
	//Check if the access to this script is coming from its index's page
  if(isset($_POST['token']) && $_POST['token']==$_SESSION['token']){
  	// unset($_SESSION['token']);
		
  		//Get validator to validate data sent to this script
  		$FormValidator = new Validator();

		//Initialization
		$response = "";
		$constant = [
			'url' => URL, 'urlemail' => URLEMAIL, 'contactemail' => CONTACTEMAIL, 
			'development' => DEVELOPMENT, 'sitename' => SITENAME];

		//Prepare form data for Validator
		$data[] = ['validationString' => 'in list', 'dataName' => 'hsePolicy', 'dataValue' => $_POST['hsePolicy'], 'dataList'=>['Yes', 'No']];
		
		if($_POST['hsePolicy'] == 'Yes'){
			$data[] = ['validationString' => 'sanitize', 'dataName' => 'lastReview', 'dataValue' => $_POST['lastReview']];
			$data[] = ['validationString' => 'sanitize', 'dataName' => 'nameOfPerson', 'dataValue' => $_POST['nameOfPerson']];
			$data[] = ['validationString' => 'sanitize', 'dataName' => 'contactTelephoneNumber', 'dataValue' => $_POST['contactTelephoneNumber']];
			$data[] = ['validationString' => 'sanitize', 'dataName' => 'contactEmail', 'dataValue' => $_POST['contactEmail']];
			
			if(isset($_POST['yourPolicy'])) $data[] = ['validationString' => 'in list', 'dataName' => 'yourPolicy', 'dataValue' => $_POST['yourPolicy'], 'dataList' => ['Yes', 'No']];
			if(isset($_POST['assessmentProcess'])) $data[] = ['validationString' => 'in list', 'dataName' => 'assessmentProcess', 'dataValue' => $_POST['assessmentProcess'], 'dataList'=>['Yes', 'No']];
			if(isset($_POST['contingencyPlans'])) $data[] = ['validationString' => 'in list', 'dataName' => 'contingencyPlans', 'dataValue' => $_POST['contingencyPlans'], 'dataList'=>['Yes', 'No']];
			if(isset($_POST['accidentReporting'])) $data[] = ['validationString' => 'in list', 'dataName' => 'accidentReporting', 'dataValue' => $_POST['accidentReporting'], 'dataList'=>['Yes', 'No']];
			if(isset($_POST['yourWorkforce'])) $data[] = ['validationString' => 'in list', 'dataName' => 'yourWorkforce', 'dataValue' => $_POST['yourWorkforce'], 'dataList'=>['Yes', 'No']];
			if(isset($_POST['minorIncidents'])) $data[] = ['validationString' => 'in list', 'dataName' => 'minorIncidents', 'dataValue' => $_POST['minorIncidents'], 'dataList'=>['Yes', 'No']];
			if(isset($_POST['staffAwareness'])) $data[] = ['validationString' => 'in list', 'dataName' => 'staffAwareness', 'dataValue' => $_POST['staffAwareness'], 'dataList'=>['Yes', 'No']];
			if(isset($_POST['internalOrExternal'])) $data[] = ['validationString' => 'in list', 'dataName' => 'internalOrExternal', 'dataValue' => $_POST['internalOrExternal'], 'dataList'=>['Yes', 'No']];
			if(isset($_POST['trainingRequirements'])) $data[] = ['validationString' => 'in list', 'dataName' => 'trainingRequirements', 'dataValue' => $_POST['trainingRequirements'], 'dataList'=>['Yes', 'No']];
			if(isset($_POST['subcontractors'])) $data[] = ['validationString' => 'in list', 'dataName' => 'subcontractors', 'dataValue' => $_POST['subcontractors'], 'dataList'=>['Yes', 'No']];
			if(isset($_POST['risksAssociated'])) $data[] = ['validationString' => 'in list', 'dataName' => 'risksAssociated', 'dataValue' => $_POST['risksAssociated'], 'dataList'=>['Yes', 'No']];
			if(isset($_POST['drugsAlcohol'])) $data[] = ['validationString' => 'in list', 'dataName' => 'drugsAlcohol', 'dataValue' => $_POST['drugsAlcohol'], 'dataList'=>['Yes', 'No']];
			if(isset($_POST['internalAudits'])) $data[] = ['validationString' => 'in list', 'dataName' => 'internalAudits', 'dataValue' => $_POST['internalAudits'], 'dataList'=>['Yes', 'No']];
			if(isset($_POST['healthInsurance'])) $data[] = ['validationString' => 'in list', 'dataName' => 'healthInsurance', 'dataValue' => $_POST['healthInsurance'], 'dataList'=>['Yes', 'No']];
			
			$data[] = ['validationString' => 'sanitize', 'dataName' => 'additionalInfo1', 'dataValue' => $_POST['additionalInfo1']];
			
		}
		

		if (isset($_POST['managementSystem'])) $data[] = ['validationString' => 'in list', 'dataName' => 'managementSystem', 'dataValue' => $_POST['managementSystem'], 'dataList' => ['Yes', 'No']];
		if (isset($_POST['standardsOrGuidelines']))$data[] = ['validationString' => 'in list', 'dataName' => 'standardsOrGuidelines', 'dataValue' => $_POST['standardsOrGuidelines'], 'dataList' => ['Yes', 'No']];
		if (isset($_POST['systemCertified'])) $data[] = ['validationString' => 'in list', 'dataName' => 'systemCertified', 'dataValue' => $_POST['systemCertified'], 'dataList' => ['Yes', 'No']];
		$data[] = ['validationString' => 'sanitize', 'dataName' => 'nameOfCertifyingBody', 'dataValue' => $_POST['nameOfCertifyingBody']];
		$data[] = ['validationString' => 'sanitize', 'dataName' => 'certificateNumber', 'dataValue' => $_POST['certificateNumber']];
		$data[] = ['validationString' => 'sanitize', 'dataName' => 'expiryDate', 'dataValue' => $_POST['expiryDate']];
		if (isset($_POST['companyWorking'])) $data[] = ['validationString' => 'in list', 'dataName' => 'companyWorking', 'dataValue' => $_POST['companyWorking'], 'dataList' => ['Yes', 'No']];
		
		$data[] = ['validationString' => 'sanitize', 'dataName' => 'calenderYear1', 'dataValue' => $_POST['calenderYear1']];
		$data[] = ['validationString' => 'sanitize', 'dataName' => 'calenderYear2', 'dataValue' => $_POST['calenderYear2']];
		$data[] = ['validationString' => 'sanitize', 'dataName' => 'calenderYear3', 'dataValue' => $_POST['calenderYear3']];
		$data[] = ['validationString' => 'sanitize', 'dataName' => 'totalManHours1', 'dataValue' => $_POST['totalManHours1']];
		$data[] = ['validationString' => 'sanitize', 'dataName' => 'totalManHours2', 'dataValue' => $_POST['totalManHours2']];
		$data[] = ['validationString' => 'sanitize', 'dataName' => 'totalManHours3', 'dataValue' => $_POST['totalManHours3']];
		$data[] = ['validationString' => 'sanitize', 'dataName' => 'lostTimeIncidents1', 'dataValue' => $_POST['lostTimeIncidents1']];
		$data[] = ['validationString' => 'sanitize', 'dataName' => 'lostTimeIncidents2', 'dataValue' => $_POST['lostTimeIncidents2']];
		$data[] = ['validationString' => 'sanitize', 'dataName' => 'lostTimeIncidents3', 'dataValue' => $_POST['lostTimeIncidents3']];
		$data[] = ['validationString' => 'sanitize', 'dataName' => 'numberOfFatalities1', 'dataValue' => $_POST['numberOfFatalities1']];
		$data[] = ['validationString' => 'sanitize', 'dataName' => 'numberOfFatalities2', 'dataValue' => $_POST['numberOfFatalities2']];
		$data[] = ['validationString' => 'sanitize', 'dataName' => 'numberOfFatalities3', 'dataValue' => $_POST['numberOfFatalities3']];
		$data[] = ['validationString' => 'sanitize', 'dataName' => 'additionalInfo3', 'dataValue' => $_POST['additionalInfo3']];
			
		//Validate sent data
		$validationResult = $FormValidator->formValidation($data);
		if($validationResult['error']){
			if(!$validationResult['data']['hsePolicy']) $dataError[] = "HSE Policy required";
			if($_POST['hsePolicy'] == 'Yes'){
				if(isset($_POST['yourPolicy'])) if(!$validationResult['data']['yourPolicy']) $dataError[] = "Invalid Staff policy and objective";
				if(isset($_POST['assessmentProcess'])) if(!$validationResult['data']['assessmentProcess']) $dataError[] = "Invalid Risk Assessment Process";
				if(isset($_POST['contingencyPlans'])) if(!$validationResult['data']['contingencyPlans']) $dataError[] = "Invalid Dealing with contigency plan is required";
				if(isset($_POST['accidentReporting'])) if(!$validationResult['data']['accidentReporting']) $dataError[] = "Invalid Accident Reporting Procedure";
				if(isset($_POST['yourWorkforce'])) if(!$validationResult['data']['yourWorkforce']) $dataError[] = "Invalid Workforce with adequate PPE is required";
				if(isset($_POST['minorIncidents'])) if(!$validationResult['data']['minorIncidents']) $dataError[] = "Invalid System to treat minor incidence is required";
				if(isset($_POST['staffAwareness'])) if(!$validationResult['data']['staffAwareness']) $dataError[] = "Invalid Staff awareness training";
				if(isset($_POST['internalOrExternal'])) if(!$validationResult['data']['internalOrExternal']) $dataError[] = "Invalid Internal and external training required";
				if(isset($_POST['trainingRequirements'])) if(!$validationResult['data']['trainingRequirements']) $dataError[] = "Invalid Up to date training requirement is required";
				if(isset($_POST['subcontractors'])) if(!$validationResult['data']['subcontractors']) $dataError[] = "Invalid Competence of subcontrators on HSE matters is required";
				if(isset($_POST['risksAssociated'])) if(!$validationResult['data']['risksAssociated']) $dataError[] = "Invalid Risk associated with driving and transport is required";
				if(isset($_POST['drugsAlcohol'])) if(!$validationResult['data']['drugsAlcohol']) $dataError[] = "Invalid Drugs and Alcohol Abuse policy is required";
				if(isset($_POST['internalAudits'])) if(!$validationResult['data']['internalAudits']) $dataError[] = "Invalid Monitoring/Internal audits of HSE is required";
				if(isset($_POST['healthInsurance'])) if(!$validationResult['data']['healthInsurance']) $dataError[] = "Invalid Health Insurance Scheme is required";
			}
			if(isset($_POST['managementSystem'])) if(!$validationResult['data']['managementSystem']) $dataError[] = "Invalid HSE management system";
			if(isset($_POST['standardsOrGuidelines'])) if(!$validationResult['data']['standardsOrGuidelines']) $dataError[] = "Invalid Provide state applicable standards";
			if(isset($_POST['systemCertified'])) if(!$validationResult['data']['systemCertified']) $dataError[] = "Invalid System certified";
			if(isset($_POST['companyWorking'])) if(!$validationResult['data']['companyWorking']) $dataError[] = "Invalid company working toward it";
			
			$_SESSION['dataError'] = $dataError;
	  	header("Location: .");
	  	exit();
  	}
  	$result = $validationResult['data'];
  	
  		//Perform page action
			$DbHandle = new DBHandler($PDO, "login", __FILE__);
			$User = new Users($DbHandle);
			$vendorDetails = $User->userDetails($_SESSION['nipexLogin']['email']); 
			$DbHandle->setTable("que_hse");
			$year1 = json_encode(
				[
					'calender year1'=>$_POST['calenderYear1'], 
					'total manh1'=>$_POST['totalManHours1'], 
					'lost time1'=>$_POST['lostTimeIncidents1'],
					'number of facilities1'=>$_POST['numberOfFatalities1']
				]
			);
			$year2 = json_encode(
				[
					'calender year2'=>$_POST['calenderYear2'], 
					'total manh2'=>$_POST['totalManHours2'], 
					'lost time2'=>$_POST['lostTimeIncidents2'],
					'number of facilities2'=>$_POST['numberOfFatalities2']
				]
			);
			$year3 = json_encode(
				[
					'calender year3'=>$_POST['calenderYear3'], 
					'total manh3'=>$_POST['totalManHours3'], 
					'lost time3'=>$_POST['lostTimeIncidents3'],
					'number of facilities3'=>$_POST['numberOfFatalities3']
				]
			);
			
			$data = [
				'hse_policy'=> $result['hsePolicy'], 
				'last_review_date' => $result['lastReview'], 
				'name_of_person' => $result['nameOfPerson'], 
				'phone_no' => $result['contactTelephoneNumber'],
				'email' => $result['contactEmail'],
				'additional_info3' => $result['additionalInfo3'],
				'certifying_body' => $result['nameOfCertifyingBody'],
				'certificate_number' => $result['certificateNumber'],
				'year1' => $year1,
				'year2' => $year2,
				'year3' => $year3
	   	];
			if(isset($_POST['managementSystem'])) $data['management_system']= $result['managementSystem'];
			if(isset($_POST['standardsOrGuidelines'])) $data['standards_guideline']= $result['standardsOrGuidelines'];
			if(isset($_POST['managementSystem'])) $data['system_certified']= $result['managementSystem'];
			if(isset($_POST['companyWorking'])) $data['your_company']= $result['companyWorking'];
			if($_POST['expiryDate']) $data['expiry_date']= $result['expiryDate'];
			if($_POST['hsePolicy'] == 'Yes'){
				if(isset($_POST['yourPolicy'])) $data['policy_objective']= $result['yourPolicy'];
				if(isset($_POST['assessmentProcess'])) $data['hards_risk']= $result['assessmentProcess'];
				if(isset($_POST['contingencyPlans'])) $data['contigency_plan']= $result['contingencyPlans'];
				if(isset($_POST['accidentReporting'])) $data['reporting_procedure']= $result['accidentReporting'];
				if(isset($_POST['yourWorkforce'])) $data['adequate_ppe']= $result['yourWorkforce'];
				if(isset($_POST['minorIncidents'])) $data['minor_incident']= $result['minorIncidents'];
				if(isset($_POST['staffAwareness'])) $data['training_of_hse']= $result['staffAwareness'];
				if(isset($_POST['internalOrExternal'])) $data['external_internaml']= $result['internalOrExternal'];
				if(isset($_POST['trainingRequirements'])) $data['uptodate']= $result['trainingRequirements'];
				if(isset($_POST['subcontractors'])) $data['subcontractors_competence']= $result['subcontractors'];
				if(isset($_POST['risksAssociated'])) $data['driving_transport']= $result['risksAssociated'];
				if(isset($_POST['drugsAlcohol'])) $data['drugs_alcohol']= $result['drugsAlcohol'];
				if(isset($_POST['internalAudits'])) $data['hse_internal_audit']= $result['internalAudits'];
				if(isset($_POST['healthInsurance'])) $data['health_insurance_scheme']= $result['healthInsurance'];
				$data['additional_info1']= $result['additionalInfo1'];
			}
      
			if($genContent = $DbHandle->iRetrieveData(__LINE__, ["vendor_id"=>$vendorDetails["vendor_id"]])){
				$criteria = ['vendor_id'=>$vendorDetails["vendor_id"]];
				if($_POST['hsePolicy'] == 'No'){
					$data['policy_objective']=$data['hards_risk']=$data['contigency_plan']=
					$data['reporting_procedure']=$data['adequate_ppe']=$data['minor_incident']=
					$data['training_of_hse']=$data['external_internaml']=$data['uptodate']=
					$data['subcontractors_competence']=$data['driving_transport']=$data['drugs_alcohol']=
					$data['hse_internal_audit']=$data['health_insurance_scheme']=null;
					$data['additional_info1']="";
				}	
				$DbHandle->updateData(__LINE__, $data, $criteria);
				$response = "updated";
			}
			else{
				$data["vendor_id"] = $vendorDetails["vendor_id"];
				$data["date_created"] = "NOW()";
				$DbHandle->createData(__LINE__, $data);
				$response = "saved";
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