<?php
	//Get required files
	require_once '../config.php';
	require_once '../db-config.php';
	
	//Initialization
	$response = "";
	$constant = [
		'url' => URL, 'urlemail' => URLEMAIL, 'contactemail' => CONTACTEMAIL, 
		'development' => DEVELOPMENT, 'directory' => ROOT.'error', 'sitename' => SITENAME];
	$pageName = "Nigeria Content";
	
	//Lock up page
	$DbHandle = new DBHandler($PDO, "login", __FILE__);
	$User = new Users($DbHandle);
	$userDetails = $User->userDetails($_SESSION['nipexLogin']['email']); 
	$Authenication = new Authentication($DbHandle);
	$Authenication->setConstants($constant);
	$Authenication->keyToPage();
	$Authenication->pageAccessor(['vendor'], $userDetails['authority']);
	
	$_SESSION['token'] = md5(TOKEN);
	
	$Tag = new Tag(URL);
	$head = $Tag->createHead(SITENAME." | $pageName ", "nav-md home-page", ['css' => ['css/nprogress.css']]);
	
	//Disable save
	$disableSave = ($userDetails['vendor_status']=='registered')? "": "disabled";
	
	$menu = $Tag->createSideBar($PDO, $userDetails['email'], ['parent'=>'Questionnaire', 'child'=>'Nigerian Content']);
	$mastHead = $Tag->createMastHead($PDO, $userDetails['email']);
	$slogan = $Tag->createFooterSlogan();
	$footer = $Tag->createFooter(['js/custom.js', 'js/nigeria-content.js']);
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

	//default value
	$nigeriaContact=$emailAddress=$contactTelephone=$checkNigeriaContentYes=
	$checkNigeriaContentNo=$pensionSchemeYes=$pensionSchemeNo = "";
	$DbHandle->setTable("que_nigeria_content");
	if ($content = $DbHandle->iRetrieveData(__LINE__, ["vendor_id"=>$userDetails["vendor_id"]])) {
		$nigeriaContact = $content[0]["nigerian_contact_name"];
		$emailAddress = $content[0]["email"];
		$contactTelephone = $content[0]["contact_phone"];
		$checkNigeriaContentYes = ($content[0]["nigerian_content_policy"] === "yes") ? "checked" : "";
		$checkNigeriaContentNo = ($content[0]["nigerian_content_policy"] === "no") ? "checked" : "";
		$pensionSchemeYes = ($content[0]["pension_scheme"] === "yes") ? "checked" : "";
		$pensionSchemeNo = ($content[0]["pension_scheme"] === "no") ? "checked" : "";

	}
	if ($content[0]["nigerian_content_policy"] === "no") {
		$progress = [$content[0]["nigerian_content_policy"]];
		$completion = $functions->profileCompletion($functions->progress($progress), 1);
	}else{
		$progress = [$content[0]["nigerian_content_policy"], $content[0]["pension_scheme"], $emailAddress, $contactTelephone, $nigeriaContact];
		$completion = $functions->profileCompletion($functions->progress($progress), 5);
	}
	
	//Disable save
	$disableSave = "";
	$completionStatus = "";
	if($userDetails['que_submitted']=='yes'){
		$disableSave =  "disabled";
		$completionStatus = "<small class='al_completion_status'>questionnaire already submitted</small>";
	}