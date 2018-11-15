<?php
	//Get required files
	require_once '../config.php';
	require_once '../db-config.php';
	
	//Initialization
	$response = "";
	$constant = [
		'url' => URL, 'urlemail' => URLEMAIL, 'contactemail' => CONTACTEMAIL, 
		'development' => DEVELOPMENT, 'directory' => ROOT.'error', 'sitename' => SITENAME];
	$pageName = "Legal";
	
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
	
	$menu = $Tag->createSideBar($PDO, $vendorDetails['email'], ['parent'=>'Questionnaire', 'child'=>'Legal']);
	$mastHead = $Tag->createMastHead($PDO, $vendorDetails['email']);
	$slogan = $Tag->createFooterSlogan();
	$footer = $Tag->createFooter(['js/custom.js', 'js/legal.js']);
	
	//Error in data sent for processing
	$functions = new Functions();
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
	
	//Disable save
	$disableSave = ($vendorDetails['vendor_status']=='registered')? "": "disabled";

	$DbHandle->setTable("que_legal");
	$firstYear=$companyType=$cacNumber=$countryRegistration=$registrationYear="";
	$owners[0]['director']=$owners[0]['nationality']=$owners[0]['gender']=$owners[0]['ownership']="";
	$shareholder = "
		<tr>
			<td>
	      <input class='form-control' type='text' name='director[]'>
	    </td>
	    <td>
	      <input class='form-control' type='text' name='nationality[]'>
	    </td>
	    <td>
	      <input class='form-control' type='text' name='gender[]'>
	    </td>
	    <td>
	      <input class='form-control' type='number' name='ownership[]'>
	    </td>
	    <td></td>
    <tr>
	";
	
	if($content = $DbHandle->iRetrieveData(__LINE__, ["vendor_id"=>$vendorDetails["vendor_id"]])){
		$firstYear = $content[0]['business_commencement_year'];
		$companyType = $content[0]['company_type'];
		$countryRegistration = $content[0]['country_of_registration'];
		$cacNumber = $content[0]['cac_no'];
		$registrationYear = $content[0]['registration_year']; 
		$additionalComment = $content[0]['comments'];
		$associatedName = $content[0]['associated_company'];
		$countriesOption = "<option value=''>Pick a Country</option>";
		$countryRegistration = $content[0]["country_of_registration"];
		foreach (Functions::countryCollection() as $aCountry) {
		  if($aCountry == $content[0]["country_of_registration"]){
		    $countriesOption .="<option selected value='$aCountry'>$aCountry</option>";
		  }
		  else {
		    $countriesOption .="<option value='$aCountry'>$aCountry</option>";
		  }
		}
		if($owners = json_decode($content[0]['shareholder'], true)){
			$shareholder = "";
			foreach ($owners as $anOwner) {
				if($disableSave){
					$removeLink = "";
				}
				else {
					$removeLink = "<a href='".URL."vendor-legal/remove-director.php?vendor={$vendorDetails["vendor_id"]}&director={$anOwner['no']}' type='button' class='btn btn-sm btn-danger'>X</a>";
				}				 
				$shareholder .= "
					<tr>
						<td>
				      <input class='form-control' value='{$anOwner['director']}' type='text' name='director[]'>
				    </td>
				    <td>
				      <input class='form-control' value='{$anOwner['nationality']}' type='text' name='nationality[]'>
				    </td>
				    <td>
				      <input class='form-control' value='{$anOwner['gender']}' type='text' name='gender[]'>
				    </td>
				    <td>
				      <input class='form-control' value='{$anOwner['ownership']}' type='number' name='ownership[]'>
				    </td>
				    <td>
				    	$removeLink
				    </td>
				  </tr>
				";
			}
		}
	}
	
	$progress = [$firstYear, $companyType, $countryRegistration, $cacNumber, $registrationYear, $owners[0]['director'], $owners[0]['nationality'], $owners[0]['gender'], $owners[0]['ownership']];
	$completion = $functions->profileCompletion($functions->progress($progress), 9);
	
	//Disable save
	$disableSave = "";
	$completionStatus = "";
	if($vendorDetails['que_submitted']=='yes'){
		$disableSave =  "disabled";
		$completionStatus = "<small class='al_completion_status'>questionnaire already submitted</small>";
	}