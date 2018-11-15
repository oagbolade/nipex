<?php
	//Get required files
	require_once '../db-config.php';
	
	$_SESSION['token'] = md5(TOKEN);
	$Tag = new Tag(URL);
	
	$head = $Tag->createHead("NipeX Joint Qualification System (NJQS) | Payment Update", "login al-login");
	$footer = $Tag->createFooter();
	
	//Responses initialization
	$responseMsg = "";
	$constant = [
		'url' => URL, 'urlemail' => URLEMAIL, 'contactemail' => CONTACTEMAIL, 
		'development' => DEVELOPMENT, 'directory' => ROOT.'error', 'sitename' => SITENAME];
	
	//Token processing for account activation
	if(isset($_GET['token']) && isset($_GET['email'])){
		$FormValidator = new Validator();
		$token = urldecode($FormValidator->getSanitizeData($_GET['token']));
		$email = urldecode($FormValidator->getSanitizeData($_GET['email']));
		$DbHandle = new DBHandler($PDO, "login", __FILE__);
		$User = new Users($DbHandle);
		$responseMsg = generateForm($_SESSION['token'], $email, $token, $PDO);
	}
	
	$style = "";
	//Response after data processing
	if(isset($_SESSION['response'])){
		$style = "
			<style>
				.login_content {
					text-align:left;
				}
			</style>
		";
		$response = $_SESSION['response'];
		$content = $response['message'];
		if($response['status'] == 'failed'){
			$boxColor = 'danger';
		}
		else {
			$boxColor = 'info';
		}
		$responseMsg = $Tag->createAlert("", $content, $boxColor, false);
		unset($_SESSION['response']);
	}

	//Error in data sent for processing
	if(isset($_SESSION['dataError'])){
		if(!isset($_SESSION['spoofing'])){
			$content = "<ul>";
			foreach ($_SESSION['dataError'] as $aMessage) {
				$content .= "<li class='text-left'>$aMessage</li>";	
			}
			$content .= "</ul>";
			$responseMsg = $Tag->createAlert("", $content, 'danger', false);
			if(isset($_GET['token']) && isset($_GET['email'])){
				$FormValidator = new Validator();
				$token = urldecode($FormValidator->getSanitizeData($_GET['token']));
				$email = urldecode($FormValidator->getSanitizeData($_GET['email']));
				$responseMsg .= generateForm($_SESSION['token'], $email, $token, $PDO);
			}
		}
		else {
			$functions = new Functions();
			$ErrorAlerter = new ErrorAlert($_SESSION['spoofing'], $functions, $constant);
			$ErrorAlerter->sendAlerts();
			$responseMsg = $Tag->createAlert("System Error", "Ouch we are sorry something went wrong, we think your internet connection may be slow", 'danger', true);
			unset($_SESSION['spoofing']);
		}
		unset($_SESSION['dataError']);
	}
	
	$pageHeader = "
		<div class='row'>
			<div class='col-md-6 text-left'>
				<img class='al-login-logo' src='". URL ."images/nipex-logo.png'/>
			</div>
			<div class='col-md-6 text-right'>
				<img class='al-login-logo' src='". URL ."images/nnpc-logo.png'/>
			</div>
			<div class='col-md-12 text-center'>
				<h3>".SITENAME."</h3>
			</div>
    </div>
	";
	
	$pageFooter = "";
	
	function generateForm($token, $email, $getToken, $pdo){
		$DbHandle = new DBHandler($pdo, "login", __FILE__);
		$User = new Users($DbHandle);
		$userDetails = $User->userDetails($email);
		$id = $User->getIDFrmEmailOrUsername($email);
		
		$DbHandle->setTable('fee');
		$feeInfo = $DbHandle->iRetrieveData(__LINE__, ['fee'=>'subscription']);
		$details['Amount'] = $feeInfo[0]['amount'];
		$details['RRR'] = ""; $details['Bank Name'] = "";
		$details['Account Name'] = ""; $details['Account No'] = ""; $details['Status'] = "";
		$disabled = "";

		$DbHandle->setTable('payment');
		if($payment = $DbHandle->iRetrieveData(__LINE__, ['login_id'=>$id, 'item'=>'subscription'])){
			$details = json_decode($payment[0]['other'],true);
			$disabled = "disabled";
		}
		
		$form = "
			<style>
				.login_content form input[type='text'], 
				.login_content form input[type='number']{
					margin: 0 0 0px;
				}
			</style>
			<div class='row'>
				<div class='col-md-4 text-right'>COMPANY</div>
				<div class='col-md-8 text-left'><strong>{$userDetails['company_name']}</strong></div>
			</div>
			<div class='row'>
				<div class='col-md-4 text-right'>CAC No</div>
				<div class='col-md-8 text-left'><strong>{$userDetails['cac_no']}</strong></div>
			</div>
			<div class='row'>
				<div class='col-md-4 text-right'>COMPANY EMAIL</div>
				<div class='col-md-8 text-left'><strong>{$userDetails['email']}</strong></div>
			</div>
			<div class='row'>
				<div class='col-md-4 text-right'>COMPANY PHONE</div>
				<div class='col-md-8 text-left'><strong>{$userDetails['phone_no']}</strong></div>
			</div>
			<form action='".htmlspecialchars('processor.php')."' method='post'>
        	<input type='hidden' name='token' value='$token' />
        	<input type='hidden' name='email' value='$email' />
        	<input type='hidden' name='getToken' value='$getToken' />
          <div class='form-group row'>
            <label class='control-label col-md-5 col-sm-6 col-xs-12 text-left' for='amount'>
            	Amount *
            </label>
            <div class='col-md-7 col-sm-6 col-xs-12 text-left'>
              <div class=''>
                <label>
                  <input disabled type='number' name='amount' value='{$details['Amount']}' class='form-control' required />
                </label>
              </div>
            </div>
          </div>
          
          <div class='form-group row'>
            <label class='control-label col-md-5 col-sm-6 col-xs-12 text-left' for='remitaRef'>
            	Remita RRR *
            </label>
            <div class='col-md-7 col-sm-6 col-xs-12 text-left'>
              <div class=''>
                <label>
                  <input type='text' name='remitaRef' value='{$details['RRR']}' class='form-control' required />
                </label>
              </div>
            </div>
          </div>
          
          <div class='form-group row'>
            <label class='control-label col-md-5 col-sm-6 col-xs-12 text-left' for='bankName'>
            	Bank Name *
            </label>
            <div class='col-md-7 col-sm-6 col-xs-12 text-left'>
              <div class=''>
                <label>
                  <input type='text' name='bankName' value='{$details['Bank Name']}' class='form-control' required />
                </label>
              </div>
            </div>
          </div>
					
					<div class='form-group row row'>
            <label class='control-label col-md-5 col-sm-6 col-xs-12 text-left' for='accountName'>
            	Account Name *
            </label>
            <div class='col-md-7 col-sm-6 col-xs-12 text-left'>
              <div class=''>
                <label>
                  <input type='text' name='accountName' value='{$details['Account Name']}' class='form-control' required />
                </label>
              </div>
            </div>
          </div>
          
          <div class='form-group row row'>
            <label class='control-label col-md-5 col-sm-6 col-xs-12 text-left' for='accountNo'>
            	Account No *
            </label>
            <div class='col-md-7 col-sm-6 col-xs-12 text-left'>
              <div class=''>
                <label>
                  <input type='text' name='accountNo' value='{$details['Account No']}' class='form-control' required />
                </label>
              </div>
            </div>
          </div>
					
					<div class='form-group row row'>
            <label class='control-label col-md-5 col-sm-6 col-xs-12 text-left' for='accountNo'>
            	Payment Status
            </label>
            <div class='col-md-7 col-sm-6 col-xs-12 text-left'>
              <div class=''>
                <label>
                  <strong>".strtoupper($details['Status'])."</strong>
                </label>
              </div>
            </div>
          </div>
          
          <div>
            <button class='btn btn-default submit' type='submit' $disabled>Save</button>
          </div>
				</form>
		";
		return $form;
	}