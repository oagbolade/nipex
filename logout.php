<?php
	require_once 'db-config.php';
	$DbHandle = new DBHandler($PDO, "login", __FILE__);
	$Authenication = new Authentication($DbHandle);
	$Authenication->logoutUser();