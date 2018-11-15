<?php
	//Get required files
	require_once '../db-config.php'; 
	
	//Turn off magic quotes
	Functions::magicQuotesOff();
	
	$constant = [
		'url' => URL, 'urlemail' => URLEMAIL, 'contactemail' => CONTACTEMAIL, 'salt' => SALT, 
		'development' => DEVELOPMENT, 'directory' => ROOT.'error', 'sitename' => SITENAME];
	
	$DbHandle = new DBHandler($PDO, "login", __FILE__);
	$User = new Users($DbHandle); 
	$Authentication = new Authentication($DbHandle);
	$Authentication->setConstants($constant);
	$Authentication->keyToPage();
	$userDetails = $User->userDetails($_SESSION['nipexLogin']['email']);
	$Authentication->pageAccessor(['IT'], $userDetails['authority']);
	
	//Check if the access to this script is coming from its index's page
  if(isset($_POST['token']) && $_POST['token']==$_SESSION['token']){
  	unset($_SESSION['token']);
				
		//Get validator to validate data sent to this script
		$FormValidator = new Validator();
		
		$DbHandle->setTable('payment');
		$permittedIDs = [];
		if($paymentCollection = $DbHandle->iRetrieveData(__LINE__, ['vendor'=>'no', 'approver'=>'IS NOT NULL'])){
			foreach ($paymentCollection as $aPayment) {
				$permittedIDs[] = $aPayment['id'];
			}
		}
		
		//Prepare form data for Validator
		$data[] = ['validationString' => 'non empty', 'dataName' => 'username', 'dataValue' => $_POST['username']];
		$data[] = ['validationString'=>'password rule', 'dataName'=>'password', 'dataValue'=>$_POST['password']];
		$data[] = ['validationString'=>'in list', 'dataName'=>'id', 'dataValue'=>$_POST['vendor'], 'dataList'=>$permittedIDs];
		$data[] = ['validationString'=>'non empty', 'dataName'=>'validityPeriod', 'dataValue'=>$_POST['validityPeriod']];
		
		//Validate sent data
		$validationResult = $FormValidator->formValidation($data);
		if($validationResult['error']){
			if(!$validationResult['data']['username']) $dataError[] = "Username is compulsory";
			if(!$validationResult['data']['password']) $dataError[] = "Invalid password";
			if(!$validationResult['data']['id']) $dataError[] = "Invalid vendor ID";
			if(!$validationResult['data']['validityPeriod']) $dataError[] = "Validity Period is compulsory";
			$_SESSION['dataError'] = $dataError;
	  	header("Location: ".URL."vendor-creation?id={$_POST['vendor']}");
	  	exit();
  	}
		$result = $validationResult['data'];
		
		//Get payment details and make a vendor in payment table
		$payer = $DbHandle->iRetrieveData(__LINE__, ['id'=>$result['id']]);
		$User = new Users($DbHandle);
		$payerDetails = $User->userDetails($User->getEmailFrmID($payer[0]['login_id']));
		$DbHandle->setTable('payment');
		$DbHandle->updateData(__LINE__, ['vendor'=>'yes'], ['id'=>$result['id']]);
		
		//Change details in login table and make a vendor
		$DbHandle->setTable('login');
		$data = [
			'username'=>$result['username'], 
			'password'=>crypt($result['password'], SALT), 
			'default_password'=>'yes', 
			'authority'=>'vendor'];
		$DbHandle->updateData(__LINE__, $data, ['id'=>$payer[0]['login_id']]);
		
		//Add details to vendor table
		$DbHandle->setTable('vendor');
		$vendorData = [
			'login_id'=>$payer[0]['login_id'], 
			'company_name'=>$payerDetails['company_name'], 
			'vendor_status'=>'registered',
			'expiration_date'=>$result['validityPeriod']];
		$DbHandle->createData(__LINE__, $vendorData);
		
		//mail new vendor
		$message = Functions::emailHead(URL);
		$message .= "
			<p style='margin-bottom:20px;'>Good Day Sir/Madam</p>
			<p style='margin-bottom:8px;'>
				Your payment for National Petroleum Investment Management Services Fee on Remita has been
				confirmed on our system. You can now login as a REGISTERED VENDOR on NipeX Joint
				Qualification System and continue the process of becoming a <strong>PRE QUALIFIED VENDOR</strong>
				<br/>
			</p>
			<p style='margin-bottom:8px;'>
				Your login details are below:
				URL: ".URL."login<br/>
				Username: {$result['username']}<br/>
				Password: {$result['password']} <small><em>(this must be changed on first successful login)</small></em><br/>
			</p>
			<p style='margin-bottom:8px;'>
				<span style='font-weight:bold;'>NB</span><br/>
			   If you did not register for an account at ".URL." please ignore this mail.
			   Please do not reply to this mail as it is sent from an unmonitored address. You 
			   can contact us via ".CONTACTEMAIL."
			</p>
		";
		$message .= Functions::footerHead(URL);
		if(!DEVELOPMENT){
	  	$subject = "Vendor Status Alert: REGISTERED";
	  	$headers  = 'MIME-Version: 1.0' . "\r\n";
	  	$headers .= 'Content-type: text/html; charset=iso-8859-1' . "\r\n";
	  	$headers .= "From: ".SITENAME." <noreply@".URLEMAIL.">" . "\r\n";
			mail($data['email'], $subject, $message, $headers);
		}
		
		$_SESSION['response'] = "You have successfully created a new VENDOR on the system";
		header("Location: ".URL."vendor-creation-list");
	  exit();
	}
	else {
		$_SESSION['spoofing']="CSRF suspected in  ". __FILE__;
		$_SESSION['dataError']=TRUE;
		header("Location: .");
		exit();
	}