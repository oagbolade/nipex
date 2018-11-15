<?php
	/**
	 * Functions
	 * 
	 * This class is used to to supply some commonly used functions
	 * @author			Alabi A. <alabi.adebayo@alabiansolutions.com>
	 * @copyright		2014 Alabian Solutions Limited
	 * @link 				alabiansolutions.com
	 */
	class Functions{
	/**
	 * Check if magic quotes is on and then turn it off if it is.
	 */
		public static function magicQuotesOff(){
			if (get_magic_quotes_gpc()){
					function stripslashes_deep($value){
						$value = is_array($value) ?
						array_map('stripslashes_deep', $value) :  stripslashes($value);
						 return $value;
					}
				$_POST = array_map('stripslashes_deep', $_POST);
				$_GET = array_map('stripslashes_deep', $_GET);
				$_COOKIE = array_map('stripslashes_deep', $_COOKIE);
				$_REQUEST = array_map('stripslashes_deep', $_REQUEST);
			}
		}

		/**
		 * Sanitize value passed to it. This help prevent malicious input been passed to your script
		 * @param string $var the value to be sanitized 
		 * @return string $var the value after sanitization
		 */

		public static function sanitizeString($var){
			$var = stripslashes($var);
  		$var = htmlspecialchars($var, ENT_QUOTES, 'UTF-8');
  		$var = strip_tags($var);
  		return $var;
		}

		

		/**
		 * Sanitize and echo the string passed to it
		 * @param string $var the value to be echo 
		 */
		public static function sanitizeEchoer($var){
			echo self::sanitizeString($var);
		}

		/**
		 * Simply sanitize the string passed
		 * @param string $var the value to be sanitize 
		 * @return string $cleanVar the santized string
		 */
		public static function sanitizer($var){
			$cleanVar = self::sanitizeString($var);
			return $cleanVar;
		}

		/**
		 * Simply echo the string passed to it
		 * @param string $var the value to be echo 
		 */
		public static function echoer($var){
			echo $var;
		}

		/**
		 * Simply generate the head part of the HTML string for generation of email template
		 * @param string $url the url of the server where the email will be sent from
		 * @return string $headEmail the head part of the HTML string 
		 */
		public static function emailHead($url){
			$headEmail="
			 <html>
				<head>
					<title></title>
		  	</head>
				<body>
			 	<div style='width:88%; color: #fff; padding:0px 0 15px 0; background-color: #29b89a;'>
		     <div style='
		     	background-color: #fefefe;
		     	border-bottom:2px solid #fbd602; 
		     	padding:7px 1% 7px;
		     	margin-bottom:15px;
		     	text-align: center; 
		     	'>
			     	<div style='float:left;'>
			     		<img src='". $url ."images/nipex-logo.png' style='height:76px; width:172px;'/>
			     	</div>
			     	<div style='float:right;'>
			     		<img src='". $url ."images/nnpc-logo.png' style='height:76px; width:76px;'/>
			     	</div>
			     	<div style='clear:both;'></div>
		       	<a href='$url' style='text-decoration:none; color:#0e1d54;'>
							<span style='
								color:#2A63BD;
								display: block;
								font-size:20px;
								font-size:1.25rem;
								font-weight: bold;
								text-decoration: none;
								text-align: center;
							'>
							 	".SITENAME."
						 	</span>
					 </a>
			 	 </div>
			 <div style='padding:5px 1%; color:#fff; font-size:12px; font-family:Arial;'>";
			return $headEmail;
		}

		/**
		 * Simply generate the footer part of the HTML string for generation of email template
		 * @param string $url the url of the server where the email will be sent from
		 * @return string $footerEmail the footer part of the HTML string 
		 */
		public static function footerHead($url){
			$footerEmail="
				</div>
				<div style='margin-bottom:60px; margin-top:30px; padding: 0px 1%;'>
			   	System Admin<br/>
			   	<a href='$url' style='color:#f0f0f0;'>For ".SITENAME."</a>
			 	</div>
				<div style='font-size:9px; background-color: #fefefe; border:1px solid #fbd602; padding-top:10px; padding-bottom:10px;'>
					<div style='font-size:9px; float:left; color:#999; padding-left:5px' >
						Developed by <a style='color:#999; text-decoration:none;' rel='nofollow' href=''>
			     	NipeX IT Department</a>
					</div>
					<div style='font-size:9px; float:right; color:#999; padding-right:5px' >
						&copy; ".date("Y")." NipeX
					</div>
					<div style='clear:both;'></div>
				</div>
				</div>
				</body>
				</html>
			 ";
			return $footerEmail;
		}

		/**
		 * Generate the ASCII code of digits, alphabet upper & case
		 * @return array $array an array that contains ASCII of digits, alphabet upper & lower case 
		 */
		public static function asciiTableDigitalAlphabet(){
	  	$array=array();
			//Digitals
			for ($kanter=48; $kanter <=57 ; $kanter++) { 
				$array[]=$kanter;
			}
			//Uppercase
			for ($kanter=65; $kanter <=90 ; $kanter++) { 
				$array[]=$kanter;
			}
			//Lowercase
			for ($kanter=97; $kanter <=122 ; $kanter++) { 
				$array[]=$kanter;
			}
			shuffle($array);
			return $array;
	  }

		/**
		 * Generate the ASCII code of digits, alphabet upper & case
		 * @param array $ASCIIArray an array that contains ASCII Code
		 * @param string $dataFormat the format of the return value of array for array or other value for string
		 * @return mix $characters an array or string that contains character that matches the ASCII Code supplied 
		 */
		public static function characterFromASCII($ASCIIArray, $dataFormat='array'){
			$max=count($ASCIIArray);
			for ($kanter=0; $kanter <$max ; $kanter++) { 
				$array[]=chr($ASCIIArray[$kanter]);
			}
			if($dataFormat=='array'){
				$characters=$array;
			}
			else {
				$characters="";
				foreach ($array as $anArrayValue) {
					$characters.=$anArrayValue;
				}
			}
			return $characters;
		}
		
		/**
		 * Get the title for saluation from the gender supplied
		 * @param string $gender which is either male or female
		 * @param array $type an array that contain the saluation to be used like (his/her, he/she, him/her)
		 * @return string $title the title 
		 */
		public static function iTheTitle($gender, $type=array('sir', 'madam'), $case="UC"){
			if($gender=="male"){
				$title=ucfirst($type[0]);
			}
			else {
				$title=ucfirst($type[0]);
			}
			if($case!="UC"){
				$title=strtolower($title);
			}
			return $title;
		}

		/**
		 * A collection of years from 1940 to present year
		 * @return array $years an array of years from 1940 to present year
		 */
		public static function yearsCollection(){
			for ($i=1940; $i <=date("Y") ; $i++) { 
				$years[]=$i;
			}
			return $years;
		}

		/**
		 * A collection of months in the year 
		 * @return array $months an array of months in the year
		 */
		public static function monthsCollection(){
			$months=array( "January", "February", "March", "April", "May", "June", "July", "August", "September", "October", "November","December");
			return $months;
		}
		
		/**
		 * A collection of banks in nigeria 
		 * @return array $banks an array of banks in nigeria
		 */
		public static function banksCollection(){
			$banks=array(
				"Access Bank","Citibank","Diamond Bank","Ecobank","Fidelity Bank","First Bank","First City Monument Bank",
				"Guaranty Trust Bank","Heritage Bank Plc","Keystone Bank","Skye Bank","Stanbic IBTC Bank",
				"Standard Chartered Bank","Sterling Bank","Union Bank","United Bank for Africa",
				"Unity Bank Plc","Wema Bank","Zenith Bank","Jaiz Bank");
			return $banks;
		}	
		
		/**
		 * A collection of world country's name, intl phone code and abbreviation 
		 * @parameter $expectedData either name, phone or abbreviation
		 * @return array $country an array of country name or phone code or abbrevation
		 */
		public static function countryCollection($expectedData = "name"){
			$countriesJSON='[{"name":"Afghanistan","dial_code":"+93","code":"AF"},{"name":"Albania","dial_code":"+355","code":"AL"},{"name":"Algeria","dial_code":"+213","code":"DZ"},{"name":"AmericanSamoa","dial_code":"+1 684","code":"AS"},{"name":"Andorra","dial_code":"+376","code":"AD"},{"name":"Angola","dial_code":"+244","code":"AO"},{"name":"Anguilla","dial_code":"+1 264","code":"AI"},{"name":"Antarctica","dial_code":"+672","code":"AQ"},{"name":"Antigua and Barbuda","dial_code":"+1268","code":"AG"},{"name":"Argentina","dial_code":"+54","code":"AR"},{"name":"Armenia","dial_code":"+374","code":"AM"},{"name":"Aruba","dial_code":"+297","code":"AW"},{"name":"Australia","dial_code":"+61","code":"AU"},{"name":"Austria","dial_code":"+43","code":"AT"},{"name":"Azerbaijan","dial_code":"+994","code":"AZ"},{"name":"Bahamas","dial_code":"+1 242","code":"BS"},{"name":"Bahrain","dial_code":"+973","code":"BH"},{"name":"Bangladesh","dial_code":"+880","code":"BD"},{"name":"Barbados","dial_code":"+1 246","code":"BB"},{"name":"Belarus","dial_code":"+375","code":"BY"},{"name":"Belgium","dial_code":"+32","code":"BE"},{"name":"Belize","dial_code":"+501","code":"BZ"},{"name":"Benin","dial_code":"+229","code":"BJ"},{"name":"Bermuda","dial_code":"+1 441","code":"BM"},{"name":"Bhutan","dial_code":"+975","code":"BT"},{"name":"Bolivia, Plurinational State of","dial_code":"+591","code":"BO"},{"name":"Bosnia and Herzegovina","dial_code":"+387","code":"BA"},{"name":"Botswana","dial_code":"+267","code":"BW"},{"name":"Brazil","dial_code":"+55","code":"BR"},{"name":"British Indian Ocean Territory","dial_code":"+246","code":"IO"},{"name":"Brunei Darussalam","dial_code":"+673","code":"BN"},{"name":"Bulgaria","dial_code":"+359","code":"BG"},{"name":"Burkina Faso","dial_code":"+226","code":"BF"},{"name":"Burundi","dial_code":"+257","code":"BI"},{"name":"Cambodia","dial_code":"+855","code":"KH"},{"name":"Cameroon","dial_code":"+237","code":"CM"},{"name":"Canada","dial_code":"+1","code":"CA"},{"name":"Cape Verde","dial_code":"+238","code":"CV"},{"name":"Cayman Islands","dial_code":"+ 345","code":"KY"},{"name":"Central African Republic","dial_code":"+236","code":"CF"},{"name":"Chad","dial_code":"+235","code":"TD"},{"name":"Chile","dial_code":"+56","code":"CL"},{"name":"China","dial_code":"+86","code":"CN"},{"name":"Christmas Island","dial_code":"+61","code":"CX"},{"name":"Cocos (Keeling) Islands","dial_code":"+61","code":"CC"},{"name":"Colombia","dial_code":"+57","code":"CO"},{"name":"Comoros","dial_code":"+269","code":"KM"},{"name":"Congo","dial_code":"+242","code":"CG"},{"name":"Congo, The Democratic Republic of the","dial_code":"+243","code":"CD"},{"name":"Cook Islands","dial_code":"+682","code":"CK"},{"name":"Costa Rica","dial_code":"+506","code":"CR"},{"name":"Cote d\'Ivoire","dial_code":"+225","code":"CI"},{"name":"Croatia","dial_code":"+385","code":"HR"},{"name":"Cuba","dial_code":"+53","code":"CU"},{"name":"Cyprus","dial_code":"+537","code":"CY"},{"name":"Czech Republic","dial_code":"+420","code":"CZ"},{"name":"Denmark","dial_code":"+45","code":"DK"},{"name":"Djibouti","dial_code":"+253","code":"DJ"},{"name":"Dominica","dial_code":"+1 767","code":"DM"},{"name":"Dominican Republic","dial_code":"+1 849","code":"DO"},{"name":"Ecuador","dial_code":"+593","code":"EC"},{"name":"Egypt","dial_code":"+20","code":"EG"},{"name":"El Salvador","dial_code":"+503","code":"SV"},{"name":"Equatorial Guinea","dial_code":"+240","code":"GQ"},{"name":"Eritrea","dial_code":"+291","code":"ER"},{"name":"Estonia","dial_code":"+372","code":"EE"},{"name":"Ethiopia","dial_code":"+251","code":"ET"},{"name":"Falkland Islands (Malvinas)","dial_code":"+500","code":"FK"},{"name":"Faroe Islands","dial_code":"+298","code":"FO"},{"name":"Fiji","dial_code":"+679","code":"FJ"},{"name":"Finland","dial_code":"+358","code":"FI"},{"name":"France","dial_code":"+33","code":"FR"},{"name":"French Guiana","dial_code":"+594","code":"GF"},{"name":"French Polynesia","dial_code":"+689","code":"PF"},{"name":"Gabon","dial_code":"+241","code":"GA"},{"name":"Gambia","dial_code":"+220","code":"GM"},{"name":"Georgia","dial_code":"+995","code":"GE"},{"name":"Germany","dial_code":"+49","code":"DE"},{"name":"Ghana","dial_code":"+233","code":"GH"},{"name":"Gibraltar","dial_code":"+350","code":"GI"},{"name":"Greece","dial_code":"+30","code":"GR"},{"name":"Greenland","dial_code":"+299","code":"GL"},{"name":"Grenada","dial_code":"+1 473","code":"GD"},{"name":"Guadeloupe","dial_code":"+590","code":"GP"},{"name":"Guam","dial_code":"+1 671","code":"GU"},{"name":"Guatemala","dial_code":"+502","code":"GT"},{"name":"Guernsey","dial_code":"+44","code":"GG"},{"name":"Guinea","dial_code":"+224","code":"GN"},{"name":"Guinea-Bissau","dial_code":"+245","code":"GW"},{"name":"Guyana","dial_code":"+595","code":"GY"},{"name":"Haiti","dial_code":"+509","code":"HT"},{"name":"Holy See (Vatican City State)","dial_code":"+379","code":"VA"},{"name":"Honduras","dial_code":"+504","code":"HN"},{"name":"Hong Kong","dial_code":"+852","code":"HK"},{"name":"Hungary","dial_code":"+36","code":"HU"},{"name":"Iceland","dial_code":"+354","code":"IS"},{"name":"India","dial_code":"+91","code":"IN"},{"name":"Indonesia","dial_code":"+62","code":"ID"},{"name":"Iran, Islamic Republic of","dial_code":"+98","code":"IR"},{"name":"Iraq","dial_code":"+964","code":"IQ"},{"name":"Ireland","dial_code":"+353","code":"IE"},{"name":"Isle of Man","dial_code":"+44","code":"IM"},{"name":"Israel","dial_code":"+972","code":"IL"},{"name":"Italy","dial_code":"+39","code":"IT"},{"name":"Jamaica","dial_code":"+1 876","code":"JM"},{"name":"Japan","dial_code":"+81","code":"JP"},{"name":"Jersey","dial_code":"+44","code":"JE"},{"name":"Jordan","dial_code":"+962","code":"JO"},{"name":"Kazakhstan","dial_code":"+7 7","code":"KZ"},{"name":"Kenya","dial_code":"+254","code":"KE"},{"name":"Kiribati","dial_code":"+686","code":"KI"},{"name":"Korea, Democratic People\'s Republic of","dial_code":"+850","code":"KP"},{"name":"Korea, Republic of","dial_code":"+82","code":"KR"},{"name":"Kuwait","dial_code":"+965","code":"KW"},{"name":"Kyrgyzstan","dial_code":"+996","code":"KG"},{"name":"Lao People\'s Democratic Republic","dial_code":"+856","code":"LA"},{"name":"Latvia","dial_code":"+371","code":"LV"},{"name":"Lebanon","dial_code":"+961","code":"LB"},{"name":"Lesotho","dial_code":"+266","code":"LS"},{"name":"Liberia","dial_code":"+231","code":"LR"},{"name":"Libyan Arab Jamahiriya","dial_code":"+218","code":"LY"},{"name":"Liechtenstein","dial_code":"+423","code":"LI"},{"name":"Lithuania","dial_code":"+370","code":"LT"},{"name":"Luxembourg","dial_code":"+352","code":"LU"},{"name":"Macao","dial_code":"+853","code":"MO"},{"name":"Macedonia, The Former Yugoslav Republic of","dial_code":"+389","code":"MK"},{"name":"Madagascar","dial_code":"+261","code":"MG"},{"name":"Malawi","dial_code":"+265","code":"MW"},{"name":"Malaysia","dial_code":"+60","code":"MY"},{"name":"Maldives","dial_code":"+960","code":"MV"},{"name":"Mali","dial_code":"+223","code":"ML"},{"name":"Malta","dial_code":"+356","code":"MT"},{"name":"Marshall Islands","dial_code":"+692","code":"MH"},{"name":"Martinique","dial_code":"+596","code":"MQ"},{"name":"Mauritania","dial_code":"+222","code":"MR"},{"name":"Mauritius","dial_code":"+230","code":"MU"},{"name":"Mayotte","dial_code":"+262","code":"YT"},{"name":"Mexico","dial_code":"+52","code":"MX"},{"name":"Micronesia, Federated States of","dial_code":"+691","code":"FM"},{"name":"Moldova, Republic of","dial_code":"+373","code":"MD"},{"name":"Monaco","dial_code":"+377","code":"MC"},{"name":"Mongolia","dial_code":"+976","code":"MN"},{"name":"Montenegro","dial_code":"+382","code":"ME"},{"name":"Montserrat","dial_code":"+1664","code":"MS"},{"name":"Morocco","dial_code":"+212","code":"MA"},{"name":"Mozambique","dial_code":"+258","code":"MZ"},{"name":"Myanmar","dial_code":"+95","code":"MM"},{"name":"Namibia","dial_code":"+264","code":"NA"},{"name":"Nauru","dial_code":"+674","code":"NR"},{"name":"Nepal","dial_code":"+977","code":"NP"},{"name":"Netherlands","dial_code":"+31","code":"NL"},{"name":"Netherlands Antilles","dial_code":"+599","code":"AN"},{"name":"New Caledonia","dial_code":"+687","code":"NC"},{"name":"New Zealand","dial_code":"+64","code":"NZ"},{"name":"Nicaragua","dial_code":"+505","code":"NI"},{"name":"Niger","dial_code":"+227","code":"NE"},{"name":"Nigeria","dial_code":"+234","code":"NG"},{"name":"Niue","dial_code":"+683","code":"NU"},{"name":"Norfolk Island","dial_code":"+672","code":"NF"},{"name":"Northern Mariana Islands","dial_code":"+1 670","code":"MP"},{"name":"Norway","dial_code":"+47","code":"NO"},{"name":"Oman","dial_code":"+968","code":"OM"},{"name":"Pakistan","dial_code":"+92","code":"PK"},{"name":"Palau","dial_code":"+680","code":"PW"},{"name":"Palestinian Territory, Occupied","dial_code":"+970","code":"PS"},{"name":"Panama","dial_code":"+507","code":"PA"},{"name":"Papua New Guinea","dial_code":"+675","code":"PG"},{"name":"Paraguay","dial_code":"+595","code":"PY"},{"name":"Peru","dial_code":"+51","code":"PE"},{"name":"Philippines","dial_code":"+63","code":"PH"},{"name":"Pitcairn","dial_code":"+872","code":"PN"},{"name":"Poland","dial_code":"+48","code":"PL"},{"name":"Portugal","dial_code":"+351","code":"PT"},{"name":"Puerto Rico","dial_code":"+1 939","code":"PR"},{"name":"Qatar","dial_code":"+974","code":"QA"},{"name":"Romania","dial_code":"+40","code":"RO"},{"name":"Russia","dial_code":"+7","code":"RU"},{"name":"Rwanda","dial_code":"+250","code":"RW"},{"name":"Réunion","dial_code":"+262","code":"RE"},{"name":"Saint Barthélemy","dial_code":"+590","code":"BL"},{"name":"Saint Helena, Ascension and Tristan Da Cunha","dial_code":"+290","code":"SH"},{"name":"Saint Kitts and Nevis","dial_code":"+1 869","code":"KN"},{"name":"Saint Lucia","dial_code":"+1 758","code":"LC"},{"name":"Saint Martin","dial_code":"+590","code":"MF"},{"name":"Saint Pierre and Miquelon","dial_code":"+508","code":"PM"},{"name":"Saint Vincent and the Grenadines","dial_code":"+1 784","code":"VC"},{"name":"Samoa","dial_code":"+685","code":"WS"},{"name":"San Marino","dial_code":"+378","code":"SM"},{"name":"Sao Tome and Principe","dial_code":"+239","code":"ST"},{"name":"Saudi Arabia","dial_code":"+966","code":"SA"},{"name":"Senegal","dial_code":"+221","code":"SN"},{"name":"Serbia","dial_code":"+381","code":"RS"},{"name":"Seychelles","dial_code":"+248","code":"SC"},{"name":"Sierra Leone","dial_code":"+232","code":"SL"},{"name":"Singapore","dial_code":"+65","code":"SG"},{"name":"Slovakia","dial_code":"+421","code":"SK"},{"name":"Slovenia","dial_code":"+386","code":"SI"},{"name":"Solomon Islands","dial_code":"+677","code":"SB"},{"name":"Somalia","dial_code":"+252","code":"SO"},{"name":"South Africa","dial_code":"+27","code":"ZA"},{"name":"South Georgia and the South Sandwich Islands","dial_code":"+500","code":"GS"},{"name":"Spain","dial_code":"+34","code":"ES"},{"name":"Sri Lanka","dial_code":"+94","code":"LK"},{"name":"Sudan","dial_code":"+249","code":"SD"},{"name":"Suriname","dial_code":"+597","code":"SR"},{"name":"Svalbard and Jan Mayen","dial_code":"+47","code":"SJ"},{"name":"Swaziland","dial_code":"+268","code":"SZ"},{"name":"Sweden","dial_code":"+46","code":"SE"},{"name":"Switzerland","dial_code":"+41","code":"CH"},{"name":"Syrian Arab Republic","dial_code":"+963","code":"SY"},{"name":"Taiwan, Province of China","dial_code":"+886","code":"TW"},{"name":"Tajikistan","dial_code":"+992","code":"TJ"},{"name":"Tanzania, United Republic of","dial_code":"+255","code":"TZ"},{"name":"Thailand","dial_code":"+66","code":"TH"},{"name":"Timor-Leste","dial_code":"+670","code":"TL"},{"name":"Togo","dial_code":"+228","code":"TG"},{"name":"Tokelau","dial_code":"+690","code":"TK"},{"name":"Tonga","dial_code":"+676","code":"TO"},{"name":"Trinidad and Tobago","dial_code":"+1 868","code":"TT"},{"name":"Tunisia","dial_code":"+216","code":"TN"},{"name":"Turkey","dial_code":"+90","code":"TR"},{"name":"Turkmenistan","dial_code":"+993","code":"TM"},{"name":"Turks and Caicos Islands","dial_code":"+1 649","code":"TC"},{"name":"Tuvalu","dial_code":"+688","code":"TV"},{"name":"Uganda","dial_code":"+256","code":"UG"},{"name":"Ukraine","dial_code":"+380","code":"UA"},{"name":"United Arab Emirates","dial_code":"+971","code":"AE"},{"name":"United Kingdom","dial_code":"+44","code":"GB"},{"name":"United States","dial_code":"+1","code":"US"},{"name":"Uruguay","dial_code":"+598","code":"UY"},{"name":"Uzbekistan","dial_code":"+998","code":"UZ"},{"name":"Vanuatu","dial_code":"+678","code":"VU"},{"name":"Venezuela, Bolivarian Republic of","dial_code":"+58","code":"VE"},{"name":"Viet Nam","dial_code":"+84","code":"VN"},{"name":"Virgin Islands, British","dial_code":"+1 284","code":"VG"},{"name":"Virgin Islands, U.S.","dial_code":"+1 340","code":"VI"},{"name":"Wallis and Futuna","dial_code":"+681","code":"WF"},{"name":"Yemen","dial_code":"+967","code":"YE"},{"name":"Zambia","dial_code":"+260","code":"ZM"},{"name":"Zimbabwe","dial_code":"+263","code":"ZW"},{"name":"Åland Islands","dial_code":"+358","code":"AX"}]';
			$countries = [];
			$countriesObject=json_decode($countriesJSON);
			foreach ($countriesObject as $aCountry) {
				if($expectedData == "name") $countries[] = $aCountry->name;
				if($expectedData == "phone") $countries[] = $aCountry->dial_code;
				if($expectedData == "abbreviation") $countries[] = $aCountry->code;
			}
			return $countries;
		}
		
		/**
		 * Convert time from mysql database server localtime to Africa/Lagos localtime
		 * @param string $time the time from mysql database server
		 * @param boolean $development true for development server and false for production server
		 * @param boolean $formated the format of the returned time, if UNIX time or human readable time
		 * @return mixed $formatedTime Africa/Lagos localtime 
		 */
		public static function dbTimeToLocal($time, $development, $formated=TRUE){
			$timeDifference=8*60*60;
			$localTime=($development ? strtotime($time):strtotime($time)+$timeDifference);
			$formatedTime=($formated ? date("g:ia jS F Y", $localTime):$localTime);
			return $formatedTime;
		}
		
		/**
		 * Get table that store various user's authority info
		 * @return array collection of user's authority type table
		 */
		public static function authorityTable(){
			return [
				'pre-vendor' => 'pre_vendor',
				'vendor' => 'vendor', 
				'review officer' => 'staff',
				'supervising officer' => 'staff', 
				'deputy manager' => 'staff', 
				'manager' => 'staff', 
				'audit' => 'staff',
				'IT' => 'staff', 
				'finance' => 'staff',
				'staff' => 'staff'
				];
		}
		
		/**
		 * Get all the various authority of users on the app
		 * @param boolean $withType if asso array with authority type
		 * @return array collection of authorities 
		 */
		public static function authorities($withType = false){
			$authories = [
				'pre-vendor',
				'vendor', 
				'review officer',
				'supervising officer', 
				'deputy manager', 
				'manager', 
				'audit',
				'IT', 
				'finance'];
			if($withType){
				$authories = [
				'pre-vendor' => 'vendor',
				'vendor' => 'vendor', 
				'review officer' => 'staff',
				'supervising officer' => 'staff', 
				'deputy manager' => 'staff', 
				'manager' => 'staff', 
				'audit' => 'staff',
				'IT' => 'staff', 
				'finance' => 'staff'];
			}
			return $authories;
		}
		
		/**
		 * Get all the various user group on the app
		 * @return array collection of user group 
		 */
		public static function userGroup(){
			return [
				'Supplier/Vendor',
				'Buyer/IOC', 
				'NAPIMS', 
				'NipeX'
				];
		}
		
		/**
		 * Get all the various title in the app
		 * @return array collection of title 
		 */
		public static function titleCollectio(){
			return ['Mr', 'Mrs', 'Miss', 'Dr'];
		}
		
		/**
		 * Get all DPR Category in the app
		 * @param boolean $numeric if true returned array is numeric else associative
		 * @return array $collection an array of DPR permit category
		 */
		public static function dprCategoryCollection($numeric = true){
			$collection = [
				'category1' => 'General DPR Category', 
				'category2' => 'Major DPR Category',
				'category3' => 'Specialized DPR Category'];
			if($numeric){
				$collection = ['category1','category2','category3'];	
			}
			return $collection;
		}
		
		/**
		 * Produce a numeric array of just a column in the table of a database
		 * @param string $Db the database handler
		 * @param string $table the table to be worked on in the database
		 * @param string $colunmName column be turned to array
		 * @return array $columns a collection of the colunm's value 
		 */
		public static function numericArray($Db, $table, $columnName){
			$formerTable = $Db->getTable();
			$Db->setTable($table);
			$colums = [];
			if($records = $Db->retrieveData(__LINE__)){
				foreach ($records as $aRecord) {
					$colums[] = $aRecord[$columnName];
				}	
			}
			$Db->setTable($formerTable);
			return $colums;
		}
				
		
		public function jsonToArray($data)
		{
			$result = [];
			foreach ($data as $values) {
				foreach ($values as $key => $datum) {
					$result[] = $datum;
				}
			}
			return $result;
		}

		public function progress($progress){
			$score = 0;
			for ($i=0; $i < count($progress); $i++) {
				if ($progress[$i] || $progress[$i] === 0) { 
				//if ($progress[$i]) {
					$score = $score + 1;
				}
			}
			return $score;
		}
		public function profileCompletion($score, $total)
		{
			$completion = $score/$total;
			$completion = $completion * 100;
			return $completion;
		}
		
		/**
		 * check if vendor id and review id are valid
		 * @param integer $vendorID then vendor id
		 * @param integer $reviewID the review id
		 * @param PDOHandler an instance of PDOHandler
		 * @return boolean $validIDs
		 */
		public static function validIDs($vendorID, $reviewID, PDOHandler $Pdo){
			$Db = new DBHandler($Pdo, "review", __FILE__);
			if($Db->iRetrieveData(__LINE__, ['id'=>$reviewID, 'vendor_id'=>$vendorID])){
				$validIDs = true;		
			}
			else {
				$validIDs = false;
			}
			return $validIDs;
		}
		
		/**
		 * Get the officer to show info based on the officer authority
		 * @param string $right the officer authority
		 * @return string $show the officer show string
		 */
		public static function getViewer($right){
			switch ($right) {
				case 'review officer':
					$show = 'review_officer_show';
				break;   
				case 'supervising officer':
					$show = 'supervising_officer_show';
				break;
				case 'deputy manager':
					$show = 'deputy_manager_show';
				break;
				case 'manager':
					$show = 'manager_show';
				break;
			}
			return $show;
		}
		
		/**
		 * Used to created list(HTML structure) of review of audit and questionnaire
		 * @param array $review list of the reviewers and their performed action
		 * @param Users $AUser an instance of the Users classs
		 * @param boolean $question if the review is for questionnaire or audit
		 * @param boolean $reason if the reason for reveiw rejection should be display 
		 * @return string $reveiwers the list (an HTML structure)
		 */
		public static function getReviewers($review, Users $AUser, $question = true, $reason = false){
			$reviewer['name'] = $supervisor['name'] = $dm['name'] = $manager['name'] ="";
			if(isset($review['review_officer_id']) && $review['review_officer_id']) $reviewer = $AUser->userDetails($AUser->getEmailFrmID($review['review_officer_id']));
			if($review['supervising_officer_id']) $supervisor = $AUser->userDetails($AUser->getEmailFrmID($review['supervising_officer_id']));
			if($review['deputy_manager_id']) $dm = $AUser->userDetails($AUser->getEmailFrmID($review['deputy_manager_id']));
			if($review['manager_id']) $manager = $AUser->userDetails($AUser->getEmailFrmID($review['manager_id']));			
			$supervisorDate = (strtotime($review['supervising_officer_date']))? date("jS M'y", strtotime($review['supervising_officer_date'])) : "";
			$dmDate = (strtotime($review['deputy_manager_date']))? date("jS M'y", strtotime($review['deputy_manager_date'])) : "";
			$managerDate = (strtotime($review['manager_date']))? date("jS M'y", strtotime($review['manager_date'])) : "";
			
			$supervisorReason = ($reason)? "<span><strong>Reason: </strong>{$review['supervising_officer_reason']}</span>":"";
			$dMgrReason = ($reason)? "<span><strong>Reason: </strong>{$review['deputy_manager_reason']}</span>":"";
			$mgrReason = ($reason)? "<span><strong>Reason: </strong>{$review['manager_reason']}</span>":"";
			$reviewerOfficerSection = "";
			if($question){
				$reviewDate = (strtotime($review['review_officer_date']))? date("jS M'y", strtotime($review['review_officer_date'])) : "";
				$reviewOfficerReason = ($reason)? "<span><strong>Reason: </strong>{$review['review_officer_reason']}</span>":"";
				$reviewerOfficerSection ="
					<span><strong>Reviewer: </strong>{$reviewer['name']}</span>
					<span><strong>Action: </strong>{$review['review_officer_action']}</span>
					$reviewOfficerReason
					<span class='al_last_reviewer'><strong>Date: </strong>$reviewDate</span>
				";
			}
			$reveiwers = "
				<div class='al_reviewer'>
					$reviewerOfficerSection
					
					<span><strong>Supervisor: </strong>{$supervisor['name']}</span>
					<span><strong>Action: </strong>{$review['supervising_officer_action']}</span>
					$supervisorReason
					<span class='al_last_reviewer'><strong>Date: </strong>$supervisorDate</span>
					
					<span><strong>Deputy Manager: </strong>{$dm['name']}</span>
					<span><strong>Action: </strong>{$review['deputy_manager_action']}</span>
					$dMgrReason
					<span class='al_last_reviewer'><strong>Date: </strong>$dmDate</span>
					
					<span><strong>Manager: </strong>{$manager['name']}</span>
					<span><strong>Action: </strong>{$review['manager_action']}</span>
					$mgrReason
					<span class='al_last_reviewer'><strong>Date: </strong>$managerDate</span>
				</div>";
			return $reveiwers;
		}
		
	}