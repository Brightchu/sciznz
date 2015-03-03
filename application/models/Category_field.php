<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Category_field extends CI_Model {

	public function __construct()
	{
		parent::__construct();
		$this->load->database();
	}

	/**
	 * Retrive all category_field
	 * @return  array
	 */
	public function query()
	{
		$sql = 'SELECT `ID`, `categoryID`, `name`, `rank` FROM `category_field`';
		return $this->db->query($sql)->result_array();
	}

	/**
	 * Update a category_field
	 * @param 	array $row
	 * @return 	bool
	 */
	public function update($row)
	{
		$sql = 'UPDATE `category_field` SET `categoryID`=?, `name`=?, `rank`=? WHERE `ID` = ?';
		$data = array($row['categoryID'], $row['name'], $row['rank'], $row['ID']);
		return $this->db->query($sql, $data);
	}

	/**
	 * Save an category_field
	 * @param 	array $row
	 * @return 	bool
	 */
	public function save($row)
	{
		$sql = 'INSERT INTO `category_field`(`categoryID`, `name`, `rank`) VALUES (?, ?, ?)';
		$data = array($row['categoryID'], $row['name'], $row['rank']);
		return $this->db->query($sql, $data);
	}

	/**
	 * Delete an category_field
	 * @param 	int $ID
	 * @return 	bool
	 */
	public function delete($ID)
	{
		$sql = 'DELETE FROM `category_field` WHERE `ID` = ?';
		return $this->db->query($sql, $ID);
	}

}
