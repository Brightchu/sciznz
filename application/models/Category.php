<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Category extends CI_Model {

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
		$sql = 'SELECT `ID`, `name`, `field`, `info` FROM `category`';
		return $this->db->query($sql)->result_array();
	}

	/**
	 * Update a category
	 * @param 	array $row
	 * @return 	bool
	 */
	public function update($row)
	{
		$sql = 'UPDATE `category` SET `name`=?, `field`=?, `info`=? WHERE `ID` = ?';
		$data = array($row['name'], $row['field'], $row['info'], $row['ID']);
		return $this->db->query($sql, $data);
	}

	/**
	 * Save an category
	 * @param 	array $row
	 * @return 	bool
	 */
	public function save($row)
	{
		$sql = 'INSERT INTO `category`(`name`, `field`, `info`) VALUES (?, ?, ?)';
		$data = array($row['name'], $row['field'], $row['info']);
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

}
