<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Category_keyword extends CI_Model {

	public function __construct()
	{
		parent::__construct();
		$this->load->database();
	}

	/**
	 * Retrive all category_keyword
	 * @return  array
	 */
	public function query()
	{
		$sql = 'SELECT `ID`, `categoryID`, `name`, `rank` FROM `category_keyword`';
		return $this->db->query($sql)->result_array();
	}

	/**
	 * Update a category_keyword
	 * @param 	array $row
	 * @return 	bool
	 */
	public function update($row)
	{
		$sql = 'UPDATE `category_keyword` SET `categoryID`=?, `name`=?, `rank`=? WHERE `ID` = ?';
		$data = array($row['categoryID'], $row['name'], $row['rank'], $row['ID']);
		return $this->db->query($sql, $data);
	}

	/**
	 * Save an category_keyword
	 * @param 	array $row
	 * @return 	bool
	 */
	public function save($row)
	{
		$sql = 'INSERT INTO `category_keyword`(`categoryID`, `name`, `rank`) VALUES (?, ?, ?)';
		$data = array($row['categoryID'], $row['name'], $row['rank']);
		return $this->db->query($sql, $data);
	}

	/**
	 * Delete an category_keyword
	 * @param 	int $ID
	 * @return 	bool
	 */
	public function delete($ID)
	{
		$sql = 'DELETE FROM `category_keyword` WHERE `ID` = ?';
		return $this->db->query($sql, $ID);
	}

}
