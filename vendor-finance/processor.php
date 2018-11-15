<?php
	//Get required files
	require_once '../config.php'; 
	require_once '../db-config.php'; 
	
	//Turn off magic quotes
	Functions::magicQuotesOff();
	
	//Check if the access to this script is coming from its index's page
  if(isset($_POST['token']) && $_POST['token']==$_SESSION['token']){
  	// unset($_SESSION['token']);
		
		//Initialization
		$response = "";
		$constant = [
			'url' => URL, 'urlemail' => URLEMAIL, 'contactemail' => CONTACTEMAIL, 
			'development' => DEVELOPMENT, 'sitename' => SITENAME];
		
		//Get validator to validate data sent to this script
		$FormValidator = new Validator();
		
		//Prepare form data for Validator
		$data[] = ['validationString' => 'sanitize', 'dataName' => 'accountingYear1', 'dataValue' => $_POST['accountingYear1']];
		$data[] = ['validationString' => 'sanitize', 'dataName' => 'accountingYear2', 'dataValue' => $_POST['accountingYear2']];
		$data[] = ['validationString' => 'sanitize', 'dataName' => 'accountingYear3', 'dataValue' => $_POST['accountingYear3']];
		$data[] = ['validationString' => 'sanitize', 'dataName' => 'reportingCurrency1', 'dataValue' => $_POST['reportingCurrency1']];
		$data[] = ['validationString' => 'sanitize', 'dataName' => 'reportingCurrency2', 'dataValue' => $_POST['reportingCurrency2']];
		$data[] = ['validationString' => 'sanitize', 'dataName' => 'reportingCurrency3', 'dataValue' => $_POST['reportingCurrency3']];
		$data[] = ['validationString' => 'sanitize', 'dataName' => 'yearEnding1', 'dataValue' => $_POST['yearEnding1']];
		$data[] = ['validationString' => 'sanitize', 'dataName' => 'yearEnding2', 'dataValue' => $_POST['yearEnding2']];
		$data[] = ['validationString' => 'sanitize', 'dataName' => 'yearEnding3', 'dataValue' => $_POST['yearEnding3']];
		$data[] = ['validationString' => 'sanitize', 'dataName' => 'auditedAccount1', 'dataValue' => $_POST['auditedAccount1']];
		$data[] = ['validationString' => 'sanitize', 'dataName' => 'auditedAccount2', 'dataValue' => $_POST['auditedAccount2']];
		$data[] = ['validationString' => 'sanitize', 'dataName' => 'auditedAccount3', 'dataValue' => $_POST['auditedAccount3']];
		$data[] = ['validationString' => 'sanitize', 'dataName' => 'annualTurnover1', 'dataValue' => $_POST['annualTurnover1']];
		$data[] = ['validationString' => 'sanitize', 'dataName' => 'annualTurnover2', 'dataValue' => $_POST['annualTurnover2']];
		$data[] = ['validationString' => 'sanitize', 'dataName' => 'annualTurnover3', 'dataValue' => $_POST['annualTurnover3']];
		$data[] = ['validationString' => 'sanitize', 'dataName' => 'perCentTurnover1', 'dataValue' => $_POST['perCentTurnover1']];
		$data[] = ['validationString' => 'sanitize', 'dataName' => 'perCentTurnover1', 'dataValue' => $_POST['perCentTurnover2']];
		$data[] = ['validationString' => 'sanitize', 'dataName' => 'perCentTurnover1', 'dataValue' => $_POST['perCentTurnover3']];
		$data[] = ['validationString' => 'sanitize', 'dataName' => 'profit1', 'dataValue' => $_POST['profit1']];
		$data[] = ['validationString' => 'sanitize', 'dataName' => 'profit2', 'dataValue' => $_POST['profit2']];
		$data[] = ['validationString' => 'sanitize', 'dataName' => 'profit3', 'dataValue' => $_POST['profit3']];
		$data[] = ['validationString' => 'sanitize', 'dataName' => 'totalAsset1', 'dataValue' => $_POST['totalAsset1']];
		$data[] = ['validationString' => 'sanitize', 'dataName' => 'totalAsset2', 'dataValue' => $_POST['totalAsset2']];
		$data[] = ['validationString' => 'sanitize', 'dataName' => 'totalAsset3', 'dataValue' => $_POST['totalAsset3']];
		$data[] = ['validationString' => 'sanitize', 'dataName' => 'currentAsset1', 'dataValue' => $_POST['currentAsset1']];
		$data[] = ['validationString' => 'sanitize', 'dataName' => 'currentAsset2', 'dataValue' => $_POST['currentAsset2']];
		$data[] = ['validationString' => 'sanitize', 'dataName' => 'currentAsset3', 'dataValue' => $_POST['currentAsset3']];
		$data[] = ['validationString' => 'sanitize', 'dataName' => 'totalLiabilty1', 'dataValue' => $_POST['totalLiabilty1']];
		$data[] = ['validationString' => 'sanitize', 'dataName' => 'totalLiabilty2', 'dataValue' => $_POST['totalLiabilty2']];
		$data[] = ['validationString' => 'sanitize', 'dataName' => 'totalLiabilty3', 'dataValue' => $_POST['totalLiabilty3']];
		$data[] = ['validationString' => 'sanitize', 'dataName' => 'totalNetAsset1', 'dataValue' => $_POST['totalNetAsset1']];
		$data[] = ['validationString' => 'sanitize', 'dataName' => 'totalNetAsset2', 'dataValue' => $_POST['totalNetAsset2']];
		$data[] = ['validationString' => 'sanitize', 'dataName' => 'totalNetAsset3', 'dataValue' => $_POST['totalNetAsset3']];
		$data[] = ['validationString' => 'sanitize', 'dataName' => 'shareCapital1', 'dataValue' => $_POST['shareCapital1']];
		$data[] = ['validationString' => 'sanitize', 'dataName' => 'shareCapital2', 'dataValue' => $_POST['shareCapital2']];
		$data[] = ['validationString' => 'sanitize', 'dataName' => 'shareCapital3', 'dataValue' => $_POST['shareCapital3']];
		$data[] = ['validationString' => 'sanitize', 'dataName' => 'comments1', 'dataValue' => $_POST['comments1']];
		// Second Table starts here
		$data[] = ['validationString' => 'sanitize', 'dataName' => 'bankerAddress2', 'dataValue' => $_POST['bankerAddress2']];
		$data[] = ['validationString' => 'sanitize', 'dataName' => 'auditorAddress2', 'dataValue' => $_POST['auditorAddress2']];
		if (isset($_POST['workmanInsurance'])) {
			$data[] = ['validationString' => 'in list', 'dataName' => 'workmanInsurance', 'dataValue' => $_POST['workmanInsurance'], 'dataList'=>['yes', 'no']];
			if($_POST['workmanInsurance'] == 'yes'){
				$data[] = ['validationString' => 'sanitize', 'dataName' => 'insuranceNumber', 'dataValue' => $_POST['insuranceNumber']];
				$data[] = ['validationString' => 'sanitize', 'dataName' => 'valueInsurance', 'dataValue' => $_POST['valueInsurance']];
			}
		}
		if(!empty($_POST['bankerName'])){
			$data[] = ['validationString' => 'non empty', 'dataName' => 'bankerName', 'dataValue' => $_POST['bankerName']];
		}else{
			$data[] = ['validationString' => 'sanitize', 'dataName' => 'bankerName', 'dataValue' => $_POST['bankerName']];
		}
		if(!empty($_POST['auditorName'])){
			$data[] = ['validationString' => 'non empty', 'dataName' => 'auditorName', 'dataValue' => $_POST['auditorName']];
		}else{
			$data[] = ['validationString' => 'sanitize', 'dataName' => 'auditorName', 'dataValue' => $_POST['auditorName']];
		}
		if(!empty($_POST['bankerAddress1'])){
			$data[] = ['validationString' => 'non empty', 'dataName' => 'bankerAddress1', 'dataValue' => $_POST['bankerAddress1']];
		}else{
			$data[] = ['validationString' => 'sanitize', 'dataName' => 'bankerAddress1', 'dataValue' => $_POST['bankerAddress1']];
		}
		if(!empty($_POST['auditorAddress1'])){
			$data[] = ['validationString' => 'non empty', 'dataName' => 'auditorAddress1', 'dataValue' => $_POST['auditorAddress1']];
		}else{
			$data[] = ['validationString' => 'sanitize', 'dataName' => 'auditorAddress1', 'dataValue' => $_POST['auditorAddress1']];
		}
		if(!empty($_POST['bankerTown'])){
			$data[] = ['validationString' => 'non empty', 'dataName' => 'bankerTown', 'dataValue' => $_POST['bankerTown']];
		}else{
			$data[] = ['validationString' => 'sanitize', 'dataName' => 'bankerTown', 'dataValue' => $_POST['bankerTown']];
		}
		if(!empty($_POST['auditorTown'])){
			$data[] = ['validationString' => 'non empty', 'dataName' => 'auditorTown', 'dataValue' => $_POST['auditorTown']];
		}else{
			$data[] = ['validationString' => 'sanitize', 'dataName' => 'auditorTown', 'dataValue' => $_POST['auditorTown']];
		}
		if(!empty($_POST['bankerState'])){
			$data[] = ['validationString' => 'non empty', 'dataName' => 'bankerState', 'dataValue' => $_POST['bankerState']];
		}else{
			$data[] = ['validationString' => 'sanitize', 'dataName' => 'bankerState', 'dataValue' => $_POST['bankerState']];
		}
		if(!empty($_POST['auditorState'])){
			$data[] = ['validationString' => 'non empty', 'dataName' => 'auditorState', 'dataValue' => $_POST['auditorState']];
		}else{
			$data[] = ['validationString' => 'sanitize', 'dataName' => 'auditorState', 'dataValue' => $_POST['auditorState']];
		}
		if(!empty($_POST['bankerCountry'])){
			$data[] = ['validationString' => 'non empty', 'dataName' => 'bankerCountry', 'dataValue' => $_POST['bankerCountry']];
		}else{
			$data[] = ['validationString' => 'sanitize', 'dataName' => 'bankerCountry', 'dataValue' => $_POST['bankerCountry']];
		}
		if(!empty($_POST['auditorCountry'])){
			$data[] = ['validationString' => 'non empty', 'dataName' => 'auditorCountry', 'dataValue' => $_POST['auditorCountry']];
		}else{
			$data[] = ['validationString' => 'sanitize', 'dataName' => 'auditorCountry', 'dataValue' => $_POST['auditorCountry']];
		}

		//Validate sent data
		$validationResult = $FormValidator->formValidation($data);
		if($validationResult['error']){
			if (isset($_POST['workmanInsurance'])) {
				if(!$validationResult['data']['workmanInsurance']) $dataError[] = "Choose an option for workman Insurance";
			}
			if(!empty($_POST['bankerName'])){
				if(!$validationResult['data']['bankerName']) $dataError[] = "Name is required";
			}
			if(!empty($_POST['auditorName'])){
				if(!$validationResult['data']['auditorName']) $dataError[] = "Name is required";
			}
			if(!empty($_POST['bankerAddress1'])){
				if(!$validationResult['data']['bankerAddress1']) $dataError[] = "Address is required";
			}
			if(!empty($_POST['auditorAddress1'])){
				if(!$validationResult['data']['auditorAddress1']) $dataError[] = "Address is required";
			}
			if(!empty($_POST['bankerTown'])){
				if(!$validationResult['data']['bankerTown']) $dataError[] = "Town is required";
			}
			if(!empty($_POST['auditorTown'])){
				if(!$validationResult['data']['auditorTown']) $dataError[] = "Town is required";
			}
			if(!empty($_POST['bankerState'])){
				if(!$validationResult['data']['bankerState']) $dataError[] = "State is required";
			}
			if(!empty($_POST['auditorState'])){
				if(!$validationResult['data']['auditorState']) $dataError[] = "State is required";
			}
			if(!empty($_POST['bankerCountry'])){
				if(!$validationResult['data']['bankerCountry']) $dataError[] = "Country is required";
			}
			if(!empty($_POST['auditorCountry'])){
				if(!$validationResult['data']['auditorCountry']) $dataError[] = "Country is required";
			}
			
			$_SESSION['dataError'] = $dataError;
	  	header("Location: .");
	  	exit();
  	}
		
		$result = $validationResult['data'];
		
		//Perform page action
		$DbHandle = new DBHandler($PDO, "login", __FILE__);
		$User = new Users($DbHandle);
		$vendorDetails = $User->userDetails($_SESSION['nipexLogin']['email']);
		$DbHandle->setTable("que_finance");

		$year1 = json_encode(['Accounting Year'=>$_POST['accountingYear1'], 'Reporting Currency'=>$_POST['reportingCurrency1'], 'Year Ending Month'=>$_POST['yearEnding1'], 'Audited Accounts'=>$_POST['auditedAccount1'], 'Annual Turnover'=>$_POST['annualTurnover1'], 'percent Turnover'=>$_POST['perCentTurnover1'], 'Profit before tax'=>$_POST['profit1'], 'Total Assets'=>$_POST['totalAsset1'], 'Current Assets'=>$_POST['currentAsset1'], 'Total Short Term liabilities'=>$_POST['totalLiabilty1'], 'Total Net Assets'=>$_POST['totalNetAsset1'], 'Issued Share Capital'=>$_POST['shareCapital1']]);
		$year2 = json_encode(['Accounting Year'=>$_POST['accountingYear2'], 'Reporting Currency'=>$_POST['reportingCurrency2'], 'Year Ending Month'=>$_POST['yearEnding2'], 'Audited Accounts'=>$_POST['auditedAccount2'], 'Annual Turnover'=>$_POST['annualTurnover2'], 'percent Turnover'=>$_POST['perCentTurnover2'], 'Profit before tax'=>$_POST['profit2'], 'Total Assets'=>$_POST['totalAsset2'], 'Current Assets'=>$_POST['currentAsset2'], 'Total Short Term liabilities'=>$_POST['totalLiabilty2'], 'Total Net Assets'=>$_POST['totalNetAsset2'], 'Issued Share Capital'=>$_POST['shareCapital2']]);
		$year3 = json_encode(['Accounting Year'=>$_POST['accountingYear3'], 'Reporting Currency'=>$_POST['reportingCurrency3'], 'Year Ending Month'=>$_POST['yearEnding3'], 'Audited Accounts'=>$_POST['auditedAccount3'], 'Annual Turnover'=>$_POST['annualTurnover3'], 'percent Turnover'=>$_POST['perCentTurnover3'], 'Profit before tax'=>$_POST['profit3'], 'Total Assets'=>$_POST['totalAsset3'], 'Current Assets'=>$_POST['currentAsset3'], 'Total Short Term liabilities'=>$_POST['totalLiabilty3'], 'Total Net Assets'=>$_POST['totalNetAsset3'], 'Issued Share Capital'=>$_POST['shareCapital3']]);
		$banker = json_encode(['Name'=>$_POST['bankerName'],'Address Line 1'=>$_POST['bankerAddress1'],'Address Line 2'=>$_POST['bankerAddress2'],'Town'=>$_POST['bankerTown'], 'State'=>$_POST['bankerState'], 'Post Code'=>$_POST['bankerPC'], 'Country'=>$_POST['bankerCountry']]);
		$auditor = json_encode(['Name'=>$_POST['auditorName'],'Address Line 1'=>$_POST['auditorAddress1'],'Address Line 2'=>$_POST['auditorAddress2'],'Town'=>$_POST['auditorTown'], 'State'=>$_POST['auditorState'], 'Post Code'=>$_POST['auditorPC'], 'Country'=>$_POST['auditorCountry']]);
		
		if (isset($_POST['workmanInsurance'])) {
			$data = ['year_one'=>$year1,'year_two'=>$year2,'year_three'=>$year3,'nsitf'=>$result['workmanInsurance'], 'commments'=>$result['comments1'], 'banker'=>$banker, 'auditor'=>$auditor];
			if($_POST['workmanInsurance'] == 'yes'){
				$data['nsitf_certificate_no'] = $result['insuranceNumber']; 
				$data['value_of_insurance'] = $result['valueInsurance'];
			}
		}

		if ($nigContent = $DbHandle->iRetrieveData(__LINE__, ["vendor_id"=>$vendorDetails["vendor_id"]])) {
			$criteria = ['vendor_id'=>$vendorDetails["vendor_id"]];
			$DbHandle->updateData(__LINE__, $data, $criteria);
			$response = "updated";
		}else{
			$data["vendor_id"] = $vendorDetails["vendor_id"];
			$data["date_created"] = "NOW()";
			$DbHandle->createData(__LINE__, $data);
			$response = "created";
		}

		//Generate response to be sent back
			$_SESSION['response'] = "Finance has been successfully $response";
			header("Location: .");
		  exit();
	}
	else {
		$_SESSION['spoofing']="CSRF suspected in  ". __FILE__;
		$_SESSION['dataError']=TRUE;
		header("Location: .");
		exit();
	}