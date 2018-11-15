<?php
  //Get required files
  require_once '../db-config.php';
  
  //Initialization
  $response = "";
  $constant = [
    'url' => URL, 'urlemail' => URLEMAIL, 'contactemail' => CONTACTEMAIL, 
    'development' => DEVELOPMENT, 'directory' => ROOT.'error', 'sitename' => SITENAME];
  $pageName = "Save Review";
  
  //Lock up page
  $DbHandle = new DBHandler($PDO, "login", __FILE__);
  $User = new Users($DbHandle); 
  $Authenication = new Authentication($DbHandle);
  $Authenication->setConstants($constant); 
  $Authenication->keyToPage();
	$userDetails = $User->userDetails($_SESSION['nipexLogin']['email']);
  $accessor = ['review officer', 'supervising officer', 'deputy manager', 'manager'];
	$Authenication->pageAccessor($accessor, $userDetails['authority']);
  
	//Check for valid vendor id
	if(isset($_GET['review'])){
		if(!in_array($_GET['review'], Functions::numericArray($DbHandle, 'review', 'id'))){
			header("Location: ". URL."home");
		}
	}
	else {
		header("Location: ". URL."home");
	}
	$reviewID = $_GET['review'];
  
  $_SESSION['token'] = md5(TOKENRAW);
  
  $Tag = new Tag(URL);
  $head = $Tag->createHead(SITENAME." | $pageName ", "nav-md home-page", ['css' => ['css/nprogress.css']]);
  
  $menu = $Tag->createSideBar($PDO, $userDetails['email'], ['parent'=>'Declaration', 'child'=>'']);
  $mastHead = $Tag->createMastHead($PDO, $userDetails['email']);
  $slogan = $Tag->createFooterSlogan();
  $footer = $Tag->createFooter(['js/custom.js', 'js/review-vendor-submission.js']);
  
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
      $functions = new Functions();
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
	
	//Get vendor details
	$DbHandle->setTable("review");
	$review = $DbHandle->iRetrieveData(__LINE__, ['id'=>$reviewID]);
	$review = $review[0];
  $DbHandle->setTable("vendor");
  $companyDetails = $DbHandle->iRetrieveData(__LINE__, ['id'=>$review['vendor_id']]);
  $companyName = $companyDetails[0]['company_name'];
	
	$disabled = "";
	switch ($userDetails['authority']) {
		case 'review officer':
			if($review['review_officer_show'] == 'no') $disabled = "disabled";
		break;
		case 'supervising officer':
			if($review['supervising_officer_show'] == 'no') $disabled = "disabled";
		break;
			case 'deputy manager':
			if($review['deputy_manager_show'] == 'no') $disabled = "disabled";
		break;
		case 'manager':
			if($review['manager_show'] == 'no') $disabled = "disabled";
		break;
	}