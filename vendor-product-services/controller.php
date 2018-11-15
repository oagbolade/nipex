<?php
	//Get required files
	require_once '../config.php';
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
	$vendorDetails = $User->userDetails($_SESSION['nipexLogin']['email']); 
	$Authenication = new Authentication($DbHandle);
	$Authenication->setConstants($constant);
	$Authenication->keyToPage();
	$Authenication->pageAccessor(['vendor'], $vendorDetails['authority']);
	
	$_SESSION['token'] = md5(TOKEN);
	
	$Tag = new Tag(URL);
	$head = $Tag->createHead(SITENAME." | $pageName ", "nav-md home-page", ['css' => ['css/nprogress.css']]);
	
	$menu = $Tag->createSideBar($PDO, $vendorDetails['email'], ['parent'=>'Questionnaire', 'child'=>'Product and Services']);
	$mastHead = $Tag->createMastHead($PDO, $vendorDetails['email']);
	$slogan = $Tag->createFooterSlogan();
	$footer = $Tag->createFooter(['js/custom.js', 'js/product-services.js']);
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
	
	//Disable save
	$disableSave = "";
	$completionStatus = "";
	if($vendorDetails['que_submitted']=='yes'){
		$disableSave =  "disabled";
		$completionStatus = "<small class='al_completion_status'>questionnaire already submitted</small>";
	}
	
	$DbHandle->setTable("product_code");
	if ($content = $DbHandle->iRetrieveData(__LINE__, ['category'=>'category1'])) {
		$serviceOne = services($content);
	}
	if ($content = $DbHandle->iRetrieveData(__LINE__, ['category'=>'category2'])) {
		$serviceTwo = services($content);
	}
	$categories = Functions::dprCategoryCollection(false);
			$table = "
				<table class='table table-striped'>
		      <thead>
		        <tr>
		          <th>#</th>
		          <th>Product Code</th>
		          <th>Certificate</th>
		          <th></th>
		        </tr>
		      </thead>
		      <tbody>
		   ";
			 $DbHandle->setTable(" que_product_and_services");
			 $completion = 0;
			 if ($content = $DbHandle->iRetrieveData(__LINE__, ["vendor_id"=>$vendorDetails["vendor_id"]])) {
			 	$kanter = 0;
				 $DbHandle->setTable("product_code");
			 	foreach ($content as $product) {
			 		$productName = $DbHandle->iRetrieveData(__LINE__, ['code'=>$product['products_code']]);
			 		$table .="
						<tr>
		          <td scope='row'>".++$kanter."</td>
		          <td>{$product['products_code']} ({$productName[0]['service']})</td>
		          <td>
		          	<a target='_blank' class='btn btn-warning' href='".URL."document/dpr-document/{$product['certificate']}'>
		          		View
		          	</a>
		          </td>
		          <td>
		          	<form class='form-horizontal form-label-left' method='post' action='".htmlentities('processor.php')."'>
	              	<input type='hidden' name='token' value='{$_SESSION['token']}'/>
	              	<input type='hidden' name='id' value='{$product['id']}'/>
	              	<button $disableSave type='submit' value='delete' name='action' class='btn btn-danger'>Delete</button>
	              </form>
	            </td>
		        </tr> 
					 ";
			 	}
			 	
			 	$progress = [$product['products_code'], $product['certificate']];
			 	$completion = $functions->profileCompletion($functions->progress($progress), 2);
			 }
		   $table .="     
		      </tbody>
		    </table>
			";
	function services($content){
		$service = '';
		$code = '';
		for ($i=0; $i < count($content); $i++) {
			if ($i == 0) {
				$service .= "'".$content[$i]['service']." (".$content[$i]['code'].")'";
				$code .= "'".$content[$i]['code']."'";
			}else{
				$service .= ", '".$content[$i]['service']." (".$content[$i]['code'].")'";
				$code .= ", '".$content[$i]['code']."'";
			}
		}
		return [$service, $code];
	}