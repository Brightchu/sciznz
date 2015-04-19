<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Category_model extends CI_Model {

	public function __construct()
	{
		parent::__construct();
		$this->load->database();
	}

	/**
	 * Retrive all category
	 * @return  array
	 */
	public function query()
	{
		$sql = 'SELECT `ID`, `name`, `field` FROM `category`';
		return $this->db->query($sql)->result_array();
	}

	/**
	 * Update a category
	 * @param 	array $row
	 * @return 	bool
	 */
	public function update($row)
	{
		$sql = 'UPDATE `category` SET `name`=?, `field`=? WHERE `ID` = ?';
		$data = [$row['name'], $row['field'], $row['ID']];
		return $this->db->query($sql, $data);
	}

	/**
	 * Save an category
	 * @param 	array $row
	 * @return 	bool
	 */
	public function save($row)
	{
		$sql = 'INSERT INTO `category`(`name`, `field`) VALUES (?, ?)';
		$data = [$row['name'], $row['field'], $row['info']];
		return $this->db->query($sql, $data);
	}

	/**
	 * Delete an category
	 * @param 	int $ID
	 * @return 	bool
	 */
	public function delete($ID)
	{
		$sql = 'DELETE FROM `category` WHERE `ID` = ?';
		return $this->db->query($sql, $ID);
	}

	public function field()
	{
		$sql = 'SELECT `name`, `field` FROM `category`';
		$result = $this->db->query($sql)->result_array();

		$field = [];
		foreach ($result as $row) {
			$field[$row['name']] = json_decode($row['field'], TRUE);
		}

		return $field;
	}
}
