<?php
	
	  require_once "../config.php";
	  require_once "../db-config.php";
	
	/**
   * Users
   * 
   * This class is used for user interaction
   * @author      Alabi A. <alabi.adebayo@alabiansolutions.com>
   * @copyright   2017 Alabian Solutions Limited
   * @link        alabiansolutions.com
   */
	class Users{
		public $_DbHandle;
		
		/**
     * Setup up db interaction
     * @param string $DbHandle an instant of DBHandler
     */
    public function __construct(DBHandler $DbHandle){
      $this->_DbHandle = $DbHandle;
	  if($this->_DbHandle->getTable() != 'login') $DbHandle->setTable('login');
    }
		
		/**
		 * Get the table dbHandler is using and change it to 'users' table
		 * @return string the table dbHandler is using
		 */
		private function getTableSetToUser(){
			$DbHandle = $this->_DbHandle;
			$table = $DbHandle->getTable();
			if($DbHandle->getTable() != 'login'){
				$DbHandle->setTable('login');
			}
			return $table;
		}
		
		/**
		 * Get the user's id from either email or username
		 * @param $string $emailOrUsername either the email or username of the user 
		 * @return integer $id the id of the user
		 */
		public function getIDFrmEmailOrUsername($emailOrUsername){
			$DbHandle = $this->_DbHandle;
			$table = $this->getTableSetToUser();
			$criteria = ['username'=>$emailOrUsername];
			if(filter_var($emailOrUsername, FILTER_VALIDATE_EMAIL)) $criteria = ['email'=>$emailOrUsername];
			$thisDetails = $DbHandle->iRetrieveData(__LINE__, $criteria);
			$id = $thisDetails[0]['id'];
			$DbHandle->setTable($table);
			return $id;
		}
		
		/**
		 * Get the user's email from username
		 * @param string $username the username of the usr
		 * @return string $email the retrieved email
		 */
		public function getEmailFrmUsername($username){
			$DbHandle = $this->_DbHandle;
			$table = $this->getTableSetToUser();
			$details = $DbHandle->iRetrieveData(__LINE__, ['username'=>$username]);
			$DbHandle->setTable($table);
			return $details[0]['email'];
		}
		
		/**
		 * Get the user's email from id
		 * @param integer $id the id of the usr
		 * @return string $email the retrieved email
		 */
		public function getEmailFrmID($id){
			$DbHandle = $this->_DbHandle;
			$table = $this->getTableSetToUser();
			$details = $DbHandle->iRetrieveData(__LINE__, ['id'=>$id]);
			$DbHandle->setTable($table);
			return $details[0]['email'];
		}
		
		/**
		 * Get the user's username from email
		 * @param string $email the email of the user
		 * @return string $username the retrieved username
		 */
		public function getUsernameFrmEmail($email){
			$DbHandle = $this->_DbHandle;
			$table = $this->getTableSetToUser();
			$details = $DbHandle->iRetrieveData(__LINE__, ['email'=>$email]);
			$DbHandle->setTable($table);
			return $details[0]['username'];
		}
		
		/**
		 * Check if email is associated with a user on the system 
		 * @param string $email the email be checked
		 * @return boolean $usedEmail true if email is used already
		 */	
		public function isEmailUsed($email){
			$DbHandle = $this->_DbHandle;
			$table = $DbHandle->getTable();
			$DbHandle->setTable('login');
			$data = ["email"=>$email];
	  		if($DbHandle->retrieveData(__LINE__, $data)){
	  			$usedEmail = TRUE;
	  		}
			else {
				$usedEmail = FALSE;
			}
			$DbHandle->setTable($table);
	  		return $usedEmail;
		}
		
		/**
		 * Check if username is associated with a user on the system 
		 * @param string $username the username be checked
		 * @return boolean $usedUsername true if username is used already
		 */	
		public function isUsernameUsed($username){
			$DbHandle = $this->_DbHandle;
			$table = $DbHandle->getTable();
			$DbHandle->setTable('login');
			$data = ["username"=>$username];
	  		if($DbHandle->retrieveData(__LINE__, $data)){
	  			$usedUsername = TRUE;
	  		}
			else {
				$usedUsername = FALSE;
			}
			$DbHandle->setTable($table);
	  		return $usedEmail;
		}

		/**
		 * Used to create a new logger
		 * @param Functions an instance of Functions object used to get access some cool functionality
		 * @param array $data an array of data to be inserted into the users table 
		 * @param integer $line the line no where this method is called from
		 * @param string $logger the type of logger been created
		 * @return boolean $created true if the account was successfully created or false otherwise
		 */
		public function createLogger(Functions $function, $data, $line, $logger){
			$DbHandle = $this->_DbHandle;
			$table = $DbHandle->getTable();
			$DbHandle->setTable("login");
			$message = "";
			$created = false;
			$usernameUsed = isset($data['username']) && $this->isUsernameUsed($data['username']);
			if(!($this->isEmailUsed($data['email']) || $usernameUsed)){
				//Store data in user table
				$loggerData = [
					'email' => $data['email'], 
					'authority' => $logger,
					'password' => crypt($data['password'], SALT), 
					'token' => substr($function->characterFromASCII($function->asciiTableDigitalAlphabet(),'string'), 0,16), 
					'date' => "NOW()", 
				];
				if($logger == 'pre-vendor'){
					$loggerData['status'] = "inactive";	
					$loggerData['default_password'] = "no";
					$mailUrl = "
						<a style='color:#fff; text-decoration:underline;' href='".URL."prevendor-checklist?token=".urlencode($loggerData['token'])."&email=".urlencode($loggerData['email'])."'>
							".URL."prevendor-checklist?token={$loggerData['token']}&email={$loggerData['email']}
						</a>
					";
					$requestRegister = "create";
					$congraMsg = "
						Congratulation for creating an account on ".URL.". You will need to verify your 
						company email address and also check that you have our mandatory document/information
						to be able to use your account.";
					$defaultPassword = "";
					$usernameForEmail = "";
					$loginEmail = "";
				}
				else {
					$loggerData['status'] = "active";
					$loggerData['username'] = $data['username'];
					$loggerData['default_password'] = "yes";
					$mailUrl = "
						<strong>NJQS Login URL:</strong>
						<a style='color:#fff; text-decoration:underline;' href='".URL."login'>
							".URL."login'
						</a>
					";
					$requestRegister = "request";
					$congraMsg = "
						Congratulation an account has been created for you at ".URL.". You will need to 
						visit the portal now and login. <strong>BUT YOU WILL TO CHANGE YOUR DEFAULT 
						PASSWORD ON FIRST SUCCESSFUL LOGIN.</strong>
						";
					$loginEmail = "<br/><strong>EMAIL:</strong> {$loggerData['email']}";
					$usernameForEmail = "<br/><strong>USERNAME:</strong> {$data['username']}";
					$defaultPassword = "<br/><strong>DEFAULT PASSWORD:</strong> {$data['password']}";
				}
				$newLogger = $DbHandle->createData(__LINE__, $loggerData);
				$created = true;
				
				//Create pre vendor or staff
				if($logger == 'pre-vendor'){
					$preVendorData = [
						'login_id' => $newLogger['insertedID'],
						'company_name' => $data['company name'],
						'cac_no' => $data['rc no'],
						'phone_no' => $data['company phone']
					];
					$this->createPreVendor($preVendorData, $line);
				}
				else {
					$staffData = [
						'login_id' => $newLogger['insertedID'], 
						'name' => $data['name'],
						'phone' => $data['phone'],
						'passport' => 'profile.png'
						];
					$this->createStaff($staffData, $line);
				}
				
				//Send mail to user
				$message = $function::emailHead(URL);
				$message .= "
					<p style='margin-bottom:20px;'>Good Day Sir/Madam</p>
					<p style='margin-bottom:8px;'>
						$congraMsg You will need to click on the link below to do that or copy and paste in the address bar of your 
						browser to do same.
						<br/>
						$mailUrl
						$loginEmail
						$usernameForEmail
						$defaultPassword
					</p>
					<p style='margin-bottom:8px;'>
						<span style='font-weight:bold;'>NB</span><br/>
					   If you did not $requestRegister for an account at ".URL." please ignore this mail.
					   Please do not reply to this mail as it is sent from an unmonitored address. You 
					   can contact us via ".CONTACTEMAIL."
					</p>
				";
				$message .= $function::footerHead(URL);
				if(!DEVELOPMENT){
			  	$subject = "Account/Email Verification";
			  	$headers  = 'MIME-Version: 1.0' . "\r\n";
			  	$headers .= 'Content-type: text/html; charset=iso-8859-1' . "\r\n";
			  	$headers .= "From: ".SITENAME." <noreply@".URLEMAIL.">" . "\r\n";
					mail($data['email'], $subject, $message, $headers);
				}
			}
			$DbHandle->setTable($table);
			if(DEVELOPMENT) return $message;
			return $created;
		}
		
		/**
		 * Used to create a new pre vendor
		 * @param array $data an array of data to be inserted into the applicant table 
		 * @param integer $line the line no where this method is called from
		 * @return null
		 */
		private function createPreVendor($data, $line){
			$DbHandle = $this->_DbHandle;
			$table = $DbHandle->getTable();
			$DbHandle->setTable("pre_vendor");
			$DbHandle->createData($line, $data);
			$DbHandle->setTable($table);
		}
		
		/**
		 * Used to create a new pre vendor
		 * @param array $data an array of data to be inserted into the applicant table 
		 * @param integer $line the line no where this method is called from
		 * @return null
		 */
		private function createStaff($data, $line){
			$DbHandle = $this->_DbHandle;
			$table = $DbHandle->getTable();
			$DbHandle->setTable("staff");
			$DbHandle->createData($line, $data);
			$DbHandle->setTable($table);
		}
		
		/**
		 * Used to delete a user
		 * @param string $email the email of the user
		 * @param integer $id the user id from the users table
		 */
		public function deleteUser($email){
			$userDetail = $this->userDetails($email);
			if($userDetail['authority'] == 'vendor'){
				//code to details all uploaded docuement for this used
				//['vendor_id']
			}
			$DbHandle = $this->_DbHandle;
			$table = $DbHandle->getTable();
			$DbHandle->setTable('login');
			$DbHandle->deleteData(__LINE__, ['email' => $email]);
			$DbHandle->setTable($table);
		}
		
		/**
		 * Used to get detail of a user from the database
		 * @param string $email the email of the user
		 * @return mix $userDetails an array that contains the details of the user or false if no such user
		 */
		public function userDetails($email){
			$DbHandle = $this->_DbHandle;
			$table = $DbHandle->getTable();
			$details = false;
			$DbHandle->setTable("login");
			if($loginDetails = $DbHandle->retrieveData(__LINE__, ['email'=>$email])){
				foreach ($loginDetails[0] as $detailsKey=>$detailsValue) {
					$details[$detailsKey] = $detailsValue;
				}
			}
			$tables = Functions::authorityTable();
			$thisTable = $tables[$details['authority']];
			$DbHandle->setTable($thisTable);
			if($thisDetails = $DbHandle->iRetrieveData(__LINE__, ['login_id'=>$details['id']])){
				foreach ($thisDetails[0] as $field => $record) {
					if(isset($details[$field])){
						$details["{$thisTable}_{$field}"] = $record;
					}
					else {
						$details[$field] = $record;	
					}
				}
			}		
			$DbHandle->setTable($table);
			return $details;
		}
		
		/**
		 * Used to get all the users details on the app
		 * @param string $authority the user type if pre-vendor, vendor, staff or staff type
		 * @return mix $allDetails an array that contains all user details or false is no user in the app
		 */
		public function allUserDetails($authority){
			$DbHandle = $this->_DbHandle;
			$tableUsed = Functions::authorityTable();
			$table = $DbHandle->getTable();
			$allDetails = false;
			if(isset($tableUsed[$authority])){
				$DbHandle->setTable($tableUsed[$authority]);
				$allUsers = $DbHandle->iRetrieveData(__LINE__);
				if($allUsers){
					foreach($allUsers as $aUser){
						$aUserDetails = $this->userDetails($this->getEmailFrmID($aUser['login_id']));
						$aUser['id'] = $aUserDetails['id'];
						$aUser['authority'] = $aUserDetails['authority'];
						if(isset($aUserDetails['vendor_id'])) $aUser['vendor_id'] = $aUserDetails['vendor_id'];
						if(isset($aUserDetails['company'])) $aUser['company'] = $aUserDetails['company'];
						if(isset($aUserDetails['vendor_status'])) $aUser['vendor_status'] = $aUserDetails['vendor_status'];
						if(isset($aUserDetails['expiration_date'])) $aUser['expiration_date'] = $aUserDetails['expiration_date'];
						$aUser['email'] = $aUserDetails['email'];
						$aUser['status'] = $aUserDetails['status'];
						$aUser['default_password'] = $aUserDetails['default_password'];
						$aUser['token'] = $aUserDetails['token'];
						$aUser['authority'] = $aUserDetails['authority'];
						$allDetails[] = $aUser;
					}
				}
			}
			$DbHandle->setTable($table);
			return $allDetails;
		}

		/**
		 * Used to get detail of a vendor from the database
		 * @param string $email the email of the vendor
		 * @param string $table the table to get the details from
		 * @return mix $vendorDetails an array that contains the details of the user or false if no such user
		 */
		public function vendorDetails($email, $vendorTable = 'login'){
			$DbHandle = $this->_DbHandle;
			$table = $DbHandle->getTable();
			$details = false;
			$DbHandle->setTable('vendor');
			$id = $this->getIDFrmEmailOrUsername($email);
			if($vendorDetails = $DbHandle->retrieveData(__LINE__, ['login_id'=>$id])){
				foreach ($vendorDetails[0] as $detailsKey=>$detailsValue) {
					$details[$detailsKey] = $detailsValue;
				}
			}
			if($vendorTable=="login"){
				
			}
			else {
				$DbHandle->setTable($vendorTable);
				if($thisDetails = $DbHandle->iRetrieveData(__LINE__, ['vendor_id'=>$details['id']])){
					foreach ($thisDetails[0] as $field => $record) {
						if(isset($details[$field])){
							$details["{$vendorTable}_{$field}"] = $record;
						}
						else {
							$details[$field] = $record;	
						}
					}
				}	
			}
					
			$DbHandle->setTable($table);
			return $details;
		}
		
		/**
		 * Use to flip user account status between active and inactive
		 * @param string $email the email of the user
		 * @param string $status either active or inactive
		 * @param Function $functions an instance of Function object
		 * @param string $sendMail if true user is notify via mail about activation
		 * @return void
		 */
		public function changeUserStatus($email, $status, Functions $function, $sendMail = true){
			$DbHandle = $this->_DbHandle;
			$table = $DbHandle->getTable();
			$DbHandle->setTable('login');
			$data = array('status' => $status);
			$key = array('email' => $email);
			$DbHandle->updateData(__LINE__, $data, $key);
			
			//Send mail to user
			if($sendMail){
				if($status == 'active'){
					$firstParagraph = "
						Congratulation your account on Membership Application Portal has been activated. You can now 
						<a href='".URL."' style='color:#fff; text-decoration:underline;'>login</a>, in case you 
						have forgotten your password please just do a password reset by clicking on 'Lost Password?'
					";
				}
				else {
					$firstParagraph = "This is to inform you that your account on Membership Application Portal has been suspended.";
				}
				$message = $function::emailHead(URL);
				$message .= "
					<p style='margin-bottom:20px;'>Good Day Sir/Madam</p>
					<p style='margin-bottom:8px;'>
						$firstParagraph 
					</p>
					<p style='margin-bottom:8px;'>
						<span style='font-weight:bold;'>NB</span><br/>
					   If you did not have an account at ".URL." please ignore this mail. Please do 
					   not reply to this mail as it is sent from an unmonitored address. You can contact us via ".CONTACTEMAIL."
					</p>
				";
				$message .= $function::footerHead(URL);
				if(!DEVELOPMENT){
			  	$subject = "Account Activation";
			  	$headers  = 'MIME-Version: 1.0' . "\r\n";
			  	$headers .= 'Content-type: text/html; charset=iso-8859-1' . "\r\n";
			  	$headers .= "From: ".SITENAME." <noreply@".URLEMAIL.">" . "\r\n";
					mail($email, $subject, $message, $headers);
				}				
			}	
			//Restore table
			$DbHandle->setTable($table);
		}			
	}