<?php
	//Get required files
	require_once '../config.php';
	require_once '../db-config.php';
	
	//Initialization
	$response = "";
	$constant = [
		'url' => URL, 'urlemail' => URLEMAIL, 'contactemail' => CONTACTEMAIL, 
		'development' => DEVELOPMENT, 'directory' => ROOT.'error', 'sitename' => SITENAME];
	$pageName = "Health and Safety";
	
	//Lock up page
	$DbHandle = new DBHandler($PDO, "login", __FILE__);
	$User = new Users($DbHandle);
	$vendorDetails = $User->userDetails($_SESSION['nipexLogin']['email']); 
	$Authenication = new Authentication($DbHandle);
	$Authenication->setConstants($constant);
	$Authenication->keyToPage();
	$Authenication->pageAccessor(['vendor'], $vendorDetails['authority']);
	
	$_SESSION['token'] = md5(TOKENRAW);
	
	$Tag = new Tag(URL);
	$head = $Tag->createHead(SITENAME." | $pageName ", "nav-md home-page", ['css' => ['css/nprogress.css']]);
	
	$menu = $Tag->createSideBar($PDO, $vendorDetails['email'], ['parent'=>'Questionnaire', 'child'=>'HSE Information']);
	$mastHead = $Tag->createMastHead($PDO, $vendorDetails['email']);
	$slogan = $Tag->createFooterSlogan();
	$footer = $Tag->createFooter(['js/custom.js', 'js/hse.js']);
	$functions = new Functions();
	
	//Error in data sent for processing
	if(isset($_SESSION['dataError'])){
		if(!isset($_SESSION['spoofing'])){
			$content = "<ul>";
			foreach ($_SESSION['dataError'] as $aMessage) {
				$content .= "<li class='text-left'>$aMessage</li>";	
			}
			$content .= "</ul>";
			$response = $Tag->createAlert("", $content, 'danger', false);
		}
		else{
			$ErrorAlerter = new ErrorAlert($_SESSION['spoofing'], $functions, $constant);
			$ErrorAlerter->sendAlerts();
			$response = $Tag->createAlert("System Error", "Ouch we are sorry something went wrong, we think your internet connection may be slow", 'danger', true);
			unset($_SESSION['spoofing']);
		}
		unset($_SESSION['dataError']);
	}
	
	//Response after data processing
	if(isset($_SESSION['response'])){
		$response = $Tag->createAlert("", $_SESSION['response'], 'success', false);
		unset($_SESSION['response']);
	}

	$hsePolicyNo = "";
	$hsePolicyYes = "";
	$hsePolicyObjectiveYes = $hsePolicyObjectiveNo = "";

	$lastReview = "";
	$nameOfPerson = "";
	$contactTelephoneNumber = "";
	$contactEmail = "";

	$additionalInformation = "";

	$assessmentProcessYes = "";
	$assessmentProcessNo = "";

	$contingencyPlansNo = "";
	$contingencyPlansYes = "";

	$accidentReportingYes = "";
	$accidentReportingNo = "";

	$yourWorkforce = "";
	$minorIncidentsYes= "";
	$minorIncidentsNo = "";
	$staffAwareness = "";

	$internalOrExternalYes = "";
	$internalOrExternalNo = "";

	$trainingRequirementsYes = "";
	$trainingRequirementsNo = "";

	$subcontractorsYes = "";
	$subcontractorsNo = "";
	$risksAssociatedYes = "";
	$risksAssociatedNo = "";

	$drugsAlcoholYes = "";
	$drugsAlcoholNo = "";

	$internalAuditsNo = "";
	$internalAuditsYes = "";

	$healthInsuranceNo = "";
	$healthInsuranceYes = "";

	$additionalInfo1 = "";
	$additionalInfo3 = "";

	$staffAwarenessYes = "";
	$staffAwarenessNo = "";

	$managementSystemNo = "";
	$managementSystemYes = "";

	$standardsOrGuidelinesNo = "";
	$standardsOrGuidelinesYes = "";

	$systemCertifiedYes = "";
	$systemCertifiedNo = "";

	$nameOfCertifyingBody = "";
	$certificateNumber = "";
	$expiryDate = "";

	$companyWorkingYes = "";
	$companyWorkingNo = "";

	$yourWorkforceYes = "";
	$yourWorkforceNo = "";

	$year1['calender year1'] = '';
  $year1['total manh1'] = '';
  $year1['lost time1'] = '';
  $year1['number of facilities1'] = '';

  $year2['calender year2'] = '';
  $year2['total manh2'] = '';
  $year2['lost time2'] = '';
  $year2['number of facilities2'] = '';

	$year3['calender year3'] = '';
  $year3['total manh3'] = '';
  $year3['lost time3'] = '';
  $year3['number of facilities3'] = '';
  $completion = 0;
	$DbHandle->setTable("que_hse");
	if ($content = $DbHandle->iRetrieveData(__LINE__, ["vendor_id"=>$vendorDetails["vendor_id"]])) {
		
		$hsePolicyNo = ($content[0]["hse_policy"] == "No") ? "checked" : "";
		$hsePolicyYes = ($content[0]["hse_policy"] == "Yes") ? "checked" : "";
		
		$hsePolicyObjectiveYes = ($content[0]["policy_objective"] == "Yes") ? "checked" : "";
		$hsePolicyObjectiveNo = ($content[0]["policy_objective"] == "No") ? "checked" : "";

		$lastReview = $content[0]["last_review_date"];
		$nameOfPerson = $content[0]["name_of_person"];
		$contactTelephoneNumber = $content[0]["phone_no"];
		$contactEmail = $content[0]["email"];

		$contingencyPlansNo = ($content[0]["contigency_plan"] == "No") ? "checked" : "";
		$contingencyPlansYes = ($content[0]["contigency_plan"] == "Yes") ? "checked" : "";

		$accidentReportingNo = ($content[0]["reporting_procedure"] == "No") ? "checked" : "";
		$accidentReportingYes = ($content[0]["reporting_procedure"] == "Yes") ? "checked" : "";

		$yourWorkforceNo = ($content[0]["adequate_ppe"] == "No") ? "checked" : "";
		$yourWorkforceYes = ($content[0]["adequate_ppe"] == "Yes") ? "checked" : "";

		$minorIncidentsNo = ($content[0]["minor_incident"] == "No") ? "checked" : "";
		$minorIncidentsYes = ($content[0]["minor_incident"] == "Yes") ? "checked" : "";

		$staffAwarenessNo = ($content[0]["training_of_hse"] == "No") ? "checked" : "";
		$staffAwarenessYes = ($content[0]["training_of_hse"] == "Yes") ? "checked" : "";

		$internalOrExternalNo = ($content[0]["external_internaml"] == "No") ? "checked" : "";
		$internalOrExternalYes = ($content[0]["external_internaml"] == "Yes") ? "checked" : "";

		$subcontractorsNo = ($content[0]["subcontractors_competence"] == "No") ? "checked" : "";
		$subcontractorsYes = ($content[0]["subcontractors_competence"] == "Yes") ? "checked" : "";

		$risksAssociatedNo = ($content[0]["driving_transport"] == "No") ? "checked" : "";
		$risksAssociatedYes = ($content[0]["driving_transport"] == "Yes") ? "checked" : "";

		$drugsAlcoholNo = ($content[0]["drugs_alcohol"] == "No") ? "checked" : "";
		$drugsAlcoholYes = ($content[0]["drugs_alcohol"] == "Yes") ? "checked" : "";

		$internalAuditsNo = ($content[0]["hse_internal_audit"] == "No") ? "checked" : "";
		$internalAuditsYes = ($content[0]["hse_internal_audit"] == "Yes") ? "checked" : "";


		$healthInsuranceNo = ($content[0]["health_insurance_scheme"] == "No") ? "checked" : "";
		$healthInsuranceYes = ($content[0]["health_insurance_scheme"] == "Yes") ? "checked" : "";

		$additionalInfo1 = $content[0]["additional_info1"];
		$additionalInfo3 = $content[0]["additional_info3"];

		$assessmentProcessYes = ($content[0]["hards_risk"] == "Yes") ? "checked" : "";
		$assessmentProcessNo = ($content[0]["hards_risk"] == "No") ? "checked" : "";


		$managementSystemNo = ($content[0]["management_system"] == "No") ? "checked" : "";
		$managementSystemYes = ($content[0]["management_system"] == "Yes") ? "checked" : "";

		$minorIncidentsYes = ($content[0]["minor_incident"] == "Yes") ? "checked" : "";
		$minorIncidentsNo = ($content[0]["minor_incident"] == "No") ? "checked" : "";

		$staffAwarenessYes = ($content[0]["training_of_hse"] == "Yes") ? "checked" : "";
		$staffAwarenessNo = ($content[0]["training_of_hse"] == "No") ? "checked" : "";

		$standardsOrGuidelinesNo = ($content[0]["standards_guideline"] == "No") ? "checked" : "";
		$standardsOrGuidelinesYes = ($content[0]["standards_guideline"] == "Yes") ?  "checked" : "";

		$trainingRequirementsYes = ($content[0]["uptodate"] == "Yes") ?  "checked" : "";
		$trainingRequirementsNo = ($content[0]["uptodate"] == "No") ?  "checked" : "";

		$systemCertifiedNo = ($content[0]["system_certified"] == "No") ?  "checked" : "";
		$systemCertifiedYes = ($content[0]["system_certified"] == "Yes") ? "checked" : "";

		$nameOfCertifyingBody = $content[0]["certifying_body"];
		$certificateNumber = $content[0]["certificate_number"];
		$expiryDate = substr($content[0]["expiry_date"], 0, 10);

		$companyWorkingNo = ($content[0]["your_company"] == "No") ? "checked" : "";
		$companyWorkingYes = ($content[0]["your_company"] == "Yes") ? "checked" : "";

		$year1 = json_decode($content[0]["year1"], true);
		$year2 = json_decode($content[0]["year2"], true);
		$year3 = json_decode($content[0]["year3"], true);
	}
	
	$option1 = "";
  for($i=date("Y")-1; $i > date("Y")-11 ; $i--){
      if($year1['calender year1'] == $i){
       $option1 .= "<option selected>{$i}</option>";
      }else{
        $option1 .= "<option>{$i}</option>";
      }
    }

  $option2 = "";
  for($i=date("Y")-2; $i > date("Y")-12 ; $i--) {
      if($year2['calender year2'] == $i){
       $option2 .= "<option selected>{$i}</option>";
      }else{
        $option2 .= "<option>{$i}</option>";
      }
    }

  $option3 = "";
  for ($i=date("Y")-3; $i > date("Y")-13 ; $i--) {
      if($year3['calender year3'] == $i){
       $option3 .= "<option selected>{$i}</option>";
      }else{
        $option3 .= "<option>{$i}</option>";
      }
  }
  
  if($DbHandle->iRetrieveData(__LINE__, ["vendor_id"=>$vendorDetails["vendor_id"]])){
  	$year1 = array_map('numberLize', $year1);
		$year2 = array_map('numberLize', $year2);
		$year3 = array_map('numberLize', $year3);
  }
  if ($content[0]["hse_policy"] === 'No') {
  	$progress = [
  		$content[0]["hse_policy"], $year1['calender year1'], $year1['total manh1'], 
  		$year1['lost time1'], $year1['number of facilities1'], $year2['calender year2'], 
  		$year2['total manh2'], $year2['lost time2'], $year2['number of facilities2'], 
  		$year3['calender year3'], $year3['total manh3'], $year3['lost time3'], 
  		$year3['number of facilities3']
  	];
  }else{
  	$progress = [
  		$content[0]["hse_policy"], $lastReview, $nameOfPerson, $contactTelephoneNumber, 
    	$contactEmail, $content[0]["contigency_plan"], $content[0]["reporting_procedure"], 
    	$content[0]["hards_risk"], $content[0]["policy_objective"],
    	$content[0]["adequate_ppe"], $content[0]["minor_incident"], 
    	$content[0]["external_internaml"], $content[0]["training_of_hse"], 
    	$content[0]["subcontractors_competence"], $content[0]["driving_transport"], 
    	$content[0]["drugs_alcohol"], $content[0]["hse_internal_audit"], 
    	$content[0]["health_insurance_scheme"], $content[0]["uptodate"], 
    	$year1['calender year1'], $year1['total manh1'],
    	$year1['lost time1'], $year1['number of facilities1'], $year2['calender year2'], 
    	$year2['total manh2'], $year2['lost time2'], $year2['number of facilities2'], 
    	$year3['calender year3'], $year3['total manh3'], $year3['lost time3'], 
    	$year3['number of facilities3']
    ];
  }
	$completion = $functions->profileCompletion($functions->progress($progress), count($progress));
	
	//Disable save
	$disableSave = "";
	$completionStatus = "";
	if($vendorDetails['que_submitted']=='yes'){
		$disableSave =  "disabled";
		$completionStatus = "<small class='al_completion_status'>questionnaire already submitted</small>";
	}
	
	function numberLize($item){
		return intval($item);
	}