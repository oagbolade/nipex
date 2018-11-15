<?php
	//Get required files
	require_once '../db-config.php';
	
	$_SESSION['token'] = md5(TOKEN);
	$Tag = new Tag(URL);
	
	$head = $Tag->createHead(SITENAME." | Change Password", "login al-login", ['css' => ['vendors/animate.css/animate.min.css']]);
	$footer = $Tag->createFooter();
	
	//Initialization
	$form = "";
	$noInitilization = false;
	$response = $Tag->createAlert("", "Password reset token is invalid", 'danger', false);
	$constant = [
		'url' => URL, 'urlemail' => URLEMAIL, 'contactemail' => CONTACTEMAIL, 
		'development' => DEVELOPMENT, 'directory' => ROOT.'error', 'sitename' => SITENAME];
	
	//Error in data sent for processing
	if(isset($_SESSION['dataError'])){
		if(!isset($_SESSION['spoofing'])){
			$content = "<ul>";
			foreach ($_SESSION['dataError'] as $aMessage) {
				$content .= "<li class='text-left'>$aMessage</li>";	
			}
			$content .= "</ul>";
			$response = $Tag->createAlert("", $content, 'danger', false);
			$noInitilization = true;
		}
		else {
			$functions = new Functions();
			$ErrorAlerter = new ErrorAlert($_SESSION['spoofing'], $functions, $constant);
			$ErrorAlerter->sendAlerts();
			$loginMsg = $Tag->createAlert("System Error", "Ouch we are sorry something went wrong, we think your internet connection may be slow", 'danger', true);
			unset($_SESSION['spoofing']);
		}
		unset($_SESSION['dataError']);
	}
	
	//Reset code validation
	if(isset($_GET['token']) && isset($_GET['email'])){
		$FormValidator = new Validator();
		$token = urldecode($FormValidator->getSanitizeData($_GET['token']));
		$email = urldecode($FormValidator->getSanitizeData($_GET['email']));
		$DbHandle = new DBHandler($PDO, "login", __FILE__);
		$User = new Users($DbHandle);
		if($userDetails = $User->userDetails($email, "logger")){
			if($userDetails['token'] != $token){
				$response = $Tag->createAlert("", "Password reset token is invalid", 'danger', false);
			} 
			else {
				if(!$noInitilization) $response = "";
				$form = generateForm($email, $token);
			}
		}
	}
	else {
		$email = "";
		$token = "";
	}
	
	//Response after data processing
	if(isset($_SESSION['response'])){
		$response = $Tag->createAlert("", $_SESSION['response'], 'success', false);
		unset($_SESSION['response']);
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
	
	function generateForm($email, $resetToken){
		$form ="
			<form action='". htmlspecialchars('processor.php') ."' method='post'>
      	<input type='hidden' name='token' value='{$_SESSION['token']}' />
      	<input type='hidden' name='email' value='$email' />
      	<input type='hidden' name='resetToken' value='$resetToken' />
        <h2>Change Password</h2>
        <div>
        	<span style='float: left; text-shadow: none;'>minimum 8 characters</span>
          <input type='password' name='password' class='form-control' placeholder='Password' required />
        </div>
        <div>
          <input type='password' name='repeatPassword' class='form-control' placeholder='Password Again' required />
        </div>
        <div>
          <button class='btn btn-default submit' type='submit'>Change</button>
        </div>
        <div class='clearfix'></div>
        <div class='separator'>
          <div class='clearfix'></div>
          <br />
        </div>
      </form>
		";
		return $form;
	}
