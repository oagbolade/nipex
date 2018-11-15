<?php
	//Get required files
	require_once '../config.php';
	require_once '../db-config.php';
	
	//Initialization
	$response = "";
	$constant = [
		'url' => URL, 'urlemail' => URLEMAIL, 'contactemail' => CONTACTEMAIL, 
		'development' => DEVELOPMENT, 'directory' => ROOT.'error', 'sitename' => SITENAME];
	$pageName = "Finance";
	
	//Lock up page
	$DbHandle = new DBHandler($PDO, "login", __FILE__);
	$User = new Users($DbHandle);
	$vendorDetails = $User->userDetails($_SESSION['nipexLogin']['email']); 
	$Authenication = new Authentication($DbHandle);
	$Authenication->setConstants($constant);
	$Authenication->keyToPage();
	$Authenication->pageAccessor(['vendor'], $vendorDetails['authority']);
	
	$_SESSION['token'] = md5(TOKEN);
	
	$Tag = new Tag(URL);
	$head = $Tag->createHead(SITENAME." | $pageName ", "nav-md home-page", ['css' => ['css/nprogress.css']]);
	
	$menu = $Tag->createSideBar($PDO, $vendorDetails['email'], ['parent'=>'Questionnaire', 'child'=>'Finance']);
	$mastHead = $Tag->createMastHead($PDO, $vendorDetails['email']);
	$slogan = $Tag->createFooterSlogan();
	$footer = $Tag->createFooter(['js/custom.js', 'js/finance.js']);
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
	$workmanInsuranceYes = $workmanInsuranceNo = $insuranceNumber = $valueInsurance = $comments1 = $disableInsurance = "";
	$finParameter = [
		"Year Ending Month",'Annual Turnover','percent Turnover','Profit before tax', 
		'Total Assets','Current Assets','Total Short Term liabilities','Total Net Assets',
		'Issued Share Capital',"Reporting Currency","Audited Accounts","Accounting Year"];
	foreach ($finParameter as $aParameter) {
		$year1[$aParameter] = $year2[$aParameter] = $year3[$aParameter] = ""; 
	}
	$bankerAuditorParameter = [
		'Name','Address Line 1','Address Line 2','Town','State','Post Code','Country'
	];
	foreach ($bankerAuditorParameter as $aParameter) {
		$banker[$aParameter] = $auditor[$aParameter] = ""; 
	}
	
	$DbHandle->setTable("que_finance");
	if ($content = $DbHandle->iRetrieveData(__LINE__, ["vendor_id"=>$vendorDetails["vendor_id"]])) {
		$year1 = json_decode($content[0]["year_one"], true);
		$year2 = json_decode($content[0]["year_two"], true);
		$year3 = json_decode($content[0]["year_three"], true);
		$banker = json_decode($content[0]["banker"], true);
		$auditor = json_decode($content[0]["auditor"], true);
		$workmanInsuranceYes = ($content[0]["nsitf"] === "yes") ? "checked" : "";
		$workmanInsuranceNo = ($content[0]["nsitf"] === "no") ? "checked" : "";
		$insuranceNumber = $content[0]["nsitf_certificate_no"];
		$valueInsurance = $content[0]["value_of_insurance"];
		$comments1 = $content[0]["commments"];
		$disableInsurance = ($content[0]["nsitf"]=="yes")? "":"disabled";
	}

	// this is for the select Tag
	$months = Functions::monthsCollection();
	$optionMonth1 = $optionMonth2 = $optionMonth3 = "<option value=''>Pick a Month</option>";;
	foreach ($months as $month) {
		if ($year1["Year Ending Month"] === $month) {
		  $optionMonth1 .= "<option selected>$month</option>";
		}else {
		  $optionMonth1 .= "<option>$month</option>";
		}
		
		if ($year2["Year Ending Month"] === $month) {
		  $optionMonth2 .= "<option selected>$month</option>";
		}else {
		  $optionMonth2 .= "<option>$month</option>";
		}
		
		if ($year3["Year Ending Month"] === $month) {
		  $optionMonth3 .= "<option selected>$month</option>";
		}else {
		  $optionMonth3 .= "<option>$month</option>";
		}
		
	}

	$currencies=array( "NAIRA", "DOLLARS", "EURO");
	$value1 = $value2 = $value3 = "<option value=''>Pick a Currency</option>";
	foreach ($currencies as $currency) {
		if ($year1["Reporting Currency"] === $currency) {
		  $value1 .= "<option selected>$currency</option>";
		}else{
		  $value1 .= "<option>$currency</option>";
		}
		
		if ($year2["Reporting Currency"] === $currency) {
		  $value2 .= "<option selected>$currency</option>";
		}else{
		  $value2 .= "<option>$currency</option>";
		}
		
		if ($year3["Reporting Currency"] === $currency) {
		  $value3 .= "<option selected>$currency</option>";
		}else{
		  $value3 .= "<option>$currency</option>";
		}
	}

	$yearOneOptions = "";
	for($i = (date("Y")-1); $i>(date("Y")-10); --$i){
		if ($year1["Audited Accounts"] == $i) {
		 $yearOneOptions .= "<option selected>$i</option>";
		}else{
		 $yearOneOptions .= "<option>$i</option>";
		}
	}

	$yearTwoOptions = "";
	for($i = (date("Y")-2); $i>(date("Y")-11); --$i){
		if ($year2["Audited Accounts"] == $i) {
		 $yearTwoOptions .= "<option selected>$i</option>";
		}else{
		 $yearTwoOptions .= "<option>$i</option>";
		}
	}

	$yearThreeOptions = "";
	for($i = (date("Y")-2); $i>(date("Y")-11); --$i){
		if ($year3["Audited Accounts"] == $i) {
		 $yearThreeOptions .= "<option selected>$i</option>";
		}else{
		 $yearThreeOptions .= "<option>$i</option>";
		}
	}
	$yearOneAccount = "";
	for($i = (date("Y")-1); $i>(date("Y")-10); --$i){
		if ($year1["Accounting Year"] == $i) {
		 $yearOneAccount .= "<option selected>$i</option>";
		}else{
		 $yearOneAccount .= "<option>$i</option>";
		}
	}

	$yearTwoAccount = "";
	for($i = (date("Y")-2); $i>(date("Y")-11); --$i){
		if ($year2["Accounting Year"] == $i) {
		 $yearTwoAccount .= "<option selected>$i</option>";
		}else{
		 $yearTwoAccount .= "<option>$i</option>";
		}
	}

	$yearThreeAccount = "";
	for($i = (date("Y")-2); $i>(date("Y")-11); --$i){
		if ($year3["Accounting Year"] == $i) {
		 $yearThreeAccount .= "<option selected>$i</option>";
		}else{
		 $yearThreeAccount .= "<option>$i</option>";
		}
	}
	
	$progress = [
		$content[0]["nsitf"], $banker['Name'], $banker['Address Line 1'], $banker['Town'], 
		$banker['State'], $banker['Country'], $auditor['Name'], $auditor['Address Line 1'], 
		$auditor['Town'], $auditor['State'], $auditor['Country']];
	$totalCompulsory = count($progress);
	if($content[0]["nsitf"]=='yes'){
		$progress[] = $content[0]["nsitf_certificate_no"];
		$progress[] = $content[0]["value_of_insurance"];
		$totalCompulsory = $totalCompulsory + 2;
	}
	$completion = $functions->profileCompletion($functions->progress($progress), $totalCompulsory);
	
	//Disable save
	$disableSave = "";
	$completionStatus = "";
	if($vendorDetails['que_submitted']=='yes'){
		$disableSave =  "disabled";
		$completionStatus = "<small class='al_completion_status'>questionnaire already submitted</small>";
	}