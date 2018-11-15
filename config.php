<?php
	session_start();
	date_default_timezone_set('Africa/Lagos');

	$production = true;

	define('SITENAME', 'NipeX Joint Qualification System');	
	define('URLEMAIL', "alabiansolutions.com");
	define('CONTACTEMAIL', "it@nipexnig.com");
	define('WEBMASTEREMAIL', "info@alabiansolutions.com");
	define('SALT', '$2a$12$q.g9b586NIDlO5mPl1y2Cy$');
	define('ERRORPAGE', 'error');
	$token = '!2U@uYh12&u:T&8|x28HT'; 
	define('TOKENRAW', $token);
	define('TOKEN', $token . rand(1000, 9999));
	unset($token);

	if ($production === false){
        /*Development Server*/
        define('URL', "http://localhost/nipex/");
        define('ROOT', $_SERVER['DOCUMENT_ROOT'] . '/nipex/');
        define('DEVELOPMENT', TRUE);
    }else{
        //Production Server
        define('URL', "https://dayothegman.000webhostapp.com/");
        define('ROOT', $_SERVER['DOCUMENT_ROOT'] . '/');
        define('DEVELOPMENT', FALSE);
        define('PRIVATEKEYPS', 'sk_live_900f00a7f6b6f8df55c5ebf476b3038f3a137cc9');
        define('PUBLICKEYPS', 'pk_live_f6af49ec75778be349b18a556998ddf2a56a2391');
    }


spl_autoload_register(function ($class){
			$lastSplash=strrpos ($class, "\\");
			$classname=substr($class, $lastSplash);
			require_once ROOT.'Classes/'.ucfirst($classname).".php";	
		}
	);