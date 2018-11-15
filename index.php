<!DOCTYPE html>
<html lang="en">
	<head>
		<meta charset="utf-8">
		<meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1">
		<meta name="description" content="">
		<meta name="author" content="Alabian Solutions Ltd for PROIT Ltd">
		<meta name="viewport" content="width=device-width; initial-scale=1.0">
		<title> NipeX Joint Qualification System (NJQS)</title>
  	<link rel="stylesheet" href="css/bootstrap.min.css">
  	<link rel="icon" href="images/favicon.ico" type="image/x-icon" />
  	<script src="js/jquery.min.js"></script>
  	<script src="js/bootstrap.min.js"></script>
		<link rel="stylesheet" id="coToolbarStyle" href="chrome-extension://cjabmdjcfcfdmffimndhafhblfmpjdpe/toolbar/styles/placeholder.css" type="text/css">
		<script type="text/javascript" id="cosymantecbfw_removeToolbar">
			(function () {
				var toolbarElement = {},parent = {},interval = 0,retryCount = 0, isRemoved = false;
				if (window.location.protocol === 'file:') {
					interval = window.setInterval(function () {	
						toolbarElement = document.getElementById('coFrameDiv');
						if (toolbarElement) {
							parent = toolbarElement.parentNode;
							if (parent) {
								parent.removeChild(toolbarElement);
								isRemoved = true;
								if (document.body && document.body.style) {
									document.body.style.setProperty('margin-top', '0px', 'important');
								}
							}
						}
						retryCount += 1;
						if (retryCount > 10 || isRemoved) {
							window.clearInterval(interval);
						}
					}, 
					10);
					}
				})
			();
		</script>
	</head>
	<body style="margin-top: 0px !important;">
		<div class="container">
			<center>
				<div class="row">
					<div class="span10 offset1"> 
						<img cclass="span12" lass="img-responsive" src="images/nnpc-logo.png" alt="NNPC Logo"></div>
					<div class="span5"> 
						<img class="img-responsive" src="images/nipex-logo.png" alt="NipeX Logo">
					</div> 
				</div>
			<h2>Welcome to NipeX Joint Qualification System (NJQS)</h2>
  		<br>
			<div class="jumbotron">
	  		<h2>Are you registered with NipeX JQS?</h2>
			  <br>
			  <br>
				<a href="login/#signup" class="btn btn-danger btn-lg" role="button">No</a>
	  		<a href="login" class="btn btn-success btn-lg" role="button">Yes</a>
			</div>
		</center>	
		</div>
	</body>
</html>