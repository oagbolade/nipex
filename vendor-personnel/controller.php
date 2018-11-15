<?php
  //Get required files
  require_once '../config.php';
  require_once '../db-config.php';
  
  //Initialization
  $response = "";
  $constant = [
    'url' => URL, 'urlemail' => URLEMAIL, 'contactemail' => CONTACTEMAIL, 
    'development' => DEVELOPMENT, 'directory' => ROOT.'error', 'sitename' => SITENAME];
  $pageName = "Personnel";
  
  //Lock up page
  $DbHandle = new DBHandler($PDO, "login", __FILE__);
  $User = new Users($DbHandle);
  $vendorDetails = $User->userDetails($_SESSION['nipexLogin']['email']); 
  $Authenication = new Authentication($DbHandle);
  $Authenication->setConstants($constant);
  $Authenication->keyToPage();
  $Authenication->pageAccessor(['vendor'], $vendorDetails['authority']);
  
  $_SESSION['token'] = md5(TOKEN);
  
  $Tag = new Tag(URL);
  $head = $Tag->createHead(SITENAME." | $pageName ", "nav-md home-page", ['css' => ['css/nprogress.css']]);
  
  $menu = $Tag->createSideBar($PDO, $vendorDetails['email'], ['parent'=>'Questionnaire', 'child'=>'Personnel']);
  $mastHead = $Tag->createMastHead($PDO, $vendorDetails['email']);
  $slogan = $Tag->createFooterSlogan();
  $footer = $Tag->createFooter(['js/custom.js', 'js/personnel.js']);
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
  $countriesOption = "<option value=''>Pick a Country</option>";
  foreach (Functions::countryCollection() as $aCountry) {
	  $countriesOption .="<option value='$aCountry'>$aCountry</option>";
  }

  // default value
  $title =  $firstName =  $surname = $otherNames = $jobTitle = $addressLine1 = $excos = "";
  $addressLine2 = $town =  $state = $country = $telephone = $postCode = $email = $comment = "";
	$yearParameter = [
		'Number of staff','Number of professional staff', 'Number of non-professional staff',
		'Number of permanent staff', 'Number of contract staff', 'Number of expatriate staff',
		'Additional information/Comments'
	];
	foreach ($yearParameter as $aParameter) {
		$currentYear[$aParameter] = "";
		$previousYear[$aParameter] = "";
		$lastTwoYears[$aParameter] = "";
	}
  
  $function = new Functions();
  $DbHandle->setTable("que_personnel");
	
	//Disable save
	$disableSave = ($vendorDetails['vendor_status']=='registered')? "": "disabled";

  $executives = "
  	<tr>
      <td>
        CEO/MD or GM*
        <input type='hidden' value='CEO/MD or GM' name='executivePosition[]'>
      </td>
      <td>
        <input class='form-control' type='text' name='executiveTitle[]'>
      </td>
      <td>
        <input class='form-control' type='text' name='executiveFirstName[]'>
      </td>
      <td>
        <input class='form-control' type='text' name='executiveOtherName[]' >
      </td>
      <td>
        <input class='form-control' type='text' name='executiveSurname[]'>
      </td>
      <td>
        <input class='form-control' type='text' name='executiveEmail[]'>
      </td>
      <td>
        <input class='form-control' type='text' name='executiveNationality[]'>
      </td>
      <td></td>
    </tr>";
		
  $progress = 0;
  if ($content = $DbHandle->iRetrieveData(__LINE__, ["vendor_id"=>$vendorDetails["vendor_id"]])) {
    $countriesOption = "";
    foreach (Functions::countryCollection() as $aCountry) {
      if($aCountry == $content[0]["country"]){
        $countriesOption .="<option selected value='$aCountry'>$aCountry</option>";
      }
      else {
        $countriesOption .="<option value='$aCountry'>$aCountry</option>";
      }
    }
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
    
    // CEO/MD General Manager
  if($excos = json_decode($content[0]['executives'], true)){
    $executives = "";
		$post =  ['CEO/MD', 'Finance Director', 'Sales/Marketing Manager', 'Technical/Ops Manager', 'Procurement Director', 'Others'];
    foreach ($excos as $anExcos) {
    	$position = "<select id='' class='form-control' name='executivePosition[]'>";
			foreach ($post as $aPost) {
				$position .= ($aPost == $anExcos['executivePosition'])? "<option selected>$aPost</option>":"<option>$aPost</option>";
			}
      $position .="</select>";
			if($disableSave){
				$removeLink = "";
			}
			else {
				$removeLink = "<a href='".URL."vendor-personnel/remove-executive.php?vendor={$vendorDetails["vendor_id"]}&executive={$anExcos['no']}' type='button' class='btn btn-sm btn-danger'>X</a>";
			}
      $executives .= "
        <tr>
	        <td>
	          $position
	        </td>
	        <td>
	          <input required class='form-control' value='{$anExcos['executiveTitle']}' type='text' name='executiveTitle[]'>
	        </td>
	        <td>
	          <input required class='form-control' value='{$anExcos['executiveFirstName']}' type='text' name='executiveFirstName[]'>
	        </td>
	        <td>
	          <input class='form-control' value='{$anExcos['executiveOtherName']}' type='text' name='executiveOtherName[]' >
	        </td>
	        <td>
	          <input required class='form-control' value='{$anExcos['executiveSurname']}' type='text' name='executiveSurname[]'>
	        </td>
	        <td>
	          <input required class='form-control' value='{$anExcos['executiveEmail']}' type='text' name='executiveEmail[]'>
	        </td>
	        <td>
	          <input required class='form-control' value='{$anExcos['executiveNationality']}' type='text' name='executiveNationality[]'>
	        </td>
	        <td>
	          $removeLink
	        </td>
	      </tr>
      ";
    }
  }
 }

 $progress = [$title, $firstName, $surname, $jobTitle, $addressLine1, $town, $state, $telephone, $email, $country, $excos, $currentYear['Number of staff']];
 $completion = $functions->profileCompletion($functions->progress($progress), 12);
 
 //Disable save
	$disableSave = "";
	$completionStatus = "";
	if($vendorDetails['que_submitted']=='yes'){
		$disableSave =  "disabled";
		$completionStatus = "<small class='al_completion_status'>questionnaire already submitted</small>";
	}