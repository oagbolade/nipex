<?php
	//Get required files
	require_once '../config.php';
	require_once '../db-config.php';
	
	//Initialization
	$response = "";
	$constant = [
		'url' => URL, 'urlemail' => URLEMAIL, 'contactemail' => CONTACTEMAIL, 
		'development' => DEVELOPMENT, 'directory' => ROOT.'error', 'sitename' => SITENAME];
	$pageName = "General";
	
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
	$menu = $Tag->createSideBar($PDO, $vendorDetails['email'], ['parent'=>'Questionnaire', 'child'=>'General']);
	$mastHead = $Tag->createMastHead($PDO, $vendorDetails['email']);
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

	//default value
	$companyName = $vendorDetails['company_name'];
	$headOfficeAddress = "";
	$townCity = "";
	$postCode = "";
	$stateCounty = "";
	$countriesOption = "";
	foreach (Functions::countryCollection() as $aCountry) {
		if($aCountry == 'Nigeria'){
				$countriesOption .="<option selected value='$aCountry'>$aCountry</option>";
		}
		else {
			$countriesOption .="<option value='$aCountry'>$aCountry</option>";
		}
	}
	$telephone1 = "";
	$telephone2 = "";
	$operationalAddress = "";
	$emailAddress = "";
	$website = "";
	$previousCompanyName = "";
	$previousCompanyAddress = "";
	$additionalInformation = "";
	$DbHandle->setTable("que_general");
	if($content = $DbHandle->iRetrieveData(__LINE__, ['vendor_id'=>$vendorDetails['vendor_id']])){
		$content = $content[0];
		$headOfficeAddress = $content["head_office_address"];
		$townCity = $content["town_city"];
		$stateCounty = $content["state_county"];
		$postCode = $content["post_code"];
		$countriesOption = "<option value=''>Pick a country</option>";
		foreach (Functions::countryCollection() as $aCountry) {
			if($aCountry == $content["country"]){
				$countriesOption .="<option selected value='$aCountry'>$aCountry</option>";
			}
			else {
				$countriesOption .="<option value='$aCountry'>$aCountry</option>";
			}
		}
		$emailAddress = $content["email"];
		$telephone1 = $content["telephone1"];
		$telephone2 = $content["telephone2"];
		$operationalAddress = $content["operational_address"];
		$website = $content["website"];
		$previousCompanyName = $content["previous_company_name"];
		$previousCompanyAddress = $content["previous_company_address"];
		$additionalInformation = $content["additional_information"];
	}
	$progress = [$emailAddress, $telephone1, $headOfficeAddress, $townCity, $stateCounty, $content["country"]];
	$completion = $functions->profileCompletion($functions->progress($progress), 6);
	
	//Disable save
	$disableSave = "";
	$completionStatus = "";
	if($vendorDetails['que_submitted']=='yes'){
		$disableSave =  "disabled";
		$completionStatus = "<small class='al_completion_status'>questionnaire already submitted</small>";
	}