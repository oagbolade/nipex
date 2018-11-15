<?php
  /**
   * IModel
   * 
   * An interface for implementation of CRUD operation
   * @author      Alabi A. <alabi.adebayo@alabiansolutions.com>
   * @copyright   2017 Alabian Solutions Limited
	 * @version 		1.0 => Sept 2017   1.1 => Mar 2018
   * @link        alabiansolutions.com
   */
  interface IModel{
    public function createData($data, $line);
    public function retrieveData($line, $id);
    public function iRetrieveData($line, $criteria, $fields);
    public function updateData($line, $data, $key);
    public function deleteData($line, $key);
  }
