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
		$sql = 'SELECT `ID`, `modelID`, `name`, `value` FROM `model_field`';
		return $this->db->query($sql)->result_array();
	}

	/**
	 * Update a model_field
	 * @param 	array $row
	 * @return 	bool
	 */
	public function update($row)
	{
		$sql = 'UPDATE `model_field` SET `modelID`=?, `name`=?, `value`=? WHERE `ID` = ?';
		$data = array($row['modelID'], $row['name'], $row['value'], $row['ID']);
		return $this->db->query($sql, $data);
	}

	/**
	 * Save an model_field
	 * @param 	array $row
	 * @return 	bool
	 */
	public function save($row)
	{
		$sql = 'INSERT INTO `model_field`(`modelID`, `name`, `value`) VALUES (?, ?, ?)';
		$data = array($row['modelID'], $row['name'], $row['value']);
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
