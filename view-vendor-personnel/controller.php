<?php
  //Get required files
  require_once '../db-config.php';
  
  //Initialization
  $response = "";
  $constant = [
    'url' => URL, 'urlemail' => URLEMAIL, 'contactemail' => CONTACTEMAIL, 
    'development' => DEVELOPMENT, 'directory' => ROOT.'error', 'sitename' => SITENAME];
  $pageName = "View Personnel";
  
  //Lock up page
  $DbHandle = new DBHandler($PDO, "login", __FILE__);
  $User = new Users($DbHandle);
  $userDetails = $User->userDetails($_SESSION['nipexLogin']['email']); 
  $Authenication = new Authentication($DbHandle);
  $Authenication->setConstants($constant);
  $Authenication->keyToPage();
  $accessor = ['review officer', 'supervising officer', 'deputy manager', 'manager'];
  $Authenication->pageAccessor($accessor, $userDetails['authority']);
    
  //Check for valid vendor id
	if(isset($_GET['vendor']) && !isset($_GET['review'])) {
		if(!in_array($_GET['vendor'], Functions::numericArray($DbHandle, 'vendor', 'id'))){
			header("Location: ". URL."home");
			exit;
		}
		$vendorID = $_GET['vendor'];
	}
	elseif(isset($_GET['vendor']) && isset($_GET['review'])) {
		if(!Functions::validIDs($_GET['vendor'], $_GET['review'], $PDO)){
			header("Location: ". URL."home");	
			exit;
		}
		$vendorID = $_GET['vendor'];
		$reviewID = $_GET['review'];
	}
	else {
		header("Location: ". URL."home");	
		exit;
	}
	  
  $_SESSION['token'] = md5(TOKEN);
  
  $Tag = new Tag(URL);
  $head = $Tag->createHead(SITENAME." | $pageName ", "nav-md home-page", ['css' => ['css/nprogress.css']]);
  
  $menu = $Tag->createSideBar($PDO, $userDetails['email'], ['parent'=>'View Personnel', 'child'=>'']);
  $mastHead = $Tag->createMastHead($PDO, $userDetails['email']);
  $slogan = $Tag->createFooterSlogan();
  $footer = $Tag->createFooter(['js/custom.js', 'js/personnel.js']);
	$questionnaireMenu = "";
	if(isset($reviewID)){
		$questionnaireMenu = $Tag->reviewMenu($vendorID, $reviewID);
	}
  
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

  // default value
  
  $DbHandle->setTable("vendor");
  $companyDetails = $DbHandle->iRetrieveData(__LINE__, ['id'=>$vendorID]);
  $companyName = $companyDetails[0]['company_name'];
  
  $function = new Functions();
  $DbHandle->setTable("que_personnel");

  if ($content = $DbHandle->iRetrieveData(__LINE__, ["vendor_id"=>$vendorID])) {
    $currentYear = json_decode($content[0]["current_year"], true);
    $previousYear = json_decode($content[0]["previous_year"], true);
    $lastTwoYears = json_decode($content[0]["last_two_years"], true);
    $title = $content[0]["title"];
    $firstName = $content[0]["first_name"];
    $surname = $content[0]["surname"];
    $otherNames = $content[0]["other_name"];
    $jobTitle = $content[0]["job_title"];
    $addressLine1 = $content[0]["address_1"];
    $addressLine2 = $content[0]["address_2"];
    $town = $content[0]["town"];
    $state = $content[0]["state"];
    $telephone = $content[0]["phone"];
    $country = $content[0]["country"];
    $postCode = $content[0]["postcode"];
    $email = $content[0]["email"];
    $comment = $content[0]["comments"];
		$executives = "";
		if($executivesList = json_decode($content[0]['executives'])){
			foreach ($executivesList as $anExectiveList) {
				foreach ($anExectiveList as $anExectiveCaption => $anExecutive) {
					if($anExectiveCaption == "no") ++$anExecutive;
					$anExectiveCaption = ltrim($anExectiveCaption,"executive");
					$executives .= "
						<strong>".ucfirst($anExectiveCaption).":</strong> &nbsp; &nbsp; $anExecutive<br/>
					";
				}
				$executives .= "<br/>";
			}
		}
	

  }