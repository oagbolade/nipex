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
		$data[] = ['validationString' => 'in list', 'dataName' => 'reviewID', 'dataValue'=>$_POST['reviewID'],  'dataList' => Functions::numericArray($DbHandle, 'review', 'id')];
		$data[] = ['validationString' => 'in list', 'dataName' => 'vendorID', 'dataValue'=>$_POST['vendorID'],  'dataList' => Functions::numericArray($DbHandle, 'review', 'vendor_id')];
		
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
	  	header("Location: ".URL."review-vendor-submission/?vendor={$_POST['vendorID']}&review={$_POST['reviewID']}");
	  	exit();
  	}
		$result = $validationResult['data'];
		
		//Update data in review table
		$DbHandle->setTable('review');
		$reviewResponse['action'] = $result['approval'];
		$reviewResponse['reason'] = (isset($result['reason']))? $result['reason'] : null;  
		$data = getData($reviewResponse, $_SESSION['nipexLogin']['id'], $PDO);
		$key = ['id' => $result['reviewID']];
		$DbHandle->updateData(__LINE__, $data, $key);
		
		//Vendor Details
		$DbHandle->setTable('vendor');
		$vendorLoginInfo = $DbHandle->iRetrieveData(__LINE__, ['id'=>$result['vendorID']]);
		$vendorDetails = $User->userDetails($User->getEmailFrmID($vendorLoginInfo[0]['login_id']));
		
		//Send to supervisor
		if($userDetails['authority'] == 'review officer' && $result['approval'] == 'approve'){
			$DbHandle->setTable('vendor');
			$DbHandle->updateData(__LINE__, ['vendor_status'=>'review in progress'], ['id'=>$result['vendorID']]);
			$subject="Questionnaire awaiting your review";
			$recipient = getEmails('supervising officer', $PDO);
			$emailBody = getEmailContent($result['approval']);
		}
		
		//Send back to vendor
		if($userDetails['authority'] == 'review officer' && $result['approval'] == 'disapprove'){
			$DbHandle->setTable('vendor'); 
			$DbHandle->updateData(__LINE__, ['que_submitted'=>'no', 'vendor_status'=>'published'], ['id'=>$result['vendorID']]);
			$subject="Questionnaire rejected";
			$recipient[] = $vendorDetails['email'];
			$emailBody = getEmailContent('vendor', $result['reason']);
		}
		
		//Send to deputy manager
		if($userDetails['authority'] == 'supervising officer' && $result['approval'] == 'approve'){
			$subject="Questionnaire awaiting your review";
			$recipient = getEmails('deputy manager', $PDO);
			$emailBody = getEmailContent($result['approval']);
		}
		
		//Send back to review officer
		if($userDetails['authority'] == 'supervising officer' && $result['approval'] == 'disapprove'){
			$subject="A questionnaire was rejected";
			$recipient = getEmails('review officer', $PDO);
			$emailBody = getEmailContent($result['approval']);
		}

		//Send to manager
		if($userDetails['authority'] == 'deputy manager' && $result['approval'] == 'approve'){
			$subject="Questionnaire awaiting your review";
			$recipient = getEmails('manager', $PDO);
			$emailBody = getEmailContent($result['approval']);
		}
		
		//Send back to supervisor officer
		if($userDetails['authority'] == 'deputy manager' && $result['approval'] == 'disapprove'){
			$subject="A questionnaire was rejected";
			$recipient = getEmails('supervising officer', $PDO);
			$emailBody = getEmailContent($result['approval']);
		}
		
		//Send to auditor
		if($userDetails['authority'] == 'manager' && $result['approval'] == 'approve'){
			//add to audit table
			$DbHandle->setTable('audit_report');
			$DbHandle->createData(__LINE__, ['vendor_id'=>$result['vendorID'], 'creation_date'=>"NOW()"]);
			
			//change vendor status on vendor table
			$DbHandle->setTable('vendor');
			$DbHandle->updateData(__LINE__, ['vendor_status'=>'under audit'], ['id'=>$result['vendorID']]);
			
			//Email 
			$subject="A vendor is awaiting audit scheduling";
			$recipient = getEmails('audit', $PDO);
			$emailBody = getEmailContent('audit');
		}
		
		//Send back to deputy manager
		if($userDetails['authority'] == 'manager' && $result['approval'] == 'disapprove'){
			$subject="A questionnaire is rejected";
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
		header("Location: ".URL."review-vendor-submission/?vendor={$result['vendorID']}&review={$result['reviewID']}");
	  exit();
	}
	else {
		$_SESSION['spoofing']="CSRF suspected in  ". __FILE__;
		$_SESSION['dataError']=TRUE;
		header("Location: .");
		exit();
	}
	
	function getData($review, $reviewer, PDOHandler $pdo){
		$DbHandle = new DBHandler($pdo, "review", __FILE__);
		$User = new Users($DbHandle);
		$userDetails = $User->userDetails($User->getEmailFrmID($reviewer));
		switch ($userDetails['authority']) {
			case 'review officer':
				$data = [
					'review_officer_id'=>$reviewer, 'review_officer_show'=>"no", 
					'review_officer_action'=>$review['action'], 'supervising_officer_show'=> 'yes',
					'review_officer_date'=>"NOW()"];
				if($review['reason']){
					$data['review_officer_reason'] = $review['reason'];
					unset($data['supervising_officer_show']);
				}  
			break;
			case 'supervising officer':
				$data = [
					'supervising_officer_id'=>$reviewer, 'supervising_officer_show'=>"no", 
					'supervising_officer_action'=>$review['action'], 'deputy_manager_show'=> 'yes',
					'supervising_officer_date'=>"NOW()"];
				if($review['reason']){
					$data['supervising_officer_reason'] = $review['reason'];
					unset($data['deputy_manager_show']);
					$data['review_officer_show'] = 'yes';
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
						This is to let you know that there is a questionnaire on ". SITENAME ." is awaiting 
						your review. Please $loginUrl at the earliest possible time to do the needful
					";
				break;
				case 'disapprove':
					$content = "
						This is to let you know that there is a questionnaire on ". SITENAME ." that has 
						been disapproved. Please $loginUrl at the earliest possible time to do the needful
					";
				break;
				case 'vendor':
					$content = "
						This is to let you know that the you questionnaire submitted on ". SITENAME ." was 
						returned back from review. Please $loginUrl at the earliest possible time and effected
						the neccessary correction.<br/><br/>
						<strong>REASON</strong>
						$reason
					";
				break;
				case 'audit':
					$content = "
						This is to let you know that there is a vendor's questionnaire that has been 
						reviewed on ". SITENAME .". The vendor is awaiting auditing. Please $loginUrl at 
						the earliest possible time to do the needful
					";
				break;
			}
			return $content;
		}