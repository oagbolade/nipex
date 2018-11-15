<?php
  /*
  require_once "../config.php";
  require_once "../db-config.php";
  */
  /**
   * DBHandler
   * 
   * A database implementation of IModel
   * @author      Alabi A. <alabi.adebayo@alabiansolutions.com>
   * @copyright   2017 Alabian Solutions Limited
	 * @version			1.0 => Sept 2017   1.1 => Mar 2018 1.2 => Sept 2018
   * @link        alabiansolutions.com
   */
  class DBHandler implements IModel{
    protected $_table;
    protected $_pdoHandle;
    
    /**
     * Setup up table on creation
     * @param string $pdoHandle an instancs of PDOHandler
     * @param string $table a table in the database
     * @param string $file the file where the object was instantiated
     */
    public function __construct(PDOHandler $pdoHandle, $table, $file){
      $this->_pdoHandle = $pdoHandle;
      $this->_table = $table;
      $this->_file = $file;
    }
		
		/**
		 * Retrieve the table DBWorker is using
		 * @return string $table the active table
		 */
		public function getTable(){
			return $this->_table;
		}
		
		/**
		 * Change the table DBWorker is using
		 * @param string $table the table name
     */
    public function setTable($table){
    	$this->_table = $table;
    }
   	
		/**
		 * Get the records from a table in the database
		 * @param string $query the sql statement to select data from the table 
		 * @param array $bindArray the values to bind with bind parameter
		 * @return mix $dataList an array of the data from the database if avaliable or false if no record
		 */
		public function dataList($line, $query, $bindArray=array()){
			$preparedSQL=$this->_pdoHandle->preparedSQL($query, $this->_file, $line);
			$bindParam=$bindArray;
			$result=$this->_pdoHandle->bindSelectSQL($preparedSQL, $bindParam, $this->_file, $line);
			if(count($result)){
				$dataList=$result;
			}
			else {
				$dataList=FALSE;
			}
			return $dataList;
		}
		
		/**
		 * Get the records from a table in the database better than dataList
		 * @param string $line the line of the file making the call 
		 * @param string $table the table in the database 
		 * @param string $where the where clause in an sql statement
		 * @param array $bindArray the array of bind data
		 * @return mix $dataList an array of the data from the database if avaliable or false if no record
		 */
		public function iDataList($line, $table, $where='WHERE 1', $bindArray=array()){
			$sql="SELECT * FROM $table $where";
			$preparedSQL=$this->_pdoHandle->preparedSQL($sql, $this->_file, $line);
			$bindParam=$bindArray;
			$result=$this->_pdoHandle->bindSelectSQL($preparedSQL, $bindParam, $this->_file, $line);
			if(count($result)){
				$dataList=$result;
			}
			else {
				$dataList=FALSE;
			}
			return $dataList;
		}
		
		/**
		 * Used to manipulate data in the database such as insert, update, delete and even complex select sql command
		 * @param string $query the sql statement to select data from the table 
		 * @param array $bindArray the values to bind with bind parameter
		 * @return array $affectedData an array that contains ['insertedID'=>row, 'affectedRows'=>row]
		 */
		public function dataManipulator($line, $query, $bindArray=array()){
			$preparedSQL=$this->_pdoHandle->preparedSQL($query, $this->_file, $line);
			$bindParam=$bindArray;
			$result=$this->_pdoHandle->bindInsertUpdateDeleteSQL($preparedSQL, $bindParam, $this->_file, $line);
			if($this->_pdoHandle->getLastInsertID()){
				$affectedData=array(
					'insertedID'=>$this->_pdoHandle->getLastInsertID(), 
					'affectedRows'=>$this->_pdoHandle->getNoAffectedRows());	
			}
			else {
				$affectedData=array(
					'insertedID'=>NULL, 
					'affectedRows'=>$this->_pdoHandle->getNoAffectedRows());
			}
			return $affectedData;
		}
		
    /**
     * Put data into a table in the database
     * @param string $line the line no where this method is called from
     * @param array $data an array that contains the data to inserted into the table
     * @return array $affectedData array of the insert data and affected row
     */
    public function createData($line, $data){
      $fields=""; $values="";
      foreach($data as $aDataKey=>$aDataValue){
        $fields.="$aDataKey, ";
        if(substr($aDataValue, -2)=="()"){
          $values.="$aDataValue, ";
        }
        else {
          $values.=":$aDataKey, ";
          $valueArray[$aDataKey]=$aDataValue;
        }
      }
      $fields=rtrim($fields, ", ");
      $values=rtrim($values, ", ");
      $sql="INSERT INTO ".$this->_table." ($fields) VALUES($values)";
      $affectedData=$this->dataManipulator($line, $sql, $valueArray);
      return $affectedData;
    }
    
    /**
     * Get data from a table in the database
     * @param array $key field for where clause [field=>val]
     * @param string $line the line no where this method is called from
     * @return mix $data the gotten data if successful or false if no record
     */
    public function retrieveData($line, $key=array()){
      if($key){
        foreach($key as $index=>$value){
          $where="WHERE $index=:$index";  
          $array=array("$index"=>$value);
        } 
      }
      else {
          $where="WHERE 1";  
          $array=array();
      }      
      $data = $this->iDataList($line, $this->_table, $where, $array);
      return $data;
    }
    
    /**
     * Get data from a table in the database using improved search criteria
		 * @param string $line the line no where this method is called from
     * @param array $criteria fields for where clause [field1=>val1,field2=>val2, ...fieldn=>valn]
     * @param array $fields fields being selected [field1,field2, ...fieldn]
		 * @param array $order ordering of record [field1=>'ASC',field2=>'DESC', ...]
     * @return mix $data the gotten data if successful or false if no record
     */
    public function iRetrieveData($line, $criteria=FALSE, $fields=FALSE, $order=false){
      $bindData=array();
      if($fields){
        $fieldsList="";
        foreach ($fields as $aFields) {
          $fieldsList.="$aFields, ";
        }
        $fieldsList=rtrim($fieldsList, ", ");
      }
      else {
        $fieldsList=" * ";
      }
      if($criteria){
        $where="";
        foreach ($criteria as $criteriaName => $criteriaValue) {
        	if($criteriaValue == 'IS NOT NULL' || $criteriaValue == 'IS NULL'){
        		$where.=(($where) ? "$criteriaName $criteriaValue AND ": "WHERE $criteriaName $criteriaValue AND ");
        	}
					else {
						$where.=(($where) ? "$criteriaName=:$criteriaName AND ": "WHERE $criteriaName=:$criteriaName AND ");
          	$bindData[$criteriaName]=$criteriaValue;
					}
        }
        $where=rtrim($where, "AND ");
      }
      else {
        $where="WHERE 1";
      }
			$orderBy = "";
			if($order && is_array($order)){
				$orderBy = "ORDER BY ";
				foreach ($order as $field => $ordering) {
					$orderBy .= "$field $ordering, ";
				}
				$orderBy = rtrim($orderBy, ", ");
			}
      $sql="SELECT $fieldsList FROM ".$this->_table." $where $orderBy";
      $data=$this->dataList($line, $sql, $bindData);
      return $data;  
    }
    
    /**
     * Update record(s) in a table in the database
     * @param string $line the line no where this method is called from
     * @param array $data an array that contains the data to be updated
     * @param array $key field for where clause [field=>val]
     * @return array $affectedData array of ['insertedID'=>row, 'affectedRows'=>row]
     */
    public function updateData($line, $data, $key){
      $modification="";
			$where = "WHERE ";
      foreach($key as $index=>$value){
        $where.="$index=:$index AND ";
        $valueArray["$index"]=$value;  
      }
			$where = rtrim($where, "AND ");
			
      foreach($data as $aDataKey=>$aDataValue){
        if(substr($aDataValue, -2)=="()"){
          $modification.="$aDataKey=$aDataValue, ";
        }
				elseif($aDataValue == 'NULL'){
					$modification.="$aDataKey=$aDataValue, ";
				}
        else {
          $modification.="$aDataKey=:$aDataKey, ";
          $valueArray[$aDataKey]=$aDataValue;
        }
      }
      $modification=rtrim($modification, ", ");
      $sql="UPDATE ".$this->_table." SET $modification $where";
      $affectedData=$this->dataManipulator($line, $sql, $valueArray);
      return $affectedData;
    }
    
    /**
     * Update record(s) from a table in the database
     * @param integer $line the line no where this method is called from
     * @param array $key the search column
     * @return array $affectedData array of ['insertedID'=>row, 'affectedRows'=>row]
     */
    public function deleteData($line, $key){
      foreach($key as $index=>$value){
        $where="WHERE $index=:$index";
        $valueArray["$index"]=$value;  
      }
      $sql="DELETE FROM ".$this->_table." $where";
      $affectedData=$this->dataManipulator($line, $sql, $valueArray);
      return $affectedData;
    }
  }  