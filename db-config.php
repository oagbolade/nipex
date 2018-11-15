<?php
	//Get required file
	require_once 'config.php';
	
	//Set up connection to database
	$connection=new Connector(URL.ERRORPAGE);
  $connection->host="localhost";
  
	/*Development*/
  $connection->username="id1209574_root";
  $connection->password="D@Y0D@V1Da";
  $connection->database="id1209574_nipex";

	/*Production
	$connection->username="alabians_nipex";
	$connection->password="&);el3Xz{7(n";
	$connection->database="alabians_nipex";*/
	
	$dbConnector=$connection->doConnect();
	
	//Get a PDO handle
	$PDO = new PDOHandler($dbConnector, URL.ERRORPAGE);