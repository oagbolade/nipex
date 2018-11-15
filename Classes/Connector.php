<?php
/*
  require_once "../config.php";
  require_once "../db-config.php";
*/
  /**
   * Connector
   * 
   * This class is used to connect to MySQL database. It is built on PDO extension.
   * @author      Alabi A. <alabi.adebayo@alabiansolutions.com>
   * @copyright   2017 Alabian Solutions Limited
   * @link        alabiansolutions.com
   */
   class Connector{
     public $host;
     public $username;
     public $password;
     public $database;
     public $errorPage;
     
    /**
     * Setup the error page on instantiation of an object from this class
     * @param string $errorPage the error page's url 
     */
     public function __construct($errorPage){
       $this->errorPage=$errorPage;
     }
     
    /**
     * Generate the database connection handle
     * @return resource $connectionHandle the database connection handle 
     */
     public function doConnect(){
       try{
        $connectionHandle = new PDO("mysql:host={$this->host};dbname={$this->database}",$this->username, $this->password);
        }
        catch (PDOException $e){
          $_SESSION['error']=$e->getMessage()." in ".__FILE__." on line ".__LINE__;
          header("Location: {$this->errorPage}");
          exit();
        }
        return $connectionHandle;
     }
     
   }
/*
$connector = new Connector(ERRORPAGE);
var_dump($connector->doConnect());
*/