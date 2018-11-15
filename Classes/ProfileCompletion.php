<?php
	/**
	 * Bank
   * 
   * This class is used to get a profile completion 
   * @author      Alabi A. <alabi.adebayo@alabiansolutions.com>
   * @copyright   2018 Alabian Solutions Limited
   * @link        alabiansolutions.com
	 */
	class ProfileCompletion{
		private $_email;
		private $_DbHandle;
		
		/**
     * Setup up db connection and user's email
		 * @param DBHandler $DBHandler an instance of DBHandler type
     * @param string $email user's email
		 * @param string $file script where instantion token place
     * @return void
     */
    public function __construct(DBHandler $DBHandler, $email){
    	$this->_email = $email;
			$this->_DbHandle = $DBHandler;
    }
		
		/**
		 * Calculate completion level
		 * @param array $data data to be checked
		 * @param string $table table to check data from
		 * @param number $line line the method was called from
		 * @return number $completion percentage completion 
		 */
		private function computeCompletion($data, $table, $line){
			$DbHandle = $this->_DbHandle;
			$DbHandle->setTable($table);
			$totalInfo = count($data);
			$submittedInfo = 0;
			if($info = $DbHandle->iRetrieveData($line, ['email' => $this->_email], $data)){
				foreach ($info[0] as $anInfoKey => $anInfo) {
					if($anInfoKey == 'passport' && $anInfo == 'profile.png' ) $anInfo = null;
					if($anInfo) ++$submittedInfo;
				}				
			}
			$completion = ($totalInfo) ? round(($submittedInfo/$totalInfo)*100) : 0;
			return $completion;
		}
		
		/**
		 * Evaluate general application info completion level
		 * @param number $line line from where this method is called
		 * @return number $completion completion level
		 */ 
		public function generalInfo($line){
			$data = ['email', 'title', 'f_name', 's_name', 'phone', 'passport', 'dob', 'nationality', 
			'state_origin', 'address', 'company', 'company_address', 'job_title', 'nature_work'];
			$completion = $this->computeCompletion($data, "application", $line);
			return $completion;
		}
		
		/**
		 * Evaluate academic application info completion level
		 * @param number $line line from where this method is called
		 * @return number $completion completion level
		 */ 
		public function academicInfo($line){
			$DbHandle = $this->_DbHandle;
			$info = [];
			$submittedInfo = 0;
			
			//applicant cv and nysc
			$DbHandle->setTable('app_qualification');
			$data = ['cv', 'nysc'];
			if($infoSet1 = $DbHandle->iRetrieveData($line, ['email' => $this->_email], $data)){
				foreach ($infoSet1[0] as $anInfoSet1) {
					$info[] = $anInfoSet1;
				}	
			}
						
			//applicant academic certificate
			$DbHandle->setTable('app_certificate');
			$data[] = 'academic';
			$info['academic'] = "";
			if($infoSet2 = $DbHandle->iRetrieveData($line, ['email'=>$this->_email])) $info['academic'] = true;
			
			foreach ($info as $anInfo) {
				if($anInfo) ++$submittedInfo;
			}
			
			$totalInfo = count($data);
			$completion = ($totalInfo) ? round(($submittedInfo/$totalInfo)*100) : 0;
			return $completion;
		}
		
		/**
		 * Evaluate emplopyment application info completion level
		 * @param number $line line from where this method is called
		 * @return number $completion completion level
		 */ 
		public function employmentInfo($line){
			$DbHandle = $this->_DbHandle;
			$DbHandle->setTable('app_employment');
			$completion = 0;
			if($DbHandle->iRetrieveData($line, ['email'=>$this->_email])) $completion = 100;
			return $completion;
		}
		
		/**
		 * Evaluate sponsor application info completion level
		 * @param number $line line from where this method is called
		 * @return number $completion completion level
		 */ 
		public function sponsorInfo($line){
			$DbHandle = $this->_DbHandle;
			$DbHandle->setTable('app_sponsor');
			$completion = 0;
			if($DbHandle->iRetrieveData($line, ['accept' => 'yes', 'email'=>$this->_email])) $completion = 100;
			return $completion;
		}
			
	}	