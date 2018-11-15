<?php
	//Get required files
	require_once '../db-config.php';
	
	//Initialization
	$response = "";
	$constant = [
		'url' => URL, 'urlemail' => URLEMAIL, 'contactemail' => CONTACTEMAIL, 'salt' => SALT, 
		'development' => DEVELOPMENT, 'directory' => ROOT.'error', 'sitename' => SITENAME];
	$pageName = "New Audit Report";
	
	//Lock up page
	$DbHandle = new DBHandler($PDO, "login", __FILE__);
	$User = new Users($DbHandle); 
	$Authentication = new Authentication($DbHandle);
	$Authentication->setConstants($constant);
	$Authentication->keyToPage();
	$userDetails = $User->userDetails($_SESSION['nipexLogin']['email']);
	$accessor = ['supervising officer', 'deputy manager', 'manager'];
	$Authentication->pageAccessor($accessor, $userDetails['authority']);
	
	$_SESSION['token'] = md5(TOKEN);
	
	$Tag = new Tag(URL);
	$head = $Tag->createHead(SITENAME." | Audit Report ", "nav-md view-staff-page", ['css' => ['css/nprogress.css']]);
	
	$menu = $Tag->createSideBar($PDO, $userDetails['email'], ['parent'=>'New Audit Report', 'child'=>'']);
	$mastHead = $Tag->createMastHead($PDO, $userDetails['email']);
	$slogan = $Tag->createFooterSlogan();
	$footer = $Tag->createFooter(['js/custom.js']);
	
	//Error in data sent for processing
	if(isset($_SESSION['dataError'])){
		if(!isset($_SESSION['spoofing'])){
			$content = "<ul>";
			foreach ($_SESSION['dataError'] as $aMessage) {
				$content .= "<li class='text-left'>$aMessage</li>";	
			}
			$content .= "</ul>";
			$response = $Tag->createAlert("", $content, 'danger', true);
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
		$response = $Tag->createAlert("", $_SESSION['response'], 'success', true);
		unset($_SESSION['response']);
	}
	
	//Get list of all vendors for your level
	$DbHandle->setTable("audit");
	$table ="
		<table class='table table-striped'>
      <thead>
        <tr>
          <th>ID</th>
          <th>Company</th>
          <th>Contact Details</th>
          <th>Contact Person</th>
          <th>Review</th>
          <th>Audit</th>
          <th></th>
        </tr>
      </thead>
      <tbody>
	";
	if($reviewees = $DbHandle->iRetrieveData(__LINE__, [Functions::getViewer($userDetails['authority'])=>"yes"])){
		foreach ($reviewees as $aReviewee) {
			$reviewers =Functions::getReviewers($aReviewee, $User, false, false);
			$DbHandle->setTable("vendor");
			$vendorInfo = $DbHandle->iRetrieveData(__LINE__, ['id'=>$aReviewee['vendor_id']]);
			$vendorInfo = $vendorInfo[0];
			$DbHandle->setTable("que_general");
			$generalInfo = $DbHandle->iRetrieveData(__LINE__, ['vendor_id'=>$aReviewee['vendor_id']]);
			$generalInfo = $generalInfo[0];
			$DbHandle->setTable("que_personnel");
			$contactInfo = $DbHandle->iRetrieveData(__LINE__, ['vendor_id'=>$aReviewee['vendor_id']]);
			$contactInfo = $contactInfo[0];
			$DbHandle->setTable("audit_report");
			$auditReportInfo = $DbHandle->iRetrieveData(__LINE__, ['vendor_id'=>$aReviewee['vendor_id']]);
			$auditReportInfo = $auditReportInfo[0];
			$scheulerInfo = $User->userDetails($User->getEmailFrmID($auditReportInfo['auditor_for_date']));
			$uploaderInfo = $User->userDetails($User->getEmailFrmID($auditReportInfo['auditor_for_report']));
			$table .="
				<tr>
          <td>A0{$aReviewee['id']}</th>
          <td>{$vendorInfo['company_name']}</td>
          <td>
          	{$generalInfo['head_office_address']}<br/>
          	{$generalInfo['town_city']}<br/>
          	{$generalInfo['state_county']}<br/>
          	{$generalInfo['country']}<br/>
          	{$generalInfo['email']}<br/>
          	{$generalInfo['website']}<br/>
          	{$generalInfo['telephone1']}<br/>
						{$generalInfo['telephone2']}
          </td>
          <td>
          	 {$contactInfo['first_name']} {$contactInfo['other_name']} {$contactInfo['surname']}<br/>
          	 {$contactInfo['job_title']}<br/>
          	 {$contactInfo['phone']}<br/>
          	 {$contactInfo['email']}<br/>          	 
          </td>
          <td>
          	$reviewers
          </td>
          <td>
          	<div class='al_reviewer'>
	          	<strong>Audit Date:</strong> ".date("jS M'y",strtotime($auditReportInfo['audit_date']))."<br/>
	          	<strong>Scheduler:</strong>{$scheulerInfo['name']}<br/>
	          	<strong>Report Upload Date:</strong> ".date("jS M'y",strtotime($auditReportInfo['submission_date']))."<br/>
	          	<strong>Report Uploader:</strong>{$uploaderInfo['name']}<br/>
	          </div>
          </td>
          <td>
          	<a href='".URL."review-audit-submission/?vendor={$aReviewee['vendor_id']}&audit={$aReviewee['id']}' class='btn btn-primary btn-sm'>Audit Report</button>
          </td>
        </tr>
			";
		}
	}
	
	$table .= "</tbody></table>";