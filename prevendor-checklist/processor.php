<?php
	//Get required files
	require_once '../db-config.php'; 
	
	//Turn off magic quotes
	Functions::magicQuotesOff();
	
	//Check if the access to this script is coming from login page
  if(isset($_POST['token']) && $_POST['token']==$_SESSION['token']){
  	unset($_SESSION['token']);
		//Get validator to validate data sent to this script
		$FormValidator = new Validator();

		if(!isset($_POST['cacNo'])) $_POST['cacNo'] = 'no';
		if(!isset($_POST['c02'])) $_POST['c02'] = 'no';
		if(!isset($_POST['c07'])) $_POST['c07'] = 'no';
		if(!isset($_POST['taxCertificate'])) $_POST['taxCertificate'] = 'no';
		if(!isset($_POST['vatCertificate'])) $_POST['vatCertificate'] = 'no';
		if(!isset($_POST['bankReference'])) $_POST['bankReference'] = 'no';
		if(!isset($_POST['dpr'])) $_POST['dprNo'] = 'no';
		if(!isset($_POST['itf'])) $_POST['itfNo'] = 'no';
		if(!isset($_POST['pencom'])) $_POST['nsitfNo'] = 'no';
		
		//Prepare form data for Validator
		$data[] = ['validationString'=>'in list', 'dataName'=>'cacNo', 'dataValue'=>$_POST['cacNo'], 'dataList'=>['no', 'yes']];
		$data[] = ['validationString'=>'in list', 'dataName'=>'c02', 'dataValue'=>$_POST['c02'], 'dataList'=>['no', 'yes']];
		$data[] = ['validationString'=>'in list', 'dataName'=>'c07', 'dataValue'=>$_POST['c07'], 'dataList'=>['no', 'yes']];		
		$data[] = ['validationString'=>'in list', 'dataName'=>'taxCertificate', 'dataValue'=>$_POST['taxCertificate'], 'dataList'=>['no', 'yes']];		
		$data[] = ['validationString'=>'in list', 'dataName'=>'vatCertificate', 'dataValue'=>$_POST['vatCertificate'], 'dataList'=>['no', 'yes']];
		$data[] = ['validationString'=>'in list', 'dataName'=>'bankReference', 'dataValue'=>$_POST['bankReference'], 'dataList'=>['no', 'yes']];
		$data[] = ['validationString'=>'in list', 'dataName'=>'dpr', 'dataValue'=>$_POST['dpr'], 'dataList'=>['no', 'yes']];		
		$data[] = ['validationString'=>'in list', 'dataName'=>'itf', 'dataValue'=>$_POST['itf'], 'dataList'=>['no', 'yes']];		
		$data[] = ['validationString'=>'in list', 'dataName'=>'pencom', 'dataValue'=>$_POST['pencom'], 'dataList'=>['no', 'yes']];
		$data[] = ['validationString'=>'email', 'dataName'=>'email', 'dataValue'=>$_POST['email']];
		
		//Validate sent data
		$validationResult = $FormValidator->formValidation($data);
		if($validationResult['error']){
			if(!$validationResult['data']['cacNo']) $dataError[] = "Invalid CAC No";
			if(!$validationResult['data']['c02']) $dataError[] = "Invalid C02 No";
			if(!$validationResult['data']['c07']) $dataError[] = "Invalid C07";
			if(!$validationResult['data']['taxCertificate']) $dataError[] = "invalid Tax Certificate";
			if(!$validationResult['data']['vatCertificate']) $dataError[] = "Invalid VAT Certificate";
			if(!$validationResult['data']['bankReference']) $dataError[] = "Invalid Bank Reference";
			if(!$validationResult['data']['dpr']) $dataError[] = "Invalid DPR";
			if(!$validationResult['data']['itf']) $dataError[] = "invalid ITF";
			if(!$validationResult['data']['pencom']) $dataError[] = "Invalid PENCOM";
			if(!$validationResult['data']['email']) $dataError[] = "Invalid Email";
			$_SESSION['dataError'] =  $dataError;
	  	header("Location: ".URL."prevendor-checklist?token={$_POST['getToken']}&email={$_POST['email']}");
	  	exit();
  	}
		$result = $validationResult['data'];
		$document = [
			'CAC'=>$result['cacNo'], 
			'C02'=>$result['c02'], 
			'C07'=>$result['c07'], 
			'Tax Certificate'=>$result['taxCertificate'], 
			'VAT Certificate'=>$result['vatCertificate'],
			'Bank Reference'=>$result['bankReference'],
			'DPR'=>$result['dpr'], 
			'ITF'=>$result['itf'], 
			'PENCOM'=>$result['pencom']
		];
		$jDocument = json_encode($document);
		
		$DbHandle = new DBHandler($PDO, "login", __FILE__);
		$preVendor = $DbHandle->iRetrieveData(__LINE__, ['email'=>$result['email']]);
		$DbHandle->setTable('pre_vendor');
		$DbHandle->updateData(__LINE__, ['document'=>$jDocument], ['login_id'=>$preVendor[0]['id']]);
		
		$completeDocument = true;
		foreach ($document as $aDocument) {
			if($aDocument == 'no') $completeDocument = false;
		}
		if($completeDocument){
			$DbHandle->setTable('fee');
			$feeInfo = $DbHandle->iRetrieveData(__LINE__, ['fee'=>'subscription']);
			$message = "
				You can now proceed and pay the Vendor Registration Fee.<br/>
				<strong>OFFLINE PAYMENT</strong><br/>
				<strong>
					Please note that when making any bank payment to NipeX, the name of the Depositor 
					should be the Company name and NOT personal name.
				</strong>
				<ul>
					<li>Visit <a style='text-decoration:underline;' href='https://remita.net' target='_blank' style='text-decoration:un'>Remita</a> click on Pay FGN and 
					State TSA and select Federal Government of Nigeria from the options</li>
					<li>On NAME OF MDA: type National Petroleum Investment Management Services.</li>
					<li>On NAME OF SERVICES/PURPOSE: click on the box and a menu will drop click on 
					National Petroleum Investment Management Services Fees.</li>
					<li>On DESCRIPTION: type the appropriate fee you are paying for: NJQS Registration 
					fee N".number_format($feeInfo[0]['amount'],2)."</li>
					<li>Then proceed to fill in your company name, email and telephone number</li>
					<li>Key in the characters into the box (usually four) and click proceed to payment</li>
					<li>When this is done, another page will drop with your RRR code</li>
					<li>You will then print out the page and take to the bank to make your payment</li>
				</ul><br/>
				<strong>ONLINE PAYMENT</strong><br/>
				Pay through <a style='text-decoration:underline;' href='https://login.remita.net/remita/external/OAGFCRF/collector/payments.reg' target='_blank'>Remita</a>
				<br/><br/>
				<strong>AFTER PAYMENT PLEASE LOGIN AND ENTER THE PAYMENT DETAILS</strong>
				";
			$_SESSION['response'] = ['status'=>'success', 'message'=>$message];
			//Send mail
			$message = Functions::emailHead(URL);
			$message .= "
				<p style='margin-bottom:20px;'>Good Day Sir/Madam</p>
				<p style='margin-bottom:8px;'>
					Congratulation you indicate that you have all the document for now to continue the 
					process of Vendor Registeration. You can now proceed and pay the Vendor Registration
					Fee.
				</p>
				<strong>OFFLINE PAYMENT</strong><br/>
				<strong>
					Please note that when making any bank payment to NipeX, the name of the Depositor 
					should be the Company name and NOT personal name.
				</strong>
				<ul style='margin-bottom:8px;'>
					<li>Visit <a style='color:#fff; text-decoration:underline;' href='https://remita.net' target='_blank'>Remita</a> click on Pay FGN and 
					State TSA and select Federal Government of Nigeria from the options</li>
					<li>On NAME OF MDA: type National Petroleum Investment Management Services.</li>
					<li>On NAME OF SERVICES/PURPOSE: click on the box and a menu will drop click on 
					National Petroleum Investment Management Services Fees.</li>
					<li>On DESCRIPTION: type the appropriate fee you are paying for: NJQS Registration 
					fee N".number_format($feeInfo[0]['amount'],2)."</li>
					<li>Then proceed to fill in your company name, email and telephone number</li>
					<li>Key in the characters into the box (usually four) and click proceed to payment</li>
					<li>When this is done, another page will drop with your RRR code</li>
					<li>You will then print out the page and take to the bank to make your payment</li>
				</ul>
				<strong>ONLINE PAYMENT</strong><br/>
				Pay through <a style='color:#fff; text-decoration:underline;' href='https://login.remita.net/remita/external/OAGFCRF/collector/payments.reg' target='_blank'>Remita</a>Remita</a>
				<br/><br/>
				<p style='margin-bottom:8px;'>
					<strong>AFTER PAYMENT PLEASE <a href='".URL."' style='color:#fff; text-decoration:underline;'>LOGIN</a> AND ENTER THE PAYMENT DETAILS</strong>
				</p>
				<p style='margin-bottom:8px;'>
					<span style='font-weight:bold;'>NB</span><br/>
				   If you did not register on ".URL." please ignore this mail.
				   Please do not reply to this mail as it is sent from an unmonitored address. You 
				   can contact us via ".CONTACTEMAIL."
				</p>
			";
		}
		else {
			$message = "We are sorry you cannot continue the Vendor Registration processs
			as you do not have all the required document";
			$_SESSION['response'] = ['status'=>'failed', 'message'=>$message];
			//Send mail
			$message = Functions::emailHead(URL);
			$message .= "
				<p style='margin-bottom:20px;'>Good Day Sir/Madam</p>
				<p style='margin-bottom:8px;'>
					We are sorry to inform you that you cannot continue the Vendor Registration processs
					for now as you do not have all the required document. Anytime you have the required
					document just <a href='".URL."' style='color:#fff; text-decoration:underline;'>login</a> 
					and indicate that. 
				</p>
				<p style='margin-bottom:8px;'>
					<span style='font-weight:bold;'>NB</span><br/>
				   If you did not register on ".URL." please ignore this mail.
				   Please do not reply to this mail as it is sent from an unmonitored address. You 
				   can contact us via ".CONTACTEMAIL."
				</p>
			";
		}
		$message .= Functions::footerHead(URL);
		if(!DEVELOPMENT){
	  	$subject = "Mandatory Documents Checklist";
	  	$headers  = 'MIME-Version: 1.0' . "\r\n";
	  	$headers .= 'Content-type: text/html; charset=iso-8859-1' . "\r\n";
	  	$headers .= "From: ".SITENAME." <noreply@".URLEMAIL.">" . "\r\n";
			mail($result['email'], $subject, $message, $headers);
		}
		header("Location: ".URL."prevendor-checklist");
	  exit();
	}
	else {
		$_SESSION['spoofing']="CSRF suspected in  ". __FILE__;
		$_SESSION['dataError']=TRUE;
		header("Location: .");
		exit();
	}