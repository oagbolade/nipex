<?php
  /**
	 * Validator
	 * 
	 * This class is used to validate data sent to script before they are processed. ver1.0 2014, ver1.1 Mar'17
	 * @author			Alabi A. <alabi.adebayo@alabiansolutions.com, alabi10@yahoo.com, 08034265103
	 * @copyright		2014 Alabian Solutions Limited
	 * @link 			alabiansolutions.com
	 */
  class Validator{
  	private $_salt='$2a$12$q.g9b282NOFtZ4hPp1y2Cy$';
  	
	/**
	 * Removes malicious character sent via HTML Form tag
	 * @param string $var the data to be sanitized
	 * @return string $sanitizedVar the santiized data
	 */
	protected function sanitizeString($var){
      $var = stripslashes($var);
      $var = htmlspecialchars($var, ENT_QUOTES, 'UTF-8');
      $sanitizedVar = strip_tags($var);
      return $sanitizedVar;
	}
   
	/**
	 * Change the default value of the salt to be used
	 * @param string $salt the salt value to be used
	 * @return void
	 */
	public function setSalt($salt){
		$this->_salt=$salt;
	}
	
	  
	/**
	 * Check for valid name
	 * @param mix $name the name to be validated
	 * @return string $validName the validated name
	 */ 
  public function getValidatedName($name){
	  if(empty($name)){
	    	$validName=FALSE;
	  }
		else {
			if(strlen($name)==1){
	    	$validName=FALSE;
	    }
	  	$validName = $this->sanitizeString($name);
		}
	  return $validName;
  }
		
	/**
	 * Check for valid numeric value return the a valid numeric value or false on faliure
	 * @param mix $number number to be validated
	 * @return mix $validNumber the validated number
	 */
  public function getNumericData($number){
		if(is_numeric($number)){
	  	$validNumber= floatval($number);
	  }
		else {
			$validNumber= FALSE;
		}
		return $validNumber;
  }
	
	/**
	 * Check for valid integer value return the a valid integer value or false on faliure
	 * @param mix $integer integer to be validated
	 * @return mix $validInteger the validated number
	 */
  public function getIntegerData($integer){
  	$validInteger=filter_var($integer, FILTER_VALIDATE_INT);
		return $validInteger;
  }
	
	/**
	 * Check if supplied data is empty return a santized data or false on failure
	 * @param mix $data to be checked
	 * @return mix $validData the santized non empty data or false on failure
	 */
	public function getNonEmptyData($data){
    if(empty($data)){
    	$validData= FALSE;
    }
		else {
			$validData = $this->sanitizeString($data);
		}
  	return $validData;
  }
	
	/**
	 * Sanitize data the data and even empty data can be supplied
	 * @param mix $data to be santized
	 * @return mix $santiziedData the santized data
	 */
	public function getSanitizeData($data){
	  $santiziedData = $this->sanitizeString($data);
	  return $santiziedData;
  }
	
	/**
	 * Check if supplied phone is a valid GSM phone no (08012345678 format) return the phone or false on failure
	 * @param mix $data to be santized
	 * @return mix $validPhone the valid GSM phone no
	 */
	public function getValidated080GSMNo($data){
    if(empty($data)){
    	$validPhone= FALSE;
    }
		else {
			if (preg_match ("/^0[0-9]{10}$/", $data)){
    	$validPhone= $data;	
	  	}
	  	else {
	    	$validPhone= FALSE;
	  	}
		}
		return $validPhone;
  }
	
	/**
	 * Check if email is valid no return the email or false on failure
	 * @param mix $data the email to be santized
	 * @return mix $validEmail the valid email
	 */
	public function getValidatedEmail($data){
    if(empty($data)){
    	$validEmail= FALSE;
    }
		else {
			$validEmail=filter_var($data, FILTER_SANITIZE_EMAIL);
		  if (filter_var($data, FILTER_VALIDATE_EMAIL)){
		    $validEmail= $data;
		  }
		  else {
				$validEmail=  FALSE;  
  		}		
		}
  	return $validEmail;
  }
	
	/**
	 * Check if password rule is obeyed, 
	 * minimum 8 characters, 
	 * minimum 1 upper case, 
	 * minimum 1 lower,
	 * minimum one digit
	 * @param mix $data the password to be checked
	 * @return mix $validPassword the valid password or false if rule is failed
	 */
   	public function enforceRulePassword($data){
      if (strlen($data) >= 8){
      	$validPassword= $data;
    	} 
    	else{
      	$validPassword= FALSE;
			}
			
			/*if (preg_match ("/^.*(?=.{8,})(?=.*\d)(?=.*[a-zA-Z]).*$/", $data)){
      	$validPassword= $data;
    	} 
    	else{
      	$validPassword= FALSE;
			}*/
			
			return $validPassword;
    }
			
	/**
	 * Produce hashed password using the bcrypt hashing algorithm 
	 * @param string $password the password to be hashed
	 * @return mix $hashedPassword the hashed password or false if no password is supplied
	 */
    public function getBCyptPassword($password){
      if(empty($password)){
      	$hashedPassword= FALSE;
      }
			else {
				$hashedPassword=crypt($password, $this->_salt);	
			}
	  	return $hashedPassword;
    }
	
		/**
		 * Check if no data is supplied in textarea
		 * @param string $data the data in the textarea
		 * @return mix $validData the validated data in the textarea or false if nothing is supplied
		 */
    public function getNonEmptyTextField($data){
      if(strlen($data)==0){
      	$validData= FALSE;
      }
			else {
				$validData = $this->sanitizeString($data);	
			}
	  return $validData;
    }
		
		/**
		 * Check file supplied is of the type specified and size specified too
		 * @param string $file the file to be checked
		 * @param array $type an array that contains the the permitted filetype
		 * @return array $fileStatus array that contains the status of the file checked
		 */
    public function getValidateFile($name, $type){
    	$fileStatus= array('status'=>FALSE, 'ext'=>null);
    	if(!empty($name)){
      	$fileStatus= array('status'=>FALSE, 'ext'=>null);
				foreach ($type as $aType) {
					$ext=strrpos($name, $aType, -1);
					if($ext){
						$fileStatus= array('status'=>$name, 'ext'=>$aType);
						break;
					}   
	  		}
			}
	  	return $fileStatus;
    }
		
		/**
		 * Check if a data is in list usually the list is an array
		 * @param mix $data the data to be checked in in list
		 * @param array $list the list to be used for the checked
		 * @return mix $foundData the data found in the list or false if not found
		 */
		public function checkInList($data, $list){
			if(is_array($data)){
				foreach ($data as $aData) {
					if(!in_array($aData, $list)){
						$foundData=FALSE; return $foundData;
					}
					else {
						$foundData[]=$aData;
					} 
				}
			}
			else {
				if(in_array($data, $list)){
					$foundData=$data;
				}
				else {
					$foundData=FALSE;
				}
			}
			return $foundData;
		}
		
		/**
		 * Validate the data sent via HTML form
		 * @param $dataSet array an array that contain the field to be validate and the validation string
		 * @return $validedDataSet array an array that contain the worked on dataset
		 */
		public function formValidation($dataSet){
			$error=FALSE; $data=array();
			foreach ($dataSet as $aData) {
				if($aData['validationString']=='name'){
					$data[$aData['dataName']]=$this->getValidatedName(trim($aData['dataValue']));
				}
				if($aData['validationString']=='number'){
					$data[$aData['dataName']]=$this->getNumericData(trim($aData['dataValue']));
				}
				if($aData['validationString']=='integer'){
					$data[$aData['dataName']]=$this->getIntegerData(trim($aData['dataValue']));
				}
				if($aData['validationString']=='non empty'){
					$data[$aData['dataName']]=$this->getNonEmptyData(trim($aData['dataValue']));
				}
				if($aData['validationString']=='sanitize'){
					$data[$aData['dataName']]=$this->getSanitizeData(trim($aData['dataValue']));
				}
				if($aData['validationString']=='gsm phone'){
					$data[$aData['dataName']]=$this->getValidated080GSMNo(trim($aData['dataValue']));
				}
				if($aData['validationString']=='email'){
					$data[$aData['dataName']]=$this->getValidatedEmail(trim($aData['dataValue']));
				}
				if($aData['validationString']=='password rule'){
					$data[$aData['dataName']]=$this->enforceRulePassword(trim($aData['dataValue']));
				}
				if($aData['validationString']=='non empty textarea'){
					$data[$aData['dataName']]=$this->getNonEmptyTextField(trim($aData['dataValue']));
				}
				if($aData['validationString']=='in list'){
					$data[$aData['dataName']]=$this->checkInList($aData['dataValue'],$aData['dataList']);
				} 
			}
			foreach ($data as $aData) {
				if($aData===FALSE) $error=TRUE;
			}
			$validedDataSet=array('error'=>$error, 'data'=>$data);
			return $validedDataSet;
		}

		/**
		 * Validate file data sent via HTML form
		 * @param $file array the $_FILES first index from HTML form
		 * @param $fileTypes array a list of the permitted file type
		 * @param $fileSize integer the maxmium filesize permitted
		 * @return $fileStatus array['error', 'data'=>['ext','status']] 
		 */
		public function formValidationFile($file, $fileType, $fileSize){
			$error=FALSE; $data=array();
			if($file['error']){
				$error=TRUE;
				if($file['error']==1) $error="Error 1";
				if($file['error']==2) $error="File larger than permitted limit";
				if($file['error']==3) $error="File upload was partial";
				if($file['error']==4) $error="No file was attached";
				if($file['error']==5) $error="Error 5";
				if($file['error']==6) $error="Error 6";
				if($file['error']==7) $error="Error 7";
				if($file['error']==8) $error="Error 8";
			}
			else {
				if($file['size']>$fileSize){
					$error="File larger than permitted limit";
				}
				else {
					$data=$this->getValidateFile($file['name'], $fileType);
					if($data['ext']==null && $data['status']==FALSE) $error="No file was attached";
					if($data['ext']==null) $error="Invalid file uploaded";
				}
			}
			$fileStatus=array('error'=>$error, 'data'=>$data);
			return $fileStatus;
		}
		
  }