<?php
  //Get required files
  require_once '../db-config.php';
  
  //Initialization
  $response = "";
  $constant = [
    'url' => URL, 'urlemail' => URLEMAIL, 'contactemail' => CONTACTEMAIL, 
    'development' => DEVELOPMENT, 'directory' => ROOT.'error', 'sitename' => SITENAME];
  $pageName = "Audit Report Submission";
  
  //Lock up page
  $DbHandle = new DBHandler($PDO, "login", __FILE__);
  $User = new Users($DbHandle);
  $userDetails = $User->userDetails($_SESSION['nipexLogin']['email']); 
  $Authenication = new Authentication($DbHandle);
  $Authenication->setConstants($constant);
  $Authenication->keyToPage();
	$Authenication->pageAccessor(['audit'], $userDetails['authority']);
  
	//Check for valid audit id
	if(isset($_GET['audit'])){
		if(!in_array($_GET['audit'], Functions::numericArray($DbHandle, 'audit_report', 'id'))){
			header("Location: ". URL."home");
		}
	}
	else {
		header("Location: ". URL."home");
	}
	$auditID = $_GET['audit'];
	
	//Vendor ID
	$DbHandle->setTable('audit_report');
	$reportInfo = $DbHandle->iRetrieveData(__LINE__, ['id'=>$auditID]);
	$vendorID = $reportInfo[0]['vendor_id'];
  
  $_SESSION['token'] = md5(TOKEN);
  
  $Tag = new Tag(URL);
  $head = $Tag->createHead(SITENAME." | $pageName ", "nav-md home-page", ['css' => ['css/nprogress.css']]);
  
  $menu = $Tag->createSideBar($PDO, $userDetails['email'], ['parent'=>'Upload Report', 'child'=>'']);
  $mastHead = $Tag->createMastHead($PDO, $userDetails['email']);
  $slogan = $Tag->createFooterSlogan();
  $footer = $Tag->createFooter(['js/custom.js', 'js/audit-report-submission.js']);
  
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

  $function = new Functions();
  $DbHandle->setTable("que_declaration");

  if ($content = $DbHandle->iRetrieveData(__LINE__, ["vendor_id"=>$vendorID])) {
    $executives = "";
    $completedBy = json_decode($content[0]["completed_by"], true);
    $lastChangedBy = json_decode($content[0]["last_changed_by"], true);
  }
	
	
	//Get list of all vendors for your level
	$DbHandle->setTable("audit_report");
	$table ="
		<table class='table table-striped'>
      <thead>
        <tr>
          <th>Contact Details</th>
          <th>Contact Person</th>
          <th>Questionnaire<br/>Submission</th>
          <th>Audit Day</th>
          <th>Scheduler</th>
        </tr>
      </thead>
      <tbody>
	";
	if($reviewees = $DbHandle->iRetrieveData(__LINE__, ['id'=>$auditID])){
		$kanter = 0;
		foreach ($reviewees as $aReviewee) {
			$DbHandle->setTable("vendor");
			$vendorInfo = $DbHandle->iRetrieveData(__LINE__, ['id'=>$aReviewee['vendor_id']]);
			$vendorInfo = $vendorInfo[0];
			$DbHandle->setTable("que_general");
			$generalInfo = $DbHandle->iRetrieveData(__LINE__, ['vendor_id'=>$aReviewee['vendor_id']]);
			$generalInfo = $generalInfo[0];
			$DbHandle->setTable("que_personnel");
			$contactInfo = $DbHandle->iRetrieveData(__LINE__, ['vendor_id'=>$aReviewee['vendor_id']]);
			$contactInfo = $contactInfo[0];
			$auditorDetails = $User->userDetails($User->getEmailFrmID($aReviewee['auditor_for_date']));
			$table .="
				<tr>
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
          	".date("jS M'y",strtotime($aReviewee['creation_date']))."
          </td>
          <td>
          	".date("jS M'y",strtotime($aReviewee['audit_date']))."<br/>
          </td>
          <td>
          	{$auditorDetails['name']}
          </td>
        </tr>
			";
		}
	}
	$table .= "</tbody></table>";
	
	//Disable form
	$DbHandle->setTable("audit_report");
	$disable = "";
	if($DbHandle->iRetrieveData(__LINE__, ['submission_date'=>"IS NOT NULL"])){
		$disable = "disabled";
	}
	
	
	function reportSubmitted($reportID, $PDO){
		$submitted = false;
		$Db = new DBHandler($PDO, "audit_report", __FILE__);
		if($Db->iRetrieveData(__LINE__, ['submission_date'=>'IS NOT NULL'])) $submitted = true;
		return $submitted;
	}
