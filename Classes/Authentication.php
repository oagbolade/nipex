<?php
	/**
	 * Authenication
   * 
   * This class is used for user login and authenication
   * @author      Alabi A. <alabi.adebayo@alabiansolutions.com>
   * @copyright   2017 Alabian Solutions Limited
   * @link        alabiansolutions.com
	 */
	class Authentication{
		private $_DbHandle;
		private $_constants;
		
		/**
     * Setup up db interaction
     * @param string $DbHandle an instant of DBHandler
     */
    public function __construct(DBHandler $DbHandle){
      $this->_DbHandle = $DbHandle;
			if($this->_DbHandle->getTable() != 'login') $DbHandle->setTable('login');
    }
		
		/**
		 * Set the value of the constants
		 * @param array $constants parameter(salt, url, urlemail, contactemail, development)
		 * @return void
		 */ 
		public function setConstants($constants){
			$this->_constants = $constants;
		}
		
		/**
		 * Retrieve the value of the salt to be used for hashing
		 * @param string $salt the salt value to be used
		 * @return string $salt the value of the salt
		 */
		public function getSalt(){
			return $this->_salt;
		}
		
		/**
		 * Log a user into the app and direct to appriopiate page 
		 * @param string $email the email of the user to login
		 * @param string $password password of the person to be login 
		 * @return boolean $loggedIn true if login is true or false otherwise
		 */
		public function loginUser($email, $password){
			$DbHandle = $this->_DbHandle;
			$loggedIn = false;
			$password = crypt($password, SALT);
			$key = ['password' => $password, 'email' => $email, 'status' => 'active'];
			if($userDetails = $DbHandle->iRetrieveData(__LINE__, $key)){
				$fingerPrint = md5(SALT . $_SERVER['HTTP_USER_AGENT'] . $password . $userDetails[0]['id'] . $email);
				$loggedIn = ['id' => $userDetails[0]['id'], 'email' => $email, 'username' => $userDetails[0]['username'], 'fingerPrint' => $fingerPrint];
				$_SESSION['nipexLogin'] = $loggedIn;
				$loggedIn = true;
			}
			return $loggedIn;
		}
		
		/**
		 * Log out a login user from the app
		 * @param array $constant array('url') for setConstants method to be called before this method
		 * @return void
		 */	
		public function logoutUser(){
  		$_SESSION = array();
  		session_destroy();
			header("Location: ". URL."login");
			exit();
		}
		
		/**
		 * Check if the user viewing a page is login
		 * @return void
		 */
		public function keyToPage(){
			$DbHandle = $this->_DbHandle; 
			if(isset($_SESSION['nipexLogin']['fingerPrint'])){
				$userDetails = $DbHandle->retrieveData(__LINE__, ['id' => $_SESSION['nipexLogin']['id']]);
				$userDetails = $userDetails[0];
				if(!$userDetails){
					$userDetails['password'] = ""; 
					$userDetails['id'] = "";
					$userDetails['email'] = "";
				}
			  if($_SESSION['nipexLogin']['fingerPrint'] != md5(SALT . $_SERVER['HTTP_USER_AGENT'] . $userDetails['password'] . $userDetails['id'] . $userDetails['email'])){
			  	session_regenerate_id();
			    $_SESSION = array();
			    session_destroy();
			    header("Location: ".URL."login");
					exit();
			  }
			}
			else {
			  session_regenerate_id();
			  $_SESSION = array();
			  session_destroy();
			  header("Location: ".URL."login");
				exit();
			}
		}		

		/**
		 * Grant user access to pages based on their priviledge
		 * @param array $accessorRight collection of permitted priviledge
		 * @param string $urRight your priviledge
		 * @return void
		 */
		public function pageAccessor($accessorRight, $urRight){
			if(!in_array($urRight, $accessorRight)){
				$this->logoutUser();
			}
		}
		
		/**
		 * Send reset code to user for password reset purpose
		 * @param Functions $functions an instance of Function object
		 * @param string $email the email of the user whose password is to be changed
		 * @return void
		 */
		public function sendResetCode(Functions $function, $email){
			$DbHandle = $this->_DbHandle;
			$constant = $this->_constants;
			$table = $DbHandle->getTable();
			$DbHandle->setTable('login');
			$token = substr($function->characterFromASCII($function->asciiTableDigitalAlphabet(),'string'), 0,16);
			$data = ['token'=>$token];
			$key = ['email'=>$email];
			$DbHandle->updateData(__LINE__, $data, $key);
			
			$constant=$this->_constants;
			$tokenUrl="
				<a style='color:#fff; text-decoration:underline;' href='".URL."password-change/?token=".urlencode($token)."&email=".urlencode($email)."'>
					".URL."password-change/?token=$token&email=$email
				</a>";
			
			$message=$function::emailHead(URL);
			$message.="
				<p style='margin-bottom:20px;'>Good Day </p>
				<p style='margin-bottom:8px;'>
					You are getting this mail because you requested to change your password on ".URL." You will 
					need to click on the link below or visit the link by copying and pasting it in your browser and hit enter.
					<br/>
					$tokenUrl
				</p>
				<p style='margin-bottom:8px;'>
					<span style='font-weight:bold;'>NB</span><br/>
				   If you did not requeste a password change at ".URL." please contact us immediately. Please do 
				   not reply to this mail as it is sent from an unmonitored address. You can contact us via 
				   ".CONTACTEMAIL."
				</p>
			";
			$message.=$function::footerHead($constant['url']);
			if(!$constant['development']){
		  	$subject="Password Reset";
		  	$headers  = 'MIME-Version: 1.0' . "\r\n";
		  	$headers .= 'Content-type: text/html; charset=iso-8859-1' . "\r\n";
		  	$headers .= "From: ".SITENAME." <noreply@".URLEMAIL.">" . "\r\n";
				mail($email, $subject, $message, $headers);
			}
			$DbHandle->setTable($table);
			if(DEVELOPMENT) return $tokenUrl;
		}
		
		/**
		 * Check if the reset code provided is valid
		 * @param string $email the email associated with the reset code
		 * @param string $resetCode the reset code to be checked
		 * @return boolean $validResetCode true if code is valid and false if otherwise
		 */
		private function isResetCodeValid($email, $resetCode){
			$User=$this->_User;
			if($User->retrieveData(__LINE__, array('email'=>$email, 'token'=>$resetCode))){
				$validResetCode=TRUE;
			}
			else {
				$validResetCode=FALSE;
			}
			return $validResetCode;
		}
		
		/**
		 * Used to change the password
		 * @param Functions $functions an instance of Functions object
		 * @param string $password the new password
		 * @param string $token password reset token
		 * @param string $email email of person whose password is to be changed 
		 * @return boolean $passwordChanged
		 */
		public function resetPassword(Functions $function, $password, $token, $email){
			$passwordChanged=FALSE;
			if($this->isResetCodeValid($email, $token)){
				$constant=$this->_constants;
				$password=crypt($password, SALT);
				$User = $this->_User;
				$User->updateData(__LINE__, ['password'=>$password], ['email'=>$email]);
				$userDetails=$this->_User->userDetails($email);
				$message=$function::emailHead($constant['url']);
				$message.="
					<p style='margin-bottom:20px;'>Good Day {$userDetails['name']}</p>
					<p style='margin-bottom:8px;'>
						This is to notify you that your password on {$constant['url']} has been changed.  
						<br/>
						<strong>Time: </strong> ".date("m:s Sj F Y")."<br/>
						<strong>IP Address: </strong> {$_SERVER['REMOTE_ADDR']}<br/>
					</p>
					<p style='margin-bottom:8px;'>
						<span style='font-weight:bold;'>NB</span><br/>
					   If you did not make this change at {$constant['url']} please contact 
					   us immediately. Please do not reply to this mail as it is sent from an unmonitored 
					   address. You can contact us via {$constant['contactemail']}
					</p>
				";
				$message.=$function::footerHead($constant['url']);
				if(!$constant['development']){
			  	$subject="Password Changed";
			  	$headers  = 'MIME-Version: 1.0' . "\r\n";
			  	$headers .= 'Content-type: text/html; charset=iso-8859-1' . "\r\n";
			  	$headers .= "From: Teks Global <noreply@".$constant['urlemail'].">" . "\r\n";
					mail($email, $subject, $message, $headers);
				}
				
				//email notification
				$passwordChanged = (DEVELOPMENT)? $message : TRUE;
			}
			else {
				$passwordChanged=FALSE;
			}
			return $passwordChanged;
		}
		
	}