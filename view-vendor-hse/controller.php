<?php
	//Get required files
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
	$userDetails = $User->userDetails($_SESSION['nipexLogin']['email']); 
	$Authenication = new Authentication($DbHandle);
	$Authenication->setConstants($constant);
	$Authenication->keyToPage();
	$accessor = ['review officer', 'supervising officer', 'deputy manager', 'manager'];
	$Authenication->pageAccessor($accessor, $userDetails['authority']);
  
	//Check for valid vendor id
	if(isset($_GET['vendor']) && !isset($_GET['review'])) {
		if(!in_array($_GET['vendor'], Functions::numericArray($DbHandle, 'vendor', 'id'))){
			header("Location: ". URL."home");
			exit;
		}
		$vendorID = $_GET['vendor'];
	}
	elseif(isset($_GET['vendor']) && isset($_GET['review'])) {
		if(!Functions::validIDs($_GET['vendor'], $_GET['review'], $PDO)){
			header("Location: ". URL."home");	
			exit;
		}
		$vendorID = $_GET['vendor'];
		$reviewID = $_GET['review'];
	}
	else {
		header("Location: ". URL."home");	
		exit;
	}
	
	$_SESSION['token'] = md5(TOKENRAW);
	
	$Tag = new Tag(URL);
	$head = $Tag->createHead(SITENAME." | $pageName ", "nav-md home-page", ['css' => ['css/nprogress.css']]);
	
	$menu = $Tag->createSideBar($PDO, $userDetails['email'], ['parent'=>'Health and Safety', 'child'=>'']);
	$mastHead = $Tag->createMastHead($PDO, $userDetails['email']);
	$slogan = $Tag->createFooterSlogan();
	$footer = $Tag->createFooter(['js/custom.js']);
	$questionnaireMenu = "";
	if(isset($reviewID)){
		$questionnaireMenu = $Tag->reviewMenu($vendorID, $reviewID);
	}
	
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
			$functions = new Functions();
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

	$DbHandle->setTable("vendor");
	$companyDetails = $DbHandle->iRetrieveData(__LINE__, ['id'=>$vendorID]);
	$companyName = $companyDetails[0]['company_name'];

	$DbHandle->setTable("que_hse");
	if ($content = $DbHandle->iRetrieveData(__LINE__, ["vendor_id"=>$vendorID])) {

		$hsePolicyNo = ($content[0]["hse_policy"] == "No") ? "No" : "";
		$hsePolicyYes = ($content[0]["hse_policy"] == "Yes") ? "Yes" : "";

		$lastReview = $content[0]["last_review_date"];
		$nameOfPerson = $content[0]["name_of_person"];
		$contactTelephoneNumber = $content[0]["phone_no"];
		$contactEmail = $content[0]["email"];

		$contingencyPlansNo = ($content[0]["contigency_plan"] == "No") ? "No" : "";
		$contingencyPlansYes = ($content[0]["contigency_plan"] == "Yes") ? "Yes" : "";

		$accidentReportingNo = ($content[0]["reporting_procedure"] == "No") ? "No" : "";
		$accidentReportingYes = ($content[0]["reporting_procedure"] == "Yes") ? "Yes" : "";

		$yourWorkforceNo = ($content[0]["adequate_ppe"] == "No") ? "No" : "";
		$yourWorkforceYes = ($content[0]["adequate_ppe"] == "Yes") ? "Yes" : "";

		$minorIncidentsNo = ($content[0]["minor_incident"] == "No") ? "No" : "";
		$minorIncidentsYes = ($content[0]["minor_incident"] == "Yes") ? "Yes" : "";

		$staffAwarenessNo = ($content[0]["training_of_hse"] == "No") ? "No" : "";
		$staffAwarenessYes = ($content[0]["training_of_hse"] == "Yes") ? "Yes" : "";

		$internalOrExternalNo = ($content[0]["external_internaml"] == "No") ? "No" : "";
		$internalOrExternalYes = ($content[0]["external_internaml"] == "Yes") ? "Yes" : "";

		$subcontractorsNo = ($content[0]["subcontractors_competence"] == "No") ? "No" : "";
		$subcontractorsYes = ($content[0]["subcontractors_competence"] == "Yes") ? "Yes" : "";

		$risksAssociatedNo = ($content[0]["driving_transport"] == "No") ? "No" : "";
		$risksAssociatedYes = ($content[0]["driving_transport"] == "Yes") ? "Yes" : "";

		$drugsAlcoholNo = ($content[0]["drugs_alcohol"] == "No") ? "No" : "";
		$drugsAlcoholYes = ($content[0]["drugs_alcohol"] == "Yes") ? "Yes" : "";

		$internalAuditsNo = ($content[0]["hse_internal_audit"] == "No") ? "No" : "";
		$internalAuditsYes = ($content[0]["hse_internal_audit"] == "Yes") ? "Yes" : "";

		$healthInsuranceNo = ($content[0]["health_insurance_scheme"] == "No") ? "No" : "";
		$healthInsuranceYes = ($content[0]["health_insurance_scheme"] == "Yes") ? "Yes" : "";

		$additionalInfo1 = $content[0]["additional_info1"];
		$additionalInfo3 = $content[0]["additional_info3"];

		$assessmentProcessYes = ($content[0]["hards_risk"] == "Yes") ? "Yes" : "";
		$assessmentProcessNo = ($content[0]["hards_risk"] == "No") ? "No" : "";

		$managementSystemNo = ($content[0]["management_system"] == "No") ? "No" : "";
		$managementSystemYes = ($content[0]["management_system"] == "Yes") ? "Yes" : "";

		$minorIncidentsYes = ($content[0]["minor_incident"] == "Yes") ? "Yes" : "";
		$minorIncidentsNo = ($content[0]["minor_incident"] == "No") ? "No" : "";

		$staffAwarenessYes = ($content[0]["training_of_hse"] == "Yes") ? "Yes" : "";
		$staffAwarenessNo = ($content[0]["training_of_hse"] == "No") ? "No" : "";

		$standardsOrGuidelinesNo = ($content[0]["standards_guideline"] == "No") ? "No" : "";
		$standardsOrGuidelinesYes = ($content[0]["standards_guideline"] == "Yes") ?  "Yes" : "";

		$trainingRequirementsYes = ($content[0]["uptodate"] == "Yes") ?  "Yes" : "";
		$trainingRequirementsNo = ($content[0]["uptodate"] == "No") ?  "No" : "";

		$systemCertifiedNo = ($content[0]["system_certified"] == "No") ?  "No" : "";
		$systemCertifiedYes = ($content[0]["system_certified"] == "Yes") ? "Yes" : "";

		$nameOfCertifyingBody = $content[0]["certifying_body"];
		$certificateNumber = $content[0]["certificate_number"];
		$expiryDate = substr($content[0]["expiry_date"], 0, 10);

		$companyWorkingNo = ($content[0]["your_company"] == "No") ? "No" : "";
		$companyWorkingYes = ($content[0]["your_company"] == "Yes") ? "Yes" : "";

		$year1 = json_decode($content[0]["year1"], true);
		$year2 = json_decode($content[0]["year2"], true);
		$year3 = json_decode($content[0]["year3"], true);
	}