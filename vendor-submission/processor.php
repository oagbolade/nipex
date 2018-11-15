<?php
	//Get required files
	require_once '../config.php'; 
	require_once '../db-config.php'; 
	
	//Turn off magic quotes
	Functions::magicQuotesOff();
	
	//Check if the access to this script is coming from its index's page
  	if(isset($_POST['token']) && $_POST['token']==$_SESSION['token']){
	  	unset($_SESSION['token']);
		
		//Initialization
		$constant = [
			'url' => URL, 'urlemail' => URLEMAIL, 'contactemail' => CONTACTEMAIL, 
			'development' => DEVELOPMENT, 'sitename' => SITENAME];
		$DbHandle = new DBHandler($PDO, "login", __FILE__);
		$User = new Users($DbHandle);
		$vendorDetails = $User->userDetails($_SESSION['nipexLogin']['email']);		
		
		//Update vendor status
		$DbHandle->setTable("vendor");
		$data = ['vendor_status'=>'published', 'que_submitted'=>'yes'];
		$criteria = ['id'=>$vendorDetails["vendor_id"]];
		$DbHandle->updateData(__LINE__, $data, $criteria);
		
		//Add vendor to review table
		$DbHandle->setTable("review");
		$data = ['vendor_id'=>$vendorDetails["vendor_id"], 'review_officer_show'=>"yes", 'date'=>"NOW()"];
		$DbHandle->createData(__LINE__, $data);
		
		//Send mail to NJQS
		$DbHandle->setTable("login");
		if($reviewOfficers = $DbHandle->iRetrieveData(__LINE__, ['authority'=>'review officer', 'status'=>'active'])){
			$loginUrl="<a style='color:#fff; text-decoration:underline;' href='".URL."'>login</a>";
			foreach ($reviewOfficers as $aReviewOfficer) {
				$officerDetails = $User->userDetails($aReviewOfficer['email']);
				$message = Functions::emailHead(URL);
				$message.="
					<p style='margin-bottom:20px;'>Good Day {$officerDetails['name']}  </p>
					<p style='margin-bottom:8px;'>
						This is to let you know that there is a questionnaire on ". SITENAME ." awaiting 
						your review. Please $loginUrl at the earliest possible time to do the needful
					</p>
					<p style='margin-bottom:8px;'>
						<span style='font-weight:bold;'>NB</span><br/>
					   If you did not have an account on ".SITENAME." please ignore this mail. Please do 
					   not reply to this mail as it is sent from an unmonitored address. You can contact us via 
					   ".CONTACTEMAIL."
					</p>
				";
				$message .= Functions::footerHead(URL);
				if(!DEVELOPMENT){
					$subject="Questionnaire awaiting your review";
			  	$headers  = 'MIME-Version: 1.0' . "\r\n";
			  	$headers .= 'Content-type: text/html; charset=iso-8859-1' . "\r\n";
			  	$headers .= "From: ".SITENAME." <noreply@".URLEMAIL.">" . "\r\n";
					mail($aReviewOfficer['email'], $subject, $message, $headers);
				}
			}
		} 
		
		//Generate response to be sent back
		$_SESSION['response'] = "Your questionnaire has been successfully submitted";
		header("Location: .");
	  exit();
	}
	else {
		$_SESSION['spoofing']="CSRF suspected in  ". __FILE__;
		$_SESSION['dataError']=TRUE;
		header("Location: .");
		exit();
	}