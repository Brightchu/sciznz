<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Model_field extends CI_Model {

	public function __construct()
	{
		parent::__construct();
		$this->load->database();
	}

	/**
	 * Retrive all model_field
	 * @return  array
	 */
	public function query()
	{
		$sql = 'SELECT `ID`, `categoryID`, `name`, `value` FROM `model_field`';
		return $this->db->query($sql)->result_array();
	}

	/**
	 * Update a model_field
	 * @param 	array $row
	 * @return 	bool
	 */
	public function update($row)
	{
		$sql = 'UPDATE `model_field` SET `categoryID`=?, `name`=?, `value`=? WHERE `ID` = ?';
		$data = array($row['categoryID'], $row['name'], $row['value'], $row['ID']);
		return $this->db->query($sql, $data);
	}

	/**
	 * Save an model_field
	 * @param 	array $row
	 * @return 	bool
	 */
	public function save($row)
	{
		$sql = 'INSERT INTO `model_field`(`categoryID`, `name`, `value`) VALUES (?, ?, ?)';
		$data = array($row['categoryID'], $row['name'], $row['value']);
		return $this->db->query($sql, $data);
	}

	/**
	 * Delete an model_field
	 * @param 	int $ID
	 * @return 	bool
	 */
	public function delete($ID)
	{
		$sql = 'DELETE FROM `model_field` WHERE `ID` = ?';
		return $this->db->query($sql, $ID);
	}

}
