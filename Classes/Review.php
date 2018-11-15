<?php
	/**
	 * Review
   * 
   * This class is used for reviewing of questionaire submitted by vendor
   * @author      Alabi A. <alabi.adebayo@alabiansolutions.com>
   * @copyright   2018 Alabian Solutions Limited
   * @link        alabiansolutions.com
	 */
	class Review{
		private $_DbHandle;
		
		/**
     * Setup up db interaction
     * @param string $DbHandle an instant of DBHandler
     */
    public function __construct(DBHandler $DbHandle){
      $this->_DbHandle = $DbHandle;
    }
		
		private function getChangeTable(){
			$otherTable = $this->_DbHandle->getTable();
			$this->_DbHandle->setTable('review');
		}
		
		/**
		 * Get collection of all vendor's review level
		 * @return array $levels collection of review level
		 */
		public function levels(){
			$levels = ['review officer', 'supervisor', 'deputy manager', 'manager', 'publish'];
			return $levels;
		}
		
		/**
		 * Get the list of vendors id at a particular level 
		 * @param string $level which are 0=review officer, 1=supervisor, 2=deputy manager, 3=manager
		 * @return array $vendors a list of the vendors id at this level
		 */
		public function vendorsAtThisLevel($level){
			$oldTable = $this->getChangeTable();
			$vendors = [];
			$DbHandle = $this->_DbHandle;
			$officers = ['review_officer','supervising_officer','deputy_manager','manager'];
			$officer = $officers[$level];
			if($vendorsCollection = $DbHandle->iRetrieveData(__LINE__, ["$officer{_id}"=>'IS NULL'], ['vendor_id'])){
				foreach ($vendorsCollection as $aVendor) {
					$vendors[] = $aVendor['vendor_id'];
				}
			}
			$level = (($level+1) == 4) ? 3 : $level+1 ;  
			$officer = $officers[$level];
			if($vendorsCollection = $DbHandle->iRetrieveData(__LINE__, ["$officer{_action}"=>'reject'], ['vendor_id'])){
				foreach ($vendorsCollection as $aVendor) {
					$vendors[] = $aVendor['vendor_id'];
				}
			}
			$DbHandle->setTable($oldTable);
			return $vendors;
		}
		
		/**
		 * Get a vendors level
		 * @param integer $id the vendor's id
		 * @param integer $reviewID the review id
		 * @return string $level the level of the vendor
		 */
		public function vendorsLevel($id, $reviewID = null){
			$oldTable = $this->getChangeTable();
			$DbHandle = $this->_DbHandle;
			$criteria = ['vendor_id'=>$id];
			if($reviewID) $criteria = ['vendor_id'=>$id, 'id'=>$reviewID];
			$vendorReviewInfo = $DbHandle->iRetrieveData(__LINE__, $criteria);
			$vendorReviewInfo = $vendorReviewInfo[0];
			$officers = [
				$vendorReviewInfo['review_officer_id'], $vendorReviewInfo['supervising_officer_id'],
				$vendorReviewInfo['deputy_manager_id'], $vendorReviewInfo['manager_id']
			];
			$level = 4;
			for ($i=0; $i < count($officers); $i++) {
				$action = rtrim($officers[$i], "id")."action";
				if(!$officers[$i] || ($officers[$i] && $vendorReviewInfo[$action]=='reject')){
					if(!$officers[$i]){
						$level = $i;
						break;	
					}
					if($officers[$i] && $vendorReviewInfo[$action]=='reject'){
						$level = $i-1;
						if($level == -1) $level = 0;
						break;
					}
				}
			}
			$DbHandle->setTable($oldTable);
			return $level;
		}
		
		/**
		 * For submission of review by NJQS officer
		 * @param integer $vendor the vendor id
		 * @param integer $officer the NJQS officer id
		 * @param string $action 'accept','reject' action carried out by the NJQS officer
		 * @param integer $reviewID the review id
		 * @param string $reason the reason for rejection
		 */
		public function reviewVendor($vendor, $officer, $action, $reason, $reviewID = null){
			$oldTable = $this->getChangeTable();
			$DbHandle = $this->_DbHandle;
			$User = new Users($DbHandle);
			
			//Store review record
			$officerDetails = $User->userDetails($User->getEmailFrmID($id));
			$officerPrefix = [
				'review officer' => 'review_officer','supervising officer' => 'supervising_officer',
				'deputy manager' => 'deputy_manager', 'manager'=>'manager'
			];
			$data = [
				"{$officerPrefix[$officerDetails['authority']]}_id" => $officer, 
				"{$officerPrefix[$officerDetails['authority']]}_action" => $action, 
				"{$officerPrefix[$officerDetails['authority']]}_reason" => $reason, 
				"{$officerPrefix[$officerDetails['authority']]}_date" => "NOW()"
			];
			$key = ['vendor_id'=>$id];
			if($reviewID) $key = ['vendor_id'=>$vendor, 'id'=>$reviewID];
			$DbHandle->updateData(__LINE__, $data, $key);
			
			//for REJECT action 
			if($action == "reject"){
				$recipientAuthority = [
					'review officer' => 'vendor','supervising officer' => 'review officer',
					'deputy manager' => 'supervising officer', 'manager'=>'deputy manager'];
				
				//get email receipient's id
				if($recipientAuthority[$officerDetails['authority']] == 'vendor'){
					$recipientID = $vendor;
				}
				else {
					$DbHandle->setTable('login');
					if($officerCollection = $DbHandle->iRetrieveData(__LINE__, ['authority'=>$recipientAuthority[$officerDetails['authority']]])){
						foreach ($officerCollection as $anOfficer) {
							$recipientID[] = $anOfficer['id'];
						}
					}
				}
				
				//Emailing
				if($recipientID){
					foreach ($recipientID as $aRecipientID) {
						$recipientDetails = $User->userDetails($User->getEmailFrmID($aRecipientID));
						$vendorDetails = $User->userDetails($User->getEmailFrmID($aRecipientID));
						
						//compose email
						$message = $function::emailHead(URL);
						$paragraphyTwo = "
							<p style='margin-bottom:8px;'>
								This is to inform you that a vendor's questionnaire on ".SITENAME."
								that was previous approved by you has been <strong>REJECTED</strong> by 
								another senior NJQS officer. Please <a style='color:#fff; text-decoration:underline;' href='".URL."login'>
								login </a> reject the questionnaire too or re approved if the rejection was 
								done in error or otherwise. Details of the vendor is below
								<br/>
								<strong>Name:</strong>{$vendorDetails['company_name']}<br/>
								<strong>Email:</strong>{$vendorDetails['email']}<br/>
								<!--<strong>Phone:</strong>{$vendorDetails['company_name']}<br/>-->
							</p>
						";
						if($recipientAuthority[$officerDetails['authority']] == 'vendor'){
							$paragraphyTwo = "
								<p style='margin-bottom:8px;'>
									This is to inform you that your questionnaire on ".SITENAME."
									has been rejected. Please <a style='color:#fff; text-decoration:underline;' href='".URL."login'>
									login </a> and fix the questionnaire before submitting it again
								</p>
							";
						}
						$message .= "
							<p style='margin-bottom:20px;'>Good Day {$recipientDetails['name']}</p>
							$paragraphyTwo
							<p style='margin-bottom:8px;'>
								<span style='font-weight:bold;'>NB</span><br/>
							   If you are not a user on ".SITENAME." please ignore this mail. Please do 
							   not reply to this mail as it is sent from an unmonitored address. You 
							   can contact us via ".CONTACTEMAIL."
							</p>
						";
						$message .= $function::footerHead(URL);
						
						//Send mail
						if(!DEVELOPMENT){
					  	$subject = "Vendor's Questionnaire Review";
					  	$headers  = 'MIME-Version: 1.0' . "\r\n";
					  	$headers .= 'Content-type: text/html; charset=iso-8859-1' . "\r\n";
					  	$headers .= "From: ".SITENAME." <noreply@".URLEMAIL.">" . "\r\n";
							mail($recipientDetails['email'], $subject, $message, $headers);
						}
					}
				}
			}
			
			//ACCEPTANCE action 
			if($action == "accept"){
				$recipientAuthority = [
					'review officer' => 'supervising officer','supervising officer' => 'deputy manager',
					'deputy manager' => 'manager', 'manager'=>'auditor'];
				
				//get email receipient's id
				$DbHandle->setTable('login');
				if($officerCollection = $DbHandle->iRetrieveData(__LINE__, ['authority'=>$recipientAuthority[$officerDetails['authority']]])){
					foreach ($officerCollection as $anOfficer) {
						$recipientID[] = $anOfficer['id'];
					}
				}
				
				//Emailing
				if($recipientID){
					foreach ($recipientID as $aRecipientID) {
						$recipientDetails = $User->userDetails($User->getEmailFrmID($aRecipientID));
						$vendorDetails = $User->userDetails($User->getEmailFrmID($aRecipientID));
						
						//compose email
						$message = $function::emailHead(URL);
						$paragraphyTwo = "
							<p style='margin-bottom:8px;'>
								We will like to inform you that there is vendor's questionnaire on ".SITENAME."
								awaiting your review. Please <a style='color:#fff; text-decoration:underline;' href='".URL."login'>
								login </a> and do this as soon as possible. The vendor's details is below
								<br/>
								<strong>Name:</strong>{$vendorDetails['company_name']}<br/>
								<strong>Email:</strong>{$vendorDetails['email']}<br/>
								<!--<strong>Phone:</strong>{$vendorDetails['company_name']}<br/>-->
							</p>
						";
						if($recipientAuthority[$officerDetails['authority']] == 'auditor'){
							$paragraphyTwo = "
								<p style='margin-bottom:8px;'>
									We will like to inform you that there is vendor whose questionnaire has 
									approved by JQS officer. Please <a style='color:#fff; text-decoration:underline;' href='".URL."login'>
									login </a> and schedule an audit visit as soon as possible. The vendor's 
									details is below
									<br/>
									<strong>Name:</strong>{$vendorDetails['company_name']}<br/>
									<strong>Email:</strong>{$vendorDetails['email']}<br/>
									<!--<strong>Phone:</strong>{$vendorDetails['company_name']}<br/>-->
								</p>
							";
						}
						$message .= "
							<p style='margin-bottom:20px;'>Good Day {$recipientDetails['name']}</p>
							$paragraphyTwo
							<p style='margin-bottom:8px;'>
								<span style='font-weight:bold;'>NB</span><br/>
							   If you are not a user on ".SITENAME." please ignore this mail. Please do 
							   not reply to this mail as it is sent from an unmonitored address. You 
							   can contact us via ".CONTACTEMAIL."
							</p>
						";
						$message .= $function::footerHead(URL);
						
						//Send mail
						if(!DEVELOPMENT){
					  	$subject = "Vendor's Questionnaire Review";
					  	$headers  = 'MIME-Version: 1.0' . "\r\n";
					  	$headers .= 'Content-type: text/html; charset=iso-8859-1' . "\r\n";
					  	$headers .= "From: ".SITENAME." <noreply@".URLEMAIL.">" . "\r\n";
							mail($recipientDetails['email'], $subject, $message, $headers);
						}
					}
				}
			}
			$oldTable = $this->getChangeTable();
		}
		
	}