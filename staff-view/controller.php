<?php
	//Get required files
	require_once '../db-config.php';
	
	//Initialization
	$response = "";
	$constant = [
		'url' => URL, 'urlemail' => URLEMAIL, 'contactemail' => CONTACTEMAIL, 'salt' => SALT, 
		'development' => DEVELOPMENT, 'directory' => ROOT.'error', 'sitename' => SITENAME];
	$pageName = "View Staff";
	
	//Lock up page
	$DbHandle = new DBHandler($PDO, "login", __FILE__);
	$User = new Users($DbHandle); 
	$Authentication = new Authentication($DbHandle);
	$Authentication->setConstants($constant);
	$Authentication->keyToPage();
	$userDetails = $User->userDetails($_SESSION['nipexLogin']['email']);
	$Authentication->pageAccessor(['IT'], $userDetails['authority']);
	
	$_SESSION['token'] = md5(TOKEN);
	
	$Tag = new Tag(URL);
	$head = $Tag->createHead(SITENAME." | View Staff ", "nav-md view-staff-page", ['css' => ['css/nprogress.css']]);
	
	$menu = $Tag->createSideBar($PDO, $userDetails['email'], ['parent'=>'Staff Admin', 'child'=>'View Staff']);
	$mastHead = $Tag->createMastHead($PDO, $userDetails['email']);
	$slogan = $Tag->createFooterSlogan();
	$footer = $Tag->createFooter(['js/custom.js']);
	
	//Error in data sent for processing
	if(isset($_SESSION['dataError'])){
		if(!isset($_SESSION['spoofing'])){
			$content = "<ul>";
			foreach ($_SESSION['dataError'] as $aMessage) {
				$content .= "<li class='text-left'>$aMessage</li>";	
			}
			$content .= "</ul>";
			$response = $Tag->createAlert("", $content, 'danger', true);
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
		$response = $Tag->createAlert("", $_SESSION['response'], 'success', true);
		unset($_SESSION['response']);
	}
	
	//Get list of all staff
	$allStaff = $User->allUserDetails('staff');
	$table ="
		<table class='table table-striped'>
      <thead>
        <tr>
          <th>#</th>
          <th>Name</th>
          <th>Email</th>
          <th>Phone</th>
          <th>Status</th>
          <th>Default Password</th>
          <th>Authority</th>
          <th></th>
          <th></th>
        </tr>
      </thead>
      <tbody>
	";
	if($allStaff){
		$kanter = 0;
		foreach ($allStaff as $aStaff) {
			$activationText = ($aStaff['status'] == 'active') ? "inactive" : "active";
			$activationButton = ($aStaff['status'] == 'active') ? "Deactivate" : "Activate";
			$btnColor = ($aStaff['status'] == 'active') ? "warning " : "info";
			$table .="
				<tr>
          <td>". ++$kanter ."</th>
          <td>{$aStaff['name']}</td>
          <td>{$aStaff['email']}</td>
          <td>{$aStaff['phone']}</td>
          <td>". ucfirst($aStaff['status']) ."</td>
          <td>". ucfirst($aStaff['default_password']) ."</td>
          <td>". ucfirst($aStaff['authority']) ."</td>
          <td>
          	<form action='". htmlspecialchars("processor.php") ."' method='post'>
        			<input type='hidden' name='token' value='{$_SESSION['token']}' />
        			<input type='hidden' name='staffEmail' value='{$aStaff['email']}' />
        			<button class='btn btn-$btnColor btn-sm' type='submit' name='action' value='$activationText'>$activationButton</button>
          	</form>
          </td>
          <td>
          	<form action='". htmlspecialchars("processor.php") ."' method='post'>
        			<input type='hidden' name='token' value='{$_SESSION['token']}' />
        			<input type='hidden' name='staffEmail' value='{$aStaff['email']}' />
        			<button class='btn btn-danger btn-sm' type='submit' name='action' value='delete'>Delete</button>
          	</form>
          </td>
        </tr>
			";
		}
	}
	
	$table .= "</tbody></table>";