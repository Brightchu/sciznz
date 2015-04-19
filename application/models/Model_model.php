<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Model_model extends CI_Model {

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
		$sql = 'SELECT `ID`, `categoryID`, `name`, `field`, `img`, `spec` FROM `model`';
		return $this->db->query($sql)->result_array();
	}

	/**
	 * Update a model
	 * @param 	array $row
	 * @return 	bool
	 */
	public function update($row)
	{
		$sql = 'UPDATE `model` SET `categoryID`=?, `name`=?, `field`=?, `img`=?, `spec`=? WHERE `ID` = ?';
		$data = [$row['categoryID'], $row['name'], $row['field'], $row['img'], $row['spec'], $row['ID']];
		return $this->db->query($sql, $data);
	}

	/**
	 * Save an model
	 * @param 	array $row
	 * @return 	bool
	 */
	public function save($row)
	{
		$sql = 'INSERT INTO `model`(`categoryID`, `name`, `field`, `img`, `spec`) VALUES (?, ?, ?, ?, ?)';
		$data = [$row['categoryID'], $row['name'], $row['field'], $row['img'], $row['spec']];
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
