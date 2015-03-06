<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Model extends CI_Model {

	public function __construct()
	{
		parent::__construct();
		$this->load->database();
	}

	/**
	 * Retrive all model
	 * @return  array
	 */
	public function query()
	{
		$sql = 'SELECT `ID`, `categoryID`, `vendor`, `name`, `info` FROM `model`';
		return $this->db->query($sql)->result_array();
	}

	/**
	 * Update a model
	 * @param 	array $row
	 * @return 	bool
	 */
	public function update($row)
	{
		$sql = 'UPDATE `model` SET `categoryID`=?, `vendor`, `name`=?, `info`=? WHERE `ID` = ?';
		$data = array($row['categoryID'], $row['vendor'], $row['name'], $row['info'], $row['ID']);
		return $this->db->query($sql, $data);
	}

	/**
	 * Save an model
	 * @param 	array $row
	 * @return 	bool
	 */
	public function save($row)
	{
		$sql = 'INSERT INTO `model`(`categoryID`, `vendor`, `name`, `info`) VALUES (?, ?, ?, ?)';
		$data = array($row['categoryID'], $row['vendor'], $row['name'], $row['info']);
		return $this->db->query($sql, $data);
	}

	/**
	 * Delete an model
	 * @param 	int $ID
	 * @return 	bool
	 */
	public function delete($ID)
	{
		$sql = 'DELETE FROM `model` WHERE `ID` = ?';
		return $this->db->query($sql, $ID);
	}

}
