<?php
	//Get required files
	require_once '../db-config.php';
	
	$_SESSION['token'] = md5(TOKEN);
	$Tag = new Tag(URL);
	
	$head = $Tag->createHead("NipeX Joint Qualification System (NJQS) | Login", "login al-login", ['css'=>['vendors/switchery/switchery.min.css']]);
	$footer = $Tag->createFooter(['vendors/switchery/switchery.min.js', 'js/switch-setting.js']);
	
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
		$responseMsg = $Tag->createAlert("", "Your company email validation failed", 'danger', false);
		if($DbHandle->iRetrieveData(__LINE__, ['email'=>$email, 'token'=>$token])){
			$DbHandle->updateData(__LINE__, ['status'=>'active'], ['email'=>$email]);
			$msg = "
				Your company email validation is successful
				<br/>
				Please ensure you have ALL the under listed MANDATORY documents before making payment.
				<strong>Payment is NON-REFUNDABLE</strong>
			";
			$responseMsg = $Tag->createAlert("", $msg, 'info', false);
			$responseMsg .= generateForm($_SESSION['token'], $email, $token);
		}
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
				$responseMsg .= generateForm($_SESSION['token'], $email, $token);
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
	
	function generateForm($token, $email, $getToken){
		$form = "
			<style>
				form .row{
					margin-bottom: 2px;
				}
			</style>
			<form action='".htmlspecialchars('processor.php')."' method='post'>
        	<input type='hidden' name='token' value='$token' />
        	<input type='hidden' name='email' value='$email' />
        	<input type='hidden' name='getToken' value='$getToken' />
          <div class='form-group row'>
            <label class='control-label col-md-5 col-sm-6 col-xs-12 text-left' for='cacNo'>
            	Have CAC No
            </label>
            <div class='col-md-7 col-sm-6 col-xs-12 text-left'>
              <div class=''>
                <label>
                  <input type='checkbox' name='cacNo' value='yes' class='js-switch' />
                </label>
              </div>
            </div>
          </div>
          <div class='form-group row'>
            <label class='control-label col-md-5 col-sm-6 col-xs-12 text-left' for='cacNo'>
            	Have Form C02
            </label>
            <div class='col-md-7 col-sm-6 col-xs-12 text-left'>
              <div class=''>
                <label>
                  <input type='checkbox' name='c02' value='yes' class='js-switch' />
                </label>
              </div>
            </div>
          </div>
          <div class='form-group row'>
            <label class='control-label col-md-5 col-sm-6 col-xs-12 text-left' for='cacNo'>
            	Have Form C07
            </label>
            <div class='col-md-7 col-sm-6 col-xs-12 text-left'>
              <div class=''>
                <label>
                  <input type='checkbox' name='c07' value='yes' class='js-switch' />
                </label>
              </div>
            </div>
          </div>
					
					<div class='form-group row row'>
            <label class='control-label col-md-5 col-sm-6 col-xs-12 text-left' for='cacNo'>
            	Have Tax Certificate
            </label>
            <div class='col-md-7 col-sm-6 col-xs-12 text-left'>
              <div class=''>
                <label>
                  <input type='checkbox' name='taxCertificate' value='yes' class='js-switch' />
                </label>
              </div>
            </div>
          </div>
          <div class='form-group row row'>
            <label class='control-label col-md-5 col-sm-6 col-xs-12 text-left' for='cacNo'>
            	Have VAT Certificate
            </label>
            <div class='col-md-7 col-sm-6 col-xs-12 text-left'>
              <div class=''>
                <label>
                  <input type='checkbox' name='vatCertificate' value='yes' class='js-switch' />
                </label>
              </div>
            </div>
          </div>
          <div class='form-group row row'>
            <label class='control-label col-md-5 col-sm-6 col-xs-12 text-left' for='cacNo'>
            	Have Bank Reference
            </label>
            <div class='col-md-7 col-sm-6 col-xs-12 text-left'>
              <div class=''>
                <label>
                  <input type='checkbox' name='bankReference' value='yes' class='js-switch' />
                </label>
              </div>
            </div>
          </div>
					
          <div class='form-group row'>
            <label class='control-label col-md-5 col-sm-6 col-xs-12 text-left' for='dprNo'>
            	Have DPR
            </label>
            <div class='col-md-7 col-sm-6 col-xs-12 text-left'>
              <div class=''>
                <label>
                  <input type='checkbox' name='dpr' value='yes' class='js-switch' />
                </label>
              </div>              
            </div>
          </div>
          <div class='form-group row'>
            <label class='control-label col-md-5 col-sm-6 col-xs-12 text-left' for='itfNo'>
            	Have ITF or Wavier
            </label>
            <div class='col-md-7 col-sm-6 col-xs-12 text-left'>
              <div class=''>
                <label>
                  <input type='checkbox' name='itf' value='yes' class='js-switch' />
                </label>
              </div>
            </div>
          </div>
          <div class='form-group row'>
            <label class='control-label col-md-5 col-sm-6 col-xs-12 text-left' for='nsitfNo'>
            	Have PENCOM or Wavier
            </label>
            <div class='col-md-7 col-sm-6 col-xs-12 text-left'>
              <div class=''>
                <label>
                  <input type='checkbox' name='pencom' value='yes' class='js-switch' />
                </label>
              </div>
            </div>
          </div>
          <div>
            <button class='btn btn-default submit' type='submit'>Submit</button>
          </div>
				</form>
		";
		return $form;
	}