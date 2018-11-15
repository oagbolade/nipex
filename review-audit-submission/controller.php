<?php
  //Get required files
  require_once '../db-config.php';
  
  //Initialization
  $response = "";
  $constant = [
    'url' => URL, 'urlemail' => URLEMAIL, 'contactemail' => CONTACTEMAIL, 
    'development' => DEVELOPMENT, 'directory' => ROOT.'error', 'sitename' => SITENAME];
  $pageName = "An Audited Report";
  
  //Lock up page
  $DbHandle = new DBHandler($PDO, "login", __FILE__);
  $User = new Users($DbHandle); 
  $Authenication = new Authentication($DbHandle);
  $Authenication->setConstants($constant);
  $Authenication->keyToPage();
	$userDetails = $User->userDetails($_SESSION['nipexLogin']['email']);
	$accessor = ['supervising officer', 'deputy manager', 'manager'];
	$Authenication->pageAccessor($accessor, $userDetails['authority']);
  
	//Check for valid audit id
	if(isset($_GET['audit'])){
		if(!in_array($_GET['audit'], Functions::numericArray($DbHandle, 'audit', 'id'))){
			header("Location: ". URL."home");
		}
	}
	else {
		header("Location: ". URL."home");
	}
	$auditID = $_GET['audit'];
	
	//Check for valid vendor id
	if(isset($_GET['vendor'])){
		if(!in_array($_GET['vendor'], Functions::numericArray($DbHandle, 'vendor', 'id'))){
			header("Location: ". URL."home");
		}
	}
	else {
		header("Location: ". URL."home");
	}
	$vendorID = $_GET['vendor'];
	
	//Audit Report ID
	$DbHandle->setTable('audit_report');
	$reportInfo = $DbHandle->iRetrieveData(__LINE__, ['id'=>$vendorID]);
	$reportInfo = $reportInfo[0];
  
  $_SESSION['token'] = md5(TOKEN);
  
  $Tag = new Tag(URL);
  $head = $Tag->createHead(SITENAME." | $pageName ", "nav-md home-page", ['css' => ['css/nprogress.css']]); 
  $menu = $Tag->createSideBar($PDO, $userDetails['email'], ['parent'=>'My Uploads', 'child'=>'']);
  $mastHead = $Tag->createMastHead($PDO, $userDetails['email']);
  $slogan = $Tag->createFooterSlogan();
  $footer = $Tag->createFooter(['js/custom.js', 'js/review-vendor-submission.js']);
  
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
	
	//Get audit report 
	$DbHandle->setTable("audit_report");
	$table ="
		<table class='table table-striped'>
      <thead>
        <tr>
          <th>Contact Details</th>
          <th>Contact Person</th>
          <th>Audit Date</th>
          <th>Report<br/>Submission Date</th>          
          <th>Scheduler</th>
          <th>Uploader</th>
        </tr>
      </thead>
      <tbody>
	";
	if($audits = $DbHandle->iRetrieveData(__LINE__, ['id'=>$reportInfo['id']])){
		$document = "";
		$kanter = 0;
		foreach ($audits as $aAudit) {
			$DbHandle->setTable("vendor");
			$vendorInfo = $DbHandle->iRetrieveData(__LINE__, ['id'=>$aAudit['vendor_id']]);
			$vendorInfo = $vendorInfo[0];
			$DbHandle->setTable("que_general");
			$generalInfo = $DbHandle->iRetrieveData(__LINE__, ['vendor_id'=>$aAudit['vendor_id']]);
			$generalInfo = $generalInfo[0];
			$DbHandle->setTable("que_personnel");
			$contactInfo = $DbHandle->iRetrieveData(__LINE__, ['vendor_id'=>$aAudit['vendor_id']]);
			$contactInfo = $contactInfo[0];
			$auditorDateDetails = $User->userDetails($User->getEmailFrmID($aAudit['auditor_for_date']));
			$auditorReportDetails = $User->userDetails($User->getEmailFrmID($aAudit['auditor_for_report']));
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
          	".date("jS M'y",strtotime($aAudit['audit_date']))."
          </td>
          <td>
          	".date("jS M'y",strtotime($aAudit['submission_date']))."<br/>
          </td>
          <td>
          	{$auditorDateDetails['name']}
          </td>
          <td>
          	{$auditorReportDetails['name']}
          </td>
        </tr>
			";
			$report = $aAudit['report'];
			if($aAudit['upload']){
				$documentArray = json_decode($aAudit['upload'], true);
				foreach ($documentArray as $aDocument) {
					$document .= "	
						<div class='col-sm-4'>
							{$aDocument['file caption']}
					  </div>
					  <div class='col-sm-8'>
					  	<a target='_blank' class='btn btn-primary' href='".URL."document/audit-document/{$aDocument['filename']}'>View</a>
					  </div>";
				}
			}
		}
	}
	$table .= "</tbody></table>";

	$disabled="";
	$submitNote = "";
	$DbHandle->setTable('audit');
	$review = $DbHandle->iRetrieveData(__LINE__, ['id'=>$auditID]);
	$review = $review[0];
	switch ($userDetails['authority']) {
		case 'review officer':
			if($review['review_officer_show'] == 'no') $disabled = "disabled";
			$submitNote = "<small class='alert alert-warning'>review submitted already</small>";
		break;
		case 'supervising officer':
			if($review['supervising_officer_show'] == 'no') $disabled = "disabled";
		break;
			case 'deputy manager':
			if($review['deputy_manager_show'] == 'no') $disabled = "disabled";
		break;
		case 'manager':
			if($review['manager_show'] == 'no') $disabled = "disabled";
		break;
	}
	
	$reviewTag = "";
	if($userDetails['authority'] != 'audit'){
		$reviewTag = "
			<div class='row'>
        <div class='x_panel'>
          <div class='x_title'>
            <h2>Submit Audit Review $submitNote</h2>
            <ul class='nav navbar-right panel_toolbox'>
              <li><a class='collapse-link'><i class='fa fa-chevron-up'></i></a>
              </li></li>
            </ul>
            <div class='clearfix'></div>
          </div>
          <div class='x_content'>
            <div class='row'>
              <div class='col-sm-12'>
            		<form method='post' action='processor.php' class='form-vertical' $disabled>
            			<input type='hidden' name='token' value='{$_SESSION['token']}' />
            			<input type='hidden' name='reviewID' value='$auditID' />
            			<input type='hidden' name='vendorID' value='$vendorID'/>
            			<div class='row form-group'>
            				<div class='col-sm-2'>
            					<label>Approve</label>
            				</div>
            				<div class='col-sm-1'>
            					<input type='radio' name='approval' value='approve' id='approveBtn' class='button'/>
            				</div>
            			</div>
            			<br/>
            			<div class='row form-group'>
            				<div class='col-sm-2'>
            					<label>Disapprove</label>
            				</div>
            				<div class='col-sm-1'>
            					<input required type='radio' name='approval' value='disapprove' id='disapproveBtn' class='button'/>
            				</div>
            				<div class='col-sm-6'>
            					<textarea id='reason' disabled name='reason' class='form-control' style='height: 150px;'></textarea>
            				</div>
            			</div>
            			<div class='row form-group'>
            				<div class='col-sm-4'>
            					<button type='submit' class='btn btn-primary' $disabled>Submit Review</button>
            				</div>
            			</div>
            			<br/>
            		</form>    
              </div>
           </div>
          </div>
         </div>
       </div>
		";
	}
