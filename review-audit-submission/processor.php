<?php
	//Get required files
	require_once '../db-config.php'; 
	
	//Turn off magic quotes
	Functions::magicQuotesOff();
	
	$constant = [
		'url' => URL, 'urlemail' => URLEMAIL, 'contactemail' => CONTACTEMAIL, 'salt' => SALT, 
		'development' => DEVELOPMENT, 'directory' => ROOT.'error', 'sitename' => SITENAME];
	
	//Lock up page
  $DbHandle = new DBHandler($PDO, "login", __FILE__); 
  $User = new Users($DbHandle); 
  $Authenication = new Authentication($DbHandle);
  $Authenication->setConstants($constant); 
  $Authenication->keyToPage();
	$userDetails = $User->userDetails($_SESSION['nipexLogin']['email']); 
  $accessor = ['review officer', 'supervising officer', 'deputy manager', 'manager']; 
	$Authenication->pageAccessor($accessor, $userDetails['authority']); 
	
	//Check if the access to this script is coming from its index's page
  if(isset($_POST['token']) && $_POST['token']==$_SESSION['token']){
  	unset($_SESSION['token']);
				
		//Get validator to validate data sent to this script
		$FormValidator = new Validator();		
		$reviewOptions = ['approve', 'disapprove'];
		//Prepare form data for Validator
		$data[] = ['validationString'=>'in list', 'dataName'=>'approval', 'dataValue'=>$_POST['approval'], 'dataList'=>$reviewOptions];
		if($_POST['approval'] == 'disapprove') $data[] = ['validationString' => 'non empty', 'dataName' => 'reason', 'dataValue' => $_POST['reason']];
		$data[] = ['validationString' => 'in list', 'dataName' => 'reviewID', 'dataValue'=>$_POST['reviewID'],  'dataList' => Functions::numericArray($DbHandle, 'audit', 'id')];
		$data[] = ['validationString' => 'in list', 'dataName' => 'vendorID', 'dataValue'=>$_POST['vendorID'],  'dataList' => Functions::numericArray($DbHandle, 'audit', 'vendor_id')];
		
		//Validate sent data
		$validationResult = $FormValidator->formValidation($data);
		if($validationResult['error']){
			if(!$validationResult['data']['approval']) $dataError[] = "Invalid approval response";
			if($_POST['approval'] == 'disapprove'){
				if(!$validationResult['data']['reason']) $dataError[] = "Disapproval reason is compulsory";
			} 
			if(!$validationResult['data']['reviewID']) $dataError[] = "Invalid review ID";
			if(!$validationResult['data']['vendorID']) $dataError[] = "Invalid vendor ID";
			$_SESSION['dataError'] = $dataError;
	  	header("Location: ".URL."review-audit-submission/?vendor={$_POST['vendorID']}&audit={$_POST['reviewID']}");
	  	exit();
  	}
		$result = $validationResult['data'];
		
		//Update data in audit table
		$DbHandle->setTable('audit');
		$reviewResponse['action'] = $result['approval'];
		$reviewResponse['reason'] = (isset($result['reason']))? $result['reason'] : null;  
		$data = getData($reviewResponse, $_SESSION['nipexLogin']['id'], $PDO);
		$key = ['id' => $result['reviewID']];
		$DbHandle->updateData(__LINE__, $data, $key);
		
		//Vendor Details
		$DbHandle->setTable('vendor');
		$vendorLoginInfo = $DbHandle->iRetrieveData(__LINE__, ['id'=>$result['vendorID']]);
		$vendorDetails = $User->userDetails($User->getEmailFrmID($vendorLoginInfo[0]['login_id']));
		
		//Sent to deputy manager CARRIED OUT BY A SUPERVISOR
		if($userDetails['authority'] == 'supervising officer' && $result['approval'] == 'approve'){
			$DbHandle->setTable('vendor');
			$DbHandle->updateData(__LINE__, ['vendor_status'=>'audit review'], ['id'=>$result['vendorID']]);
			$subject="Audit Report awaiting your review";
			$recipient = getEmails('deputy manager', $PDO);
			$emailBody = getEmailContent($result['approval']);
		}
		//Sent back to auditor
		if($userDetails['authority'] == 'supervising officer' && $result['approval'] == 'disapprove'){
			$DbHandle->setTable('vendor'); 
			$DbHandle->updateData(__LINE__, ['vendor_status'=>'under audit'], ['id'=>$result['vendorID']]);
			$subject="Audit Report rejected";
			$recipient = getEmails('audit', $PDO);
			$emailBody = getEmailContent('audit', $result['reason']);
		}
		
		//Sent to manager CARRIED OUT BY A DEPUTY MANAGER
		if($userDetails['authority'] == 'deputy manager' && $result['approval'] == 'approve'){
			$subject="Audit Report awaiting your review";
			$recipient = getEmails('manager', $PDO);
			$emailBody = getEmailContent($result['approval']);
		}
		//Sent back to supervisor
		if($userDetails['authority'] == 'deputy manager' && $result['approval'] == 'disapprove'){
			$subject="An Audit Report was rejected";
			$recipient = getEmails('supervising officer', $PDO);
			$emailBody = getEmailContent($result['approval']);
		}

		//Send to vendor CARRIED OUT BY A MANAGER
		if($userDetails['authority'] == 'manager' && $result['approval'] == 'approve'){
			//change vendor status on vendor table
			$DbHandle->setTable('vendor');
			$DbHandle->updateData(__LINE__, ['vendor_status'=>'pre qualified'], ['id'=>$result['vendorID']]);
			
			//Email 
			$subject="Pre Qualified Vendor";
			$recipient = $vendorDetails['email'];
			$emailBody = getEmailContent('vendor');
		}
		//Send back to deputy manager
		if($userDetails['authority'] == 'manager' && $result['approval'] == 'disapprove'){
			$subject="An Audit Report was rejected";
			$recipient = getEmails('deputy manager', $PDO);
			$emailBody = getEmailContent($result['approval']);
		}
		
		//send mail for next action
		$message = Functions::emailHead(URL);
		$message .= "
			<p style='margin-bottom:20px;'>Good Day</p>
			<p style='margin-bottom:8px;'>
				$emailBody
				<br/>
			</p>
			<p style='margin-bottom:8px;'>
				<span style='font-weight:bold;'>NB</span><br/>
			   If you did not register for an account at ".URL." please ignore this mail.
			   Please do not reply to this mail as it is sent from an unmonitored address. You 
			   can contact us via ".CONTACTEMAIL."
			</p>
		";
		$message .= Functions::footerHead(URL);
		if(!DEVELOPMENT){
	  	$headers  = 'MIME-Version: 1.0' . "\r\n";
	  	$headers .= 'Content-type: text/html; charset=iso-8859-1' . "\r\n";
	  	$headers .= "From: ".SITENAME." <noreply@".URLEMAIL.">" . "\r\n";
	  	foreach ($recipient as $aRecipient) {
				mail($aRecipient, $subject, $message, $headers);
			}
		}
		
		$_SESSION['response'] = "Your review of the questionaire has been successfully sent";
		header("Location: ".URL."review-audit-submission/?vendor={$_POST['vendorID']}&audit={$_POST['reviewID']}");
	  exit();
	}
	else {
		$_SESSION['spoofing']="CSRF suspected in  ". __FILE__;
		$_SESSION['dataError']=TRUE;
		header("Location: ".URL."review-audit-submission/?vendor={$_POST['vendorID']}&audit={$_POST['reviewID']}");
		exit();
	}
	
	function getData($review, $reviewer, PDOHandler $pdo){
		$DbHandle = new DBHandler($pdo, "review", __FILE__);
		$User = new Users($DbHandle);
		$userDetails = $User->userDetails($User->getEmailFrmID($reviewer));
		switch ($userDetails['authority']) {
			case 'supervising officer':
				$data = [
					'supervising_officer_id'=>$reviewer, 'supervising_officer_show'=>"no", 
					'supervising_officer_action'=>$review['action'], 'deputy_manager_show'=> 'yes',
					'supervising_officer_date'=>"NOW()"];
				if($review['reason']){
					$data['supervising_officer_reason'] = $review['reason'];
					unset($data['deputy_manager_show']);
				}
			break;
			case 'deputy manager':
				$data = [
					'deputy_manager_id'=>$reviewer, 'deputy_manager_show'=>"no", 
					'deputy_manager_action'=>$review['action'], 'manager_show'=> 'yes',
					'deputy_manager_date'=>"NOW()"];
				if($review['reason']){
					$data['deputy_manager_reason'] = $review['reason'];
					unset($data['manager_show']);
					$data['supervising_officer_show'] = 'yes';
				}
			break;
			case 'manager':
				$data = [
					'manager_id'=>$reviewer, 'manager_show'=>"no", 
					'manager_action'=>$review['action'],
					'manager_date'=>"NOW()"];
				if($review['reason']){
					$data['manager_reason'] = $review['reason'];
					$data['deputy_manager_show'] = 'yes';
				}
			break;
		}
		return $data;
	}

	function getEmails($right, PDOHandler $pdo){
		$DbHandle = new DBHandler($pdo, "login", __FILE__);
		$emails = [];
		if($userInfo = $DbHandle->iRetrieveData(__LINE__, ['authority'=>$right, 'status'=>'active'])){
			foreach ($userInfo as $aUserInfo) {
				$emails[] = $aUserInfo['email'];
			}
		}
		return $emails;			
	}

	/**
		 * Use to generate email content
		 * @param array $action [approve, disapprove, vendor, audit]
		 * @param string $reason reason for rejection of vendor questionnaire
		 * @return string $content
		 */
	function getEmailContent($action, $reason=""){
		$content = "";
		$loginUrl = "<a style='color:#fff; text-decoration:underline;' href='".URL."'>login</a>";
		switch ($action) {
			case 'approve':
				$content = "
					This is to let you know that there is an Audit Report on ". SITENAME ." is awaiting 
					your review. Please $loginUrl at the earliest possible time to do the needful
				";
			break;
			case 'disapprove':
				$content = "
					This is to let you know that there is an Audit Report on ". SITENAME ." that has 
					been disapproved. Please $loginUrl at the earliest possible time to do the needful
				";
			break;
			case 'vendor':
				$content = "
					Congratulation you are now a <strong>PRE QUALIFY</strong> vendor on ". SITENAME ." You can 
					$loginUrl and check your status
				";
			break;
			case 'audit':
				$content = "
					This is to let you know that there is an Audit Report submitted has been returned back for  
					reviewed on ". SITENAME .". Please $loginUrl at the earliest possible time to do the 
					needful <br/><br/>
					<strong>REASON</strong>
					$reason
				";
			break;
		}
		return $content;
	}