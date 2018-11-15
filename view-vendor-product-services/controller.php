<?php
	//Get required files
	require_once '../db-config.php';
	
	//Initialization
	$response = "";
	$constant = [
		'url' => URL, 'urlemail' => URLEMAIL, 'contactemail' => CONTACTEMAIL, 
		'development' => DEVELOPMENT, 'directory' => ROOT.'error', 'sitename' => SITENAME];
	$pageName = "Product Services";
	
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
	
	$menu = $Tag->createSideBar($PDO, $userDetails['email'], ['parent'=>'Product Services', 'child'=>'']);
	$mastHead = $Tag->createMastHead($PDO, $userDetails['email']);
	$slogan = $Tag->createFooterSlogan();
	$footer = $Tag->createFooter(['js/custom.js']);
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

	$DbHandle->setTable("vendor");
	$companyDetails = $DbHandle->iRetrieveData(__LINE__, ['id'=>$vendorID]);
	$companyName = $companyDetails[0]['company_name'];
	
	//Get the product from database
	$query = "
		SELECT products_code, certificate, service, category 
		FROM  que_product_and_services INNER JOIN product_code 
		ON product_code.code = que_product_and_services.products_code
		WHERE vendor_id = :vendor_id";
	$category = Functions::dprCategoryCollection(false);
	if ($content = $DbHandle->dataList(__LINE__, $query, ['vendor_id'=>$vendorID])) {
		$kanter = 0;
		$table = "";
	 	foreach ($content as $product) {
	 		$table .="
				<tr>
					<td scope='row'>".++$kanter."</td>
          <td>{$product['products_code']}</td>
          <td>{$product['service']}</td>
          <td>{$category[$product['category']]}</td>
          <td><a target='_blank' class='btn btn-warning' href='".URL."document/dpr-document/{$product['certificate']}'>View</td>
        </tr> 
			 ";
	 	}
	}