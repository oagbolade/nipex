<?php
	//Get required files
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
	$accessor = ['review officer', 'supervising officer', 'deputy manager', 'manager'];
	$Authenication->pageAccessor($accessor, $vendorDetails['authority']);
	  
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
	$menu = $Tag->createSideBar($PDO, $vendorDetails['email'], ['parent'=>'General', 'child'=>'']);
	$mastHead = $Tag->createMastHead($PDO, $vendorDetails['email']);
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

	//default value

	$DbHandle->setTable("vendor");
	$companyDetails = $DbHandle->iRetrieveData(__LINE__, ['id'=>$vendorID]);
	$companyName = $companyDetails[0]['company_name'];
	
	$DbHandle->setTable("que_general");
	if($content = $DbHandle->iRetrieveData(__LINE__, ['vendor_id'=>$vendorID])){
		$content = $content[0];
		$headOfficeAddress = $content["head_office_address"];
		$townCity = $content["town_city"];
		$postCode = $content["post_code"];
		$stateCounty = $content["state_county"];
		$country = $content["country"];
		$telephone1 = $content["telephone1"];
		$telephone2 = $content["telephone2"];
		$operationalAddress = $content["operational_address"];
		$emailAddress = $content["email"];
		$website = $content["website"];
		$previousCompanyName = $content["previous_company_name"];
		$previousCompanyAddress = $content["previous_company_address"];
		$additionalInformation = $content["additional_information"];
	}