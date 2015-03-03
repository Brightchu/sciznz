<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Model_keyword extends CI_Model {

	public function __construct()
	{
		parent::__construct();
		$this->load->database();
	}

	/**
	 * Retrive all model_keyword
	 * @return  array
	 */
	public function query()
	{
		$sql = 'SELECT `ID`, `categoryID`, `name`, `weight` FROM `model_keyword`';
		return $this->db->query($sql)->result_array();
	}

	/**
	 * Update a model_keyword
	 * @param 	array $row
	 * @return 	bool
	 */
	public function update($row)
	{
		$sql = 'UPDATE `model_keyword` SET `categoryID`=?, `name`=?, `weight`=? WHERE `ID` = ?';
		$data = array($row['categoryID'], $row['name'], $row['weight'], $row['ID']);
		return $this->db->query($sql, $data);
	}

	/**
	 * Save an model_keyword
	 * @param 	array $row
	 * @return 	bool
	 */
	public function save($row)
	{
		$sql = 'INSERT INTO `model_keyword`(`categoryID`, `name`, `weight`) VALUES (?, ?, ?)';
		$data = array($row['categoryID'], $row['name'], $row['weight']);
		return $this->db->query($sql, $data);
	}

	/**
	 * Delete an model_keyword
	 * @param 	int $ID
	 * @return 	bool
	 */
	public function delete($ID)
	{
		$sql = 'DELETE FROM `model_keyword` WHERE `ID` = ?';
		return $this->db->query($sql, $ID);
	}

}
