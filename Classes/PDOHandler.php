<?php
/*	
	  require_once "../config.php";
	  require_once "../db-config.php";
*/	
	/**
	 * PDOHandler
	 * 
	 * This class is used to interact with MySQL database. It is built on PDO extension.
	 * @author			Alabi A. <alabi.adebayo@alabiansolutions.com>
	 * @copyright		2014 Alabian Solutions Limited
	 * @version			1.1=>Mar 2018, 1.0 => 2014
	 * @link 				alabiansolutions.com
	 */
	class PDOHandler {
		protected $_dbConnector;
		protected $_errorPage;
		protected $_rows;
		protected $_lastInsertAble;
		
		/**
		 * Setup a Successful Database Connection on creation of an object from this class
     * @param string $connection an instant of PDO
     * @param string $errorPage the error page's url
		 */
		public function __construct(PDO $connection, $errorPage){
			$this->_errorPage=$errorPage;
		    $this->_dbConnector=$connection;
		}
		
		/**
		 * The destructor is used to close the database connection
		 */
		public function __destruct(){
	  	$this->_dbConnector=NULL;
		}
		
		/**
		 * Retrieve the error page's url where app user are directed to when there is database related error
		 * @return	string
		 */
		public function getErrorPage(){
			return $this->_errorPage;
		}
		
		/**
		 * Prepared select data SQL statement
		 * @param string $sql the SQL statment to be prepared
		 * @param string $file the file from which this method was called 
		 * @param string $line the line no on the file from which this method was called 
		 * @return string $preparedStmt the sql statment that has been prepared 
		 */
		public function preparedSQL($sql, $file, $line){
	  	try{
	    	$preparedStmt = $this->_dbConnector->prepare($sql);
	      }
	      catch (PDOException $e){
	        $_SESSION['error']=$e->getMessage(). " in $file on line $line ";
		    	header("Location: $this->_errorPage/");
		    	exit();
		  	}
				return $preparedStmt;
	    }
		
		/**
		 * Bind prepared select statement to value
		 * @param string $stmt the PDOStatement to be binded
		 * @param array $bind is optional, it is an assocative array that contains value to be binded to the prepared SQL statment
		 * @param string $file the file from which this method was called 
		 * @param string $line the line no on the file from which this method was called
		 * @return array $selectedRows a 2 dimensional array of selected data from database  
		 */
		public function bindSelectSQL(PDOStatement $stmt, $bind="", $file, $line){
	  	if($stmt){
	  		if($bind!=""){
	  	  	foreach($bind as $key=>&$aBind){
	        	$stmt->bindParam($key, $aBind);
	        }
	  	  }
		 		$result = $stmt->execute();
	      if($result){
	      	$selectedRows=$stmt->fetchAll(PDO::FETCH_ASSOC);
				}
				else {
			  	$error=$stmt->errorInfo();
		      $_SESSION['error']="{$error[2]} in $file on line $line";
		      //header("Location: $errorPage/");
		      header("Location: $this->_errorPage");
	    		exit();
		  	}
	    }
			else{
		  	$_SESSION['error']="Prepared Select Query failed in $file on line $line ";
		    header("Location: $this->_errorPage");
	    	exit();
			}
			$stmt->closeCursor();
    	return $selectedRows;
    }

		/**
		 * Bind prepared insert, update or delete statement to value
		 * @param string $stmt the SQL statment to be binded
		 * @param array $bind is optional, it is an assocative array that contains value to be binded to the prepared SQL statment
		 * @param string $file the file from which this method was called 
		 * @param string $line the line no on the file from which this method was called
		 * @return array $selectedRows an 2 dimensional array of selected data from database  
		 */
		public function bindInsertUpdateDeleteSQL(PDOStatement $stmt, $bind="", $file, $line){
	  	if($stmt){
	  		if($bind!=""){
	  	  	foreach($bind as $key=>&$aBind){
	        	$stmt->bindParam($key, $aBind);
	        }
	  	  }
		 		$result = $stmt->execute();
	      	if(!$result){
	      		$error=$stmt->errorInfo();
		      	$_SESSION['error']="{$error[2]} in $file on line $line ";
		      	header("Location: $this->_errorPage/");
	    		exit();
				}	    }
			else{
		  		$_SESSION['error']="Prepared Insert, Update or Delete Query failed in $file on line $line ";
		    	header("Location: $this->_errorPage/");
	    		exit();
			}
			$this->_lastInsertAble=TRUE;
			$this->_rows=$stmt->rowCount();
			$stmt->closeCursor();
    	}
		
		/**
		 * Get the nos of record affected after a insert or update or delete query
		 * @return integer $_rows the numbers of affected rows or FALSE on failure 
		 */
		public function getNoAffectedRows(){
	  	if(isset($this->_rows)){
	  		return $this->_rows;	
	  	}
			else {
				return FALSE;
			}
		}
		
		/**
		 * Get the ID of the last insert record/row
		 * @return integer the ID of the latest insert record or FALSE on failure 
		 */
		public function getLastInsertID(){
			if($this->_lastInsertAble){
	  		return $this->_dbConnector->lastInsertId(); 	
	  	}
			else {
				return FALSE;
			}
		}
	}

/*
//Test insert data
$sql="INSERT INTO logger(username, email, password, authority, status, date) 
VALUES (:username, :email, :password, :authority, :status, :dated)";
$date = date("Y-m-d");
$preparedSQL=$db->preparedSQL($sql, __FILE__, __LINE__);
$bindParam=array(
'username'=>'nikky', 'email'=>'nikky.pakunle@alabiansolutions.com', 'password'=>'nikky', 'authority'=>'pre-vendor', 'status'=>'inactive', "dated"=>$date
);

$result=$db->bindInsertUpdateDeleteSQL($preparedSQL, $bindParam, __FILE__, __LINE__);

if($db->getNoAffectedRows()){
	echo "The nos of inserted data ".$db->getNoAffectedRows()."<br/>";
}
else {
	echo "No inserted data"."<br/>";		
}
if($db->getLastInsertID()){
	echo "The ID of the last inserted data ".$db->getLastInsertID()."<br/>";
}
else {
	echo "No inserted data so no ID"."<br/>";		
}

*/