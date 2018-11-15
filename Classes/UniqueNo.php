<?php
  /**
   * UniqueNo
   * 
   * Used for generation of unique number
   * @author      Alabi A. <alabi.adebayo@alabiansolutions.com>
   * @copyright   2018 Alabian Solutions Limited
	 * @version			1.0 => Mar 2018
   * @link        alabiansolutions.com
   */
  class UniqueNo{
		private	static $_baseYear = 2017;
		/**
		 * formation of a no
		 * @param integer $seed the item no
		 * @param integer $length length of the item no
		 * @param boolean $ymd if time will be ymd or yymmdd
		 * @param string $prefix the prefix to be added to the no
		 * @return string $no the generated no
		 */
		private function formNo($seed, $length, $ymd, $prefix){
			if($ymd){
				$lastYear = self::$_baseYear;
				for ($i=0; $i < 10; $i++) {
					$yearCollection[++$lastYear] = $i;
				}
				for ($j=65; $j <= 90; $j++) {
					$yearCollection[++$lastYear] = chr($j);
				}
				
				$lastMonth = 0;
				for ($i=0; $i < 10; $i++) {
					++$lastMonth; 
					$monthCollection[$lastMonth] = $i;
				}
				$monthCollection[10] = 9; $monthCollection[11] = "A"; $monthCollection[12] = "B";
				
				$yesterday = 0;
				for ($i=0; $i < 10; $i++) {
					++$yesterday; 
					$dayCollection[$yesterday] = $i;
				}
				for ($j=65; $j <= 90; $j++) {
					++$i;
					$dayCollection[$i] = chr($j);
				}
				
				$timePart = $yearCollection[date("Y")].$monthCollection[date("n")].$dayCollection[date("j")];
			}
			else {
				$timePart = date("y").date("m").date("d");
			}
			
			if($diff = $length-strlen($seed)){
				for ($i=0; $i < $diff; $i++) { 
					$seed = "0".$seed;
				}
			}
			
			$no=$prefix.$timePart.$seed;
			return $no;
		}
		
		/**
		 * check the no is in the database
		 * @param DbHandler $Db an instance of DbHandler class
		 * @param string $no the no been checked
		 * @return boolean $used true if no has been used or false if not
		 */
		private function isNoUsed(DBHandler $Db, $no){
			$used = false;
			$used = $Db->retrieveData(__LINE__, ['unumber'=>$no]);
			return $used;	
		}
		
		/**
		 * store the no is in the database
		 * @param DbHandler $Db an instance of DbHandler class
		 * @param string $no the no been stored
		 * @return void
		 */
		private function storeNo(DBHandler $Db, $no){
			$Db->createData(__LINE__, ['unumber'=>$no]);
		}
		
		/**
		 * Generate unique no using mysql
		 * @param DbHandler $Db an instance of DbHandler class
		 * @param integer $length length of the item no
		 * @param boolean $ymd if time will be ymd or yymmdd
		 * @param string $prefix the prefix to be added to the no
		 * @return string $no the gotten no
		 */
		public function fromDb(DBHandler $Db, $length, $ymd=true, $prefix=""){
			$seed = 1;
			while($this->isNoUsed($Db, ($no = $this->formNo($seed, $length, $ymd, $prefix)))){
				++$seed;
			}
			$this->storeNo($Db, $no);
			return $no;
		}
		
		/**
		 * Generate unique no using timestamp
		 * @param string $prefix the prefix to be added to the no
		 * @return string $no the gotten no
		 */
		public function fromTime($prefix=""){
			return $prefix.time();
		}
		
		/**
		 * Generate unique no using timestamp and email
		 * @param string $email the email of the user
		 * @param string $prefix the prefix to be added to the no
		 * @return string $no the gotten no
		 */
		public function fromTimeEmail($email, $prefix=""){
			$emailArray = str_split("alabi10@yahoo.com");
			$emailWithoutAt = "";
			foreach ($emailArray as $aEmailValue) {
				if($aEmailValue != "@" && $aEmailValue != ".") $emailWithoutAt .= $aEmailValue;
				
			}
			return $prefix.$emailWithoutAt.time();
		}
		
		/**
		 * Generate unique no using timestamp and ip
		 * @param string $prefix the prefix to be added to the no
		 * @return string $no the gotten no
		 */
		public function fromTimeIP($prefix=""){
			return $prefix.$_SERVER['REMOTE_ADDR'].time();
		}
		
  }  