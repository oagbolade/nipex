<?php
	//Get required files
	require_once '../config.php';
	require_once '../db-config.php';
	
	//Initialization
	$response = "";
	$constant = [
		'url' => URL, 'urlemail' => URLEMAIL, 'contactemail' => CONTACTEMAIL, 
		'development' => DEVELOPMENT, 'directory' => ROOT.'error', 'sitename' => SITENAME];
	$pageName = "Quality Management";
	
	//Lock up page
	$DbHandle = new DBHandler($PDO, "login", __FILE__);
	$User = new Users($DbHandle);
	$userDetails = $User->userDetails($_SESSION['nipexLogin']['email']); 
	$Authenication = new Authentication($DbHandle);
	$Authenication->setConstants($constant);
	$Authenication->keyToPage();
	$Authenication->pageAccessor(['vendor'], $userDetails['authority']);
	
	$_SESSION['token'] = md5(TOKENRAW);
	
	$Tag = new Tag(URL);
	$head = $Tag->createHead(SITENAME." | $pageName ", "nav-md home-page", ['css' => ['css/nprogress.css']]);
	
	$menu = $Tag->createSideBar($PDO, $userDetails['email'], ['parent'=>'Questionnaire', 'child'=>'QMS Information']);
	$mastHead = $Tag->createMastHead($PDO, $userDetails['email']);
	$slogan = $Tag->createFooterSlogan();
	$footer = $Tag->createFooter(['js/custom.js']);
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

	// default value
	$documentedQmsYes = "";
	$documentedQmsNo = "";
	$documentedPolicyYes = "";
	$documentedPolicyNo = "";
	$lastReviewDate = "";
	$policyObjectiveYes = "";
	$policyObjectiveNo = "";
	$systemCertifiedYes = "";
	$systemCertifiedNo = "";
	$relevantStandard = "";
	$certifyingAuthority = "";
	$certificateNo = "";
	$partyAccreditationYes = "";
	$partyAccreditationNo = "";
	$responsibleForQms = "";
	$contactNumber = "";
	$contactEmail = "";
	$comments = "";
	$DbHandle->setTable("que_quality_management");
	if ($content = $DbHandle->iRetrieveData(__LINE__, ["vendor_id"=>$userDetails["vendor_id"]])) {
		$documentedQmsYes = ($content[0]["quality_mgt_system"] === "yes") ? "checked" : "";
		$documentedQmsNo = ($content[0]["quality_mgt_system"] === "no") ? "checked" : "";

		$documentedPolicyYes = ($content[0]["quality_policy"] === "yes") ? "checked" : "";
		$documentedPolicyNo = ($content[0]["quality_policy"] === "no") ? "checked" : "";
		$lastReviewDate = $content[0]["last_review_date"];

		$policyObjectiveYes = ($content[0]["staff_aware_policy"] === "yes") ? "checked" : "";
		$policyObjectiveNo = ($content[0]["staff_aware_policy"] === "no") ? "checked" : "";

		$systemCertifiedYes = ($content[0]["certified_system"] === "yes") ? "checked" : "";
		$systemCertifiedNo = ($content[0]["certified_system"] === "no") ? "checked" : "";
		
		$relevantStandard = $content[0]["relevant_standard"];
		$certifyingAuthority = $content[0]["certifying_authority"];
		$certificateNo = $content[0]["certificate_number"];

		$partyAccreditationYes = ($content[0]["third_party_accreditation"] === "yes") ? "checked" : "";
		$partyAccreditationNo = ($content[0]["third_party_accreditation"] === "no") ? "checked" : "";
		$responsibleForQms = $content[0]["responsible_for_qms"];
		$contactNumber = $content[0]["phone"];
		$contactEmail = $content[0]["email"];
		$comments = $content[0]["comments"];
	}
	$progress = [$content[0]["quality_mgt_system"], $content[0]["quality_policy"], $content[0]["third_party_accreditation"], $content[0]["staff_aware_policy"], $content[0]["certified_system"]];
	$completion = $functions->profileCompletion($functions->progress($progress), 5);
	
	//Disable save
	$disableSave = "";
	$completionStatus = "";
	if($userDetails['que_submitted']=='yes'){
		$disableSave =  "disabled";
		$completionStatus = "<small class='al_completion_status'>questionnaire already submitted</small>";
	}