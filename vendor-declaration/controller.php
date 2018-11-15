<?php
  //Get required files
  require_once '../config.php';
  require_once '../db-config.php';
  
  //Initialization
  $response = "";
  $constant = [
    'url' => URL, 'urlemail' => URLEMAIL, 'contactemail' => CONTACTEMAIL, 
    'development' => DEVELOPMENT, 'directory' => ROOT.'error', 'sitename' => SITENAME];
  $pageName = "Declaration";
  
  //Lock up page
  $DbHandle = new DBHandler($PDO, "login", __FILE__);
  $User = new Users($DbHandle); 
  $Authenication = new Authentication($DbHandle);
  $Authenication->setConstants($constant);
  $Authenication->keyToPage();
	$userDetails = $User->userDetails($_SESSION['nipexLogin']['email']);
  $Authenication->pageAccessor(['vendor'], $userDetails['authority']);
  
  $_SESSION['token'] = md5(TOKEN);
  
  $Tag = new Tag(URL);
  $head = $Tag->createHead(SITENAME." | $pageName ", "nav-md home-page", ['css' => ['css/nprogress.css']]);
  
  $menu = $Tag->createSideBar($PDO, $userDetails['email'], ['parent'=>'Questionnaire', 'child'=>'Declarations']);
  $mastHead = $Tag->createMastHead($PDO, $userDetails['email']);
  $slogan = $Tag->createFooterSlogan();
  $footer = $Tag->createFooter(['js/custom.js']);
  $functions = new Functions();
  
  //Error in data sent for processing
  if(isset($_SESSION['dataError'])){
    if(!isset($_SESSION['spoofing'])){
      $content = "<ul>";
      foreach ($_SESSION['dataError'] as $aMessage) {
        $content .= "<li class='text-left'>$aMessage</li>"; 
      }
      $content .= "</ul>";
      $response = $Tag->createAlert("", $content, 'danger', false);
    }
    else{
      $ErrorAlerter = new ErrorAlert($_SESSION['spoofing'], $functions, $constant);
      $ErrorAlerter->sendAlerts();
      $response = $Tag->createAlert("System Error", "Ouch we are sorry something went wrong, we think your internet connection may be slow", 'danger', true);
      unset($_SESSION['spoofing']);
    }
    unset($_SESSION['dataError']);
  }
  
  //Response after data processing
  if(isset($_SESSION['response'])){
    $response = $Tag->createAlert("", $_SESSION['response'], 'success', false);
    unset($_SESSION['response']);
  }

  $function = new Functions();
  $DbHandle->setTable("que_declaration");
	$completedBy['Name']= $completedBy['Position']= $completedBy['Date']= $completedBy['Phone Number']= $lastChangedBy['Name']= $lastChangedBy['Position']= $lastChangedBy['Date']= $lastChangedBy['Phone Number']="";

  if ($content = $DbHandle->iRetrieveData(__LINE__, ["vendor_id"=>$userDetails["vendor_id"]])) {
    $executives = "";
    $completedBy = json_decode($content[0]["completed_by"], true);
    $lastChangedBy = json_decode($content[0]["last_changed_by"], true);
  }
  
  $progress = [$completedBy['Name'], $completedBy['Position'], $completedBy['Date'], $completedBy['Phone Number'], $lastChangedBy['Name'], $lastChangedBy['Position'], $lastChangedBy['Date'], $lastChangedBy['Phone Number']];
  $completion = $functions->profileCompletion($functions->progress($progress), 8);
	
	//Disable save
	$disableSave = "";
	$completionStatus = "";
	if($userDetails['que_submitted']=='yes'){
		$disableSave =  "disabled";
		$completionStatus = "<small class='al_completion_status'>questionnaire already submitted</small>";
	}
