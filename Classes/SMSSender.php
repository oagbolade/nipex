<?php
/**
	 * SMSSender
	 * 
	 * This class is used to SMS from your app using infobip API.
	 * @author			Alabi A. <alabi.adebayo@alabiansolutions.com, alabi10@yahoo.com, 08034265103>
	 * @copyright		2018 Alabian Solutions Limited
	 * @link 			alabiansolutions.com
	 */
	class SMSSender {
		protected $_username;
		protected $_password;
		protected $_senderID="ALABIAN";
		protected $_message;
		protected $_error=[];
		
		/**
		 * Set the username and password used to connect to the SMS gateway server
		 * @param string $username the username to connect to the SMS gateway server
		 * @param string $password the password to connect to the SMS gateway server
		 * @return void
		 */
		public function __construct($username="alabian", $password="Alabian1"){
			$this->_username=$username;
			$this->_password=$password;
		}
		
		/**
		 * Set the sender ID 
		 * @param string $senderID the sender's ID. Max lenght should  be 11 characters
		 * @return void 
		 */
		public function setSenderID($senderID){
			if(empty($senderID)){
				$this->_error['sender name'] = 'Blank Sender ID';
			}
			if($senderID>11) $senderID=substr($senderID, 0, 11); 
			$this->_senderID=$senderID;
		}
		
		/**
		 * Set the message to be sent 
		 * @param string $message the message to be sent
		 * @return void 
		 */
		public function setMessage($message){
			if(empty($message)){
				$this->_error['message'] = 'Blank Message';
			}
			$this->_message=$message;
		}
		
		/**
		 * Change GSM phone no into 2348XXXXXXXXX from 08XXXXXXXXX or 8XXXXXXXXX 
		 * @param string $phoneNo the phone  noto be formatted
		 * @return string $formattedPhoneNo the formatted phone no
		 */
		protected function formatPhoneNo($phoneNo){
			$formattedPhoneNo = "";
			if (strlen($phoneNo) == 11) {
				$phoneNo = ltrim($phoneNo, 0);
				$formattedPhoneNo = "234$phoneNo";
			}
			elseif (strlen($phoneNo) == 13) {
				$formattedPhoneNo = $phoneNo;
			}
			elseif (strlen($phoneNo) == 10) {
				$formattedPhoneNo = "234$phoneNo";
			}
			else{
				$formattedPhoneNo = "";
			}
			return $formattedPhoneNo;
		}	
		
		/**
		 * Send the message to the phone no supplied 
		 * @param mixed $phone a phone no or an array of phone nos format should be 2348XXXXXXXXX, 08XXXXXXXXX or 8XXXXXXXXX 
		 * @return boolean $result TRUE if message is sent and FALSE if message is not sent
		 */
		public function sender($phone){
			$result = false;
			$wrongNo = false;
			if(is_array($phone)){
				$anotherPhone = [];
				foreach($phone as $aPhone){
					if($this->formatPhoneNo($aPhone)){
						$anotherPhone[]=$this->formatPhoneNo($aPhone);
					}
				}
				$phone = $anotherPhone;
			}
			else{
				$phone = $this->formatPhoneNo($phone);
			}
			
			if(!$this->_error){
				$curl = curl_init();
				$smsJson = json_encode(['from'=>$this->_senderID, 'to'=>$phone, 'text'=>$this->_message]);
				$curlSetting = [
					CURLOPT_URL => "http://api.infobip.com/sms/1/text/single",
				  CURLOPT_RETURNTRANSFER => true,
				  CURLOPT_ENCODING => "",
				  CURLOPT_MAXREDIRS => 10,
				  CURLOPT_TIMEOUT => 30,
				  CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
				  CURLOPT_CUSTOMREQUEST => "POST",
				  CURLOPT_POSTFIELDS => $smsJson,
				  CURLOPT_HTTPHEADER => [
				    "accept: application/json",
				    "authorization: Basic ".base64_encode($this->_username.":".$this->_password),
				    "content-type: application/json"
				  ],
				 ];
				if(DEVELOPMENT) $curlSetting[CURLOPT_SSL_VERIFYPEER] = false;
				curl_setopt_array($curl, $curlSetting);
				if(!DEVELOPMENT){$response = curl_exec($curl);
					$err = curl_error($curl);
					curl_close($curl);
					if ($err) {
						$this->_error['gateway'] = $err;
						$result = false;
					} 
					else {
						$result = "0".count($phone);
					}
				}
			}
			return $result;
		}

		/**
		 * Get the number of delivered SMS
		 * @param array $response the response from infobip api
		 * @return integer the no of SMS delivered
		 */
		protected function noDeliveredSMS($response){
			$noSMS = 0;
			//var_dump(json_decode($response, true)); exit;
			return $noSMS;
		}
		
		/**
		 * Generate the error associated with not sending this SMS
		 * @return array $error the generated error(s)  
		 */
		public function generatedError(){
			$error = ($this->_error) ? $this->_error : []; 
			return $error;
		}
	}