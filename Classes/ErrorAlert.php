<?php
	/**
	 * ErrorAlert
	 * 
	 * This class is used to notify admin of website of error
	 * @author			Alabi A. <alabi.adebayo@alabiansolutions.com>
	 * @copyright		2016 Alabian Solutions Limited
	 * @link 				alabiansolutions.com
	 */

	class ErrorAlert{
		private $_toEmail='info@alabiansolutions.com';
		private $_filename='error.txt';
		private $_msg;
		private $_constant;
		private $_functions;

		/**
		 * Setup up the ErrorAlert with msg, and other parameters
		 * @param string $msg the error message from the server
		 * @param Functions $founctions an instance of Function object
		 * @param array $constants an array('url','urlemail','development','directory', sitename) of needed of constants
		 * @return void
		 */
		public function __construct($msg, Functions $functions, $constant){
			$this->_msg = $msg;
			$this->_constant = $constant;
			$this->_functions = $functions;
		}
		
		/**
		 * Send error alert out via email and log to file
		 * @return void
		 */
		public function sendAlerts(){
			$this->writeToFile();
			$this->sendToEmail();
		}
		
		/**
		 * Form the error message to be sent out
		 * @return string $message the error message to be sent out
		 */
		private function setEmailMsg(){
			$error=$this->_msg;
			$constant = $this->_constant;
			$message="
				<p style='margin-bottom:10px; margin-top:10px;'>Good Day Admin</p>
				<p style='margin-bottom:10px;'>
					This is to inform you that something went wrong on {$constant['sitename']}. This error has 
					been log to file on server, which you can review anytime.  
				</p>
				<p style='margin-bottom:60px;'>
				<strong>Error Message</strong><br/>
				$error<br/>
				{$_SERVER['REMOTE_ADDR']}<br/>
				{$_SERVER['HTTP_USER_AGENT']}<br/>"
				.date('l F jS, Y - g:ia')."<br/>
			";
			return $message;
		}

		/**
		 * Write error message to file
		 * @return void
		*/
		private function writeToFile(){
			$constant = $this->_constant;
			$fileLocation = ROOT;
			$filename = $this->_filename;
			$error = $this->_msg." ".$_SERVER['REMOTE_ADDR']." ".$_SERVER['HTTP_USER_AGENT']." ".date('l F jS, Y - g:ia').PHP_EOL;
			$fileHandle = fopen("$fileLocation/$filename", 'a+');
			if ($fileHandle){
				fputs($fileHandle, $error);
				fclose($fileHandle);
  		}
		}

		/**
		 * Send error message to an email
		 * @return void
		*/
		private function sendToEmail(){
			$constant=$this->_constant;
			$functions=$this->_functions;
			$message=$functions::emailHead($constant['url']);
			$message .= $this->setEmailMsg();
			$message.=$functions::footerHead($constant['url']);
			$subject="{$constant['sitename']} System Error";
			$headers  = 'MIME-Version: 1.0' . "\r\n";
			$headers .= 'Content-type: text/html; charset=iso-8859-1' . "\r\n";
			$headers .= "From: System <noreply@".$constant['urlemail'].">" . "\r\n";
			if(!$constant['development']){
				mail($this->_toEmail, $subject, $message, $headers);
			}
		}
	}