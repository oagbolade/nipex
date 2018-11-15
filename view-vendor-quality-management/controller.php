<?php
	//Get required files
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

	$_SESSION['token'] = md5(TOKEN);
	
	$Tag = new Tag(URL);
	$head = $Tag->createHead(SITENAME." | $pageName ", "nav-md home-page", ['css' => ['css/nprogress.css']]);
	
	$menu = $Tag->createSideBar($PDO, $userDetails['email'], ['parent'=>'Quality Management', 'child'=>'']);
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

	// default value
	

	$DbHandle->setTable("vendor");
	$companyDetails = $DbHandle->iRetrieveData(__LINE__, ['id'=>$vendorID]);
	$companyName = $companyDetails[0]['company_name'];


	$DbHandle->setTable("que_quality_management");
	if ($content = $DbHandle->iRetrieveData(__LINE__, ["vendor_id"=>$vendorID])) {
		$documentedQmsYes = ($content[0]["quality_mgt_system"] === "yes") ? "Yes" : "";
		$documentedQmsNo = ($content[0]["quality_mgt_system"] === "no") ? "No" : "";
		$documentedPolicyYes = ($content[0]["quality_policy"] === "yes") ? "Yes" : "";
		$documentedPolicyNo = ($content[0]["quality_policy"] === "no") ? "No" : "";
		$lastReviewDate = $content[0]["last_review_date"];
		$policyObjectiveYes = ($content[0]["staff_aware_policy"] === "yes") ? "Yes" : "";
		$policyObjectiveNo = ($content[0]["staff_aware_policy"] === "no") ? "No" : "";
		$systemCertifiedYes = ($content[0]["certified_system"] === "yes") ? "Yes" : "";
		$systemCertifiedNo = ($content[0]["certified_system"] === "no") ? "No" : "";
		$partyAccreditationYes = ($content[0]["third_party_accreditation"] === "yes") ? "Yes" : "";
		$partyAccreditationNo = ($content[0]["third_party_accreditation"] === "no") ? "No" : "";
		$responsibleForQms = $content[0]["responsible_for_qms"];
		$contactNumber = $content[0]["phone"];
		$contactEmail = $content[0]["email"];
		$comments = $content[0]["comments"];
	}