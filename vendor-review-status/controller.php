<?php
	//Get required files
	require_once '../db-config.php';
	
	//Initialization
	$response = "";
	$constant = [
		'url' => URL, 'urlemail' => URLEMAIL, 'contactemail' => CONTACTEMAIL, 'salt' => SALT, 
		'development' => DEVELOPMENT, 'directory' => ROOT.'error', 'sitename' => SITENAME];
	$pageName = "Questionnaire Status";
	
	//Lock up page
	$DbHandle = new DBHandler($PDO, "login", __FILE__);
	$User = new Users($DbHandle); 
	$Authentication = new Authentication($DbHandle);
	$Authentication->setConstants($constant);
	$Authentication->keyToPage();
	$userDetails = $User->userDetails($_SESSION['nipexLogin']['email']);
	$Authentication->pageAccessor(['vendor'], $userDetails['authority']);
	
	$_SESSION['token'] = md5(TOKEN);
	
	$Tag = new Tag(URL);
	$head = $Tag->createHead(SITENAME." | My Questionnaire Status ", "nav-md view-staff-page", ['css' => ['css/nprogress.css']]);
	
	$menu = $Tag->createSideBar($PDO, $userDetails['email'], ['parent'=>'Staff Admin', 'child'=>'View Staff']);
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
	$DbHandle->setTable("review");
	$table ="
		<table class='table table-striped'>
      <thead>
        <tr>
          <th>ID</th>
          <th>Review Officer</th>
          <th>Supervisor</th>
          <th>Deputy Manager</th>
          <th>Manager</th>
        </tr>
      </thead>
      <tbody>
	";
	
	if($reviewees = $DbHandle->iRetrieveData(__LINE__, ['vendor_id'=>$userDetails['vendor_id']])){
		foreach ($reviewees as $aReviewee) {
			//$reviewers = getReviewers($aReviewee, $User);
			$reviewerDate = ($aReviewee['review_officer_date'])? date("jS M'y",strtotime($aReviewee['review_officer_date'])) : "";
			$supervisorDate = ($aReviewee['supervising_officer_date'])? date("jS M'y",strtotime($aReviewee['supervising_officer_date'])) : "";
			$deputyMgrDate = ($aReviewee['deputy_manager_date'])? date("jS M'y",strtotime($aReviewee['deputy_manager_date'])) : "";
			$mgrDate = ($aReviewee['manager_date'])? date("jS M'y",strtotime($aReviewee['manager_date'])) : "";
			$table .="
				<tr>
          <td>R0{$aReviewee['id']}</td>
          <td>
          	<strong>Action</strong>: {$aReviewee['review_officer_action']} <br/>
          	<strong>Reason</strong>: {$aReviewee['review_officer_reason']}<br/>
          	<strong>Date</strong>: $reviewerDate						
          </td>
          <td>
          	<strong>Action</strong>: {$aReviewee['supervising_officer_action']} <br/>
          	<strong>Reason</strong>: {$aReviewee['supervising_officer_reason']}<br/>
          	<strong>Date</strong>: $supervisorDate
          </td>
          <td>
          	<strong>Action</strong>: {$aReviewee['deputy_manager_action']} <br/>
          	<strong>Reason</strong>: {$aReviewee['deputy_manager_reason']}<br/>
          	<strong>Date</strong>: $deputyMgrDate
          </td>
          <td>
          	<strong>Action</strong>: {$aReviewee['manager_action']} <br/>
          	<strong>Reason</strong>: {$aReviewee['manager_reason']}<br/>
          	<strong>Date</strong>: $mgrDate
          </td>
        </tr>
			";
		}
	}
	
	$table .= "</tbody></table>";
	
	function getViewer($right){
		switch ($right) {
			case 'review officer':
				$show = 'review_officer_id';
			break;   
			case 'supervising officer':
				$show = 'supervising_officer_id';
			break;
			case 'deputy manager':
				$show = 'deputy_manager_id';
			break;
			case 'manager':
				$show = 'manager_id';
			break;
		}
		return $show;
	}

	function getReviewers($review, Users $AUser){
		$reviewer['name'] = $supervisor['name'] = $dm['name'] = $manager['name'] ="";
		if($review['review_officer_id']) $reviewer = $AUser->userDetails($AUser->getEmailFrmID($review['review_officer_id']));
		if($review['supervising_officer_id']) $supervisor = $AUser->userDetails($AUser->getEmailFrmID($review['supervising_officer_id']));
		if($review['deputy_manager_id']) $dm = $AUser->userDetails($AUser->getEmailFrmID($review['deputy_manager_id']));
		if($review['manager_id']) $manager = $AUser->userDetails($AUser->getEmailFrmID($review['manager_id']));
		$reviewDate = (strtotime($review['review_officer_date']))? date("jS M'y", strtotime($review['review_officer_date'])) : "";
		$supervisorDate = (strtotime($review['supervising_officer_date']))? date("jS M'y", strtotime($review['supervising_officer_date'])) : "";
		$dmDate = (strtotime($review['deputy_manager_date']))? date("jS M'y", strtotime($review['deputy_manager_date'])) : "";
		$managerDate = (strtotime($review['manager_date']))? date("jS M'y", strtotime($review['manager_date'])) : "";
		$reveiwers = "
			<div class='al_reviewer'>
				<span><strong>Reviewer: </strong>{$reviewer['name']}</span>
				<span><strong>Action: </strong>{$review['review_officer_action']}</span>
				<span><strong>Reason: </strong>{$review['review_officer_reason']}</span>
				<span class='al_last_reviewer'><strong>Date: </strong>$reviewDate</span>
				
				<span><strong>Supervisor: </strong>{$supervisor['name']}</span>
				<span><strong>Action: </strong>{$review['supervising_officer_action']}</span>
				<span><strong>Reason: </strong>{$review['supervising_officer_reason']}</span>
				<span class='al_last_reviewer'><strong>Date: </strong>$supervisorDate</span>
				
				<span><strong>Deputy Manager: </strong>{$dm['name']}</span>
				<span><strong>Action: </strong>{$review['deputy_manager_action']}</span>
				<span><strong>Reason: </strong>{$review['deputy_manager_reason']}</span>
				<span class='al_last_reviewer'><strong>Date: </strong>$dmDate</span>
				
				<span><strong>Manager: </strong>{$manager['name']}</span>
				<span><strong>Action: </strong>{$review['manager_action']}</span>
				<span><strong>Reason: </strong>{$review['manager_reason']}</span>
				<span class='al_last_reviewer'><strong>Date: </strong>$managerDate</span>
			</div>";
		return $reveiwers;
	}