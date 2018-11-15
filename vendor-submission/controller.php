<?php
  //Get required files
  require_once '../config.php';
  require_once '../db-config.php';
  
  //Initialization
  $response = "";
  $constant = [
    'url' => URL, 'urlemail' => URLEMAIL, 'contactemail' => CONTACTEMAIL, 
    'development' => DEVELOPMENT, 'directory' => ROOT.'error', 'sitename' => SITENAME];
  $pageName = "Submission";
  
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
  $head = $Tag->createHead(SITENAME." | $pageName ", "nav-md home-page", ['css' => ['css/nprogress.css', 'build/css/custom.css']]);
  
  $menu = $Tag->createSideBar($PDO, $vendorDetails['email'], ['parent'=>'Questionnaire', 'child'=>'Submission']);
  $mastHead = $Tag->createMastHead($PDO, $vendorDetails['email']);
  $slogan = $Tag->createFooterSlogan();
  $footer = $Tag->createFooter(['js/custom.js', 'js/submission-chart.js']);
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

  $generalCompletion = $legalCompletion = $personnelCompletion = $financeCompletion = $nigerianContentcompletion = $qmsCompletion = $hseCompletion = $declarationCompletion = $productCompletion = 0;

//VENDOR GENERAL
$companyName = $vendorDetails['company_name'];
$DbHandle->setTable("que_general");
if($content = $DbHandle->iRetrieveData(__LINE__, ['vendor_id'=>$vendorDetails['vendor_id']])){
  $content = $content[0];
  $headOfficeAddress = $content["head_office_address"];
  $townCity = $content["town_city"];
  $stateCounty = $content["state_county"];
  $postCode = $content["post_code"];
  $countriesOption = "";
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
  $generalProgress = [$emailAddress, $telephone1, $headOfficeAddress, $townCity, $stateCounty, $content["country"]];
  $generalCompletion = $functions->profileCompletion($functions->progress($generalProgress), 6);
}


//VENDOR LEGAL
$DbHandle->setTable("que_legal");
if($content = $DbHandle->iRetrieveData(__LINE__, ["vendor_id"=>$vendorDetails["vendor_id"]])){
  $firstYear = $content[0]['business_commencement_year'];
  $companyType = $content[0]['company_type'];
  $countryRegistration = $content[0]['country_of_registration'];
  $cacNumber = $content[0]['cac_no'];
  $registrationYear = $content[0]['registration_year']; 
  $additionalComment = $content[0]['comments'];
  $associatedName = $content[0]['associated_company'];
  $countriesOption = "<option value=''>Pick a Country</option>";
  $countryRegistration = $content[0]["country_of_registration"];
  $owners = json_decode($content[0]['shareholder'], true);
  $legalProgress = [$firstYear, $companyType, $countryRegistration, $cacNumber, $registrationYear, $owners[0]['director'], $owners[0]['nationality'], $owners[0]['gender'], $owners[0]['ownership']];
  $legalCompletion = $functions->profileCompletion($functions->progress($legalProgress), 9);
}

//PERSONNEL
$DbHandle->setTable("que_personnel");

  if ($content = $DbHandle->iRetrieveData(__LINE__, ["vendor_id"=>$vendorDetails["vendor_id"]])) {
    $currentYear = json_decode($content[0]["current_year"], true);
    $previousYear = json_decode($content[0]["previous_year"], true);
    $lastTwoYears = json_decode($content[0]["last_two_years"], true);
    $title = $content[0]["title"];
    $firstName = $content[0]["first_name"];
    $surname = $content[0]["surname"];
    $otherNames = $content[0]["other_name"];
    $jobTitle = $content[0]["job_title"];
    $addressLine1 = $content[0]["address_1"];
    $addressLine2 = $content[0]["address_2"];
    $town = $content[0]["town"];
    $state = $content[0]["state"];
    $telephone = $content[0]["phone"];
    $country = $content[0]["country"];
    $postCode = $content[0]["postcode"];
    $email = $content[0]["email"];
    $comment = $content[0]["comments"];
    $excos = json_decode($content[0]['executives'], true);
    $personnelProgress = [$title, $firstName, $surname, $jobTitle, $addressLine1, $town, $state, $telephone, $email, $country, $excos, $currentYear['Number of staff']];
    $personnelCompletion = $functions->profileCompletion($functions->progress($personnelProgress), 12);
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
  $financeCompletion = $functions->profileCompletion($functions->progress($progress), $totalCompulsory);
 }

//NIGERIAN CONTENT
 $DbHandle->setTable("que_nigeria_content");
 if ($content = $DbHandle->iRetrieveData(__LINE__, ["vendor_id"=>$vendorDetails["vendor_id"]])) {
  $nigeriaContact = $content[0]["nigerian_contact_name"];
  $emailAddress = $content[0]["email"];
  $contactTelephone = $content[0]["contact_phone"];
  $checkNigeriaContentYes = ($content[0]["nigerian_content_policy"] === "yes") ? "checked" : "";
  $checkNigeriaContentNo = ($content[0]["nigerian_content_policy"] === "no") ? "checked" : "";
  $pensionSchemeYes = ($content[0]["pension_scheme"] === "yes") ? "checked" : "";
  $pensionSchemeNo = ($content[0]["pension_scheme"] === "no") ? "checked" : "";
  if ($content[0]["nigerian_content_policy"] === "no") {
   $progress = [$content[0]["nigerian_content_policy"]];
   $nigerianContentcompletion = $functions->profileCompletion($functions->progress($progress), 1);
  }else{
   $progress = [$content[0]["nigerian_content_policy"], $content[0]["pension_scheme"], $emailAddress, $contactTelephone, $nigeriaContact];
   $nigerianContentcompletion = $functions->profileCompletion($functions->progress($progress), 5);
  }
 }

//QMS INFORMATION
 $DbHandle->setTable("que_quality_management");
 if ($content = $DbHandle->iRetrieveData(__LINE__, ["vendor_id"=>$vendorDetails["vendor_id"]])) {
   $progress = [$content[0]["quality_mgt_system"], $content[0]["quality_policy"], $content[0]["third_party_accreditation"], $content[0]["staff_aware_policy"], $content[0]["certified_system"]];
   $qmsCompletion = $functions->profileCompletion($functions->progress($progress), 5);
 }


//HSE
 $DbHandle->setTable("que_hse");
 if($content = $DbHandle->iRetrieveData(__LINE__, ["vendor_id"=>$vendorDetails["vendor_id"]])){
	$year1 = array_map('numberLize', json_decode($content[0]["year1"], true));
	$year2 = array_map('numberLize', json_decode($content[0]["year2"], true));
	$year3 = array_map('numberLize', json_decode($content[0]["year3"], true));
  if ($content[0]["hse_policy"] === 'No') {
  	$progress = [
  		$content[0]["hse_policy"], $year1['calender year1'], $year1['total manh1'], 
  		$year1['lost time1'], $year1['number of facilities1'], $year2['calender year2'], 
  		$year2['total manh2'], $year2['lost time2'], $year2['number of facilities2'], 
  		$year3['calender year3'], $year3['total manh3'], $year3['lost time3'], 
  		$year3['number of facilities3']
  	];
  }else{
  	$lastReview = $content[0]["last_review_date"];
		$nameOfPerson = $content[0]["name_of_person"];
		$contactTelephoneNumber = $content[0]["phone_no"];
		$contactEmail = $content[0]["email"];
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
	$hseCompletion = $functions->profileCompletion($functions->progress($progress), count($progress)); 
 }

//PRODUCT AND SERVICES
$DbHandle->setTable(" que_product_and_services");
if ($content = $DbHandle->iRetrieveData(__LINE__, ["vendor_id"=>$vendorDetails["vendor_id"]])) {
 $progress = [$content[0]['products_code'], $content[0]['certificate']];
 $productCompletion = $functions->profileCompletion($functions->progress($progress), 2);
}

// DECLARATION
 $DbHandle->setTable("que_declaration");
 if ($content = $DbHandle->iRetrieveData(__LINE__, ["vendor_id"=>$vendorDetails["vendor_id"]])) {
   $executives = "";
   $completedBy = json_decode($content[0]["completed_by"], true);
   $lastChangedBy = json_decode($content[0]["last_changed_by"], true);
   $progress = [$completedBy['Name'], $completedBy['Position'], $completedBy['Date'], $completedBy['Phone Number'], $lastChangedBy['Name'], $lastChangedBy['Position'], $lastChangedBy['Date'], $lastChangedBy['Phone Number']];
   $declarationCompletion = $functions->profileCompletion($functions->progress($progress), 8);
 }

	$totalCompletion = $generalCompletion+$legalCompletion+$personnelCompletion+$financeCompletion+$nigerianContentcompletion+$qmsCompletion+$hseCompletion+$declarationCompletion+$productCompletion;
	$totalCompletion = $totalCompletion/9;
	
	$DbHandle->setTable("vendor");
	$status = '';
	if ($content = $DbHandle->iRetrieveData(__LINE__, ["id"=>$vendorDetails["vendor_id"]])) {
	  $status = $content[0]['vendor_status'];
	}
	
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