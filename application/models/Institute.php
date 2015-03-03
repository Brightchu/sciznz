<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Institute extends CI_Model {

	public function __construct()
	{
		parent::__construct();
		$this->load->database();
	}

	/**
	 * Retrive all institute
	 * @return  array
	 */
	public function query()
	{
		$sql = 'SELECT `ID`, `chief`, `name`, `info` FROM `institute`';
		return $this->db->query($sql)->result_array();
	}

	/**
	 * Update a institute
	 * @param 	array $row
	 * @return 	bool
	 */
	public function update($row)
	{
		$sql = 'UPDATE `institute` SET `chief`=?, `name`=?, `info`=? WHERE `ID` = ?';
		$data = array($row['chief'], $row['name'], $row['info'], $row['ID']);
		return $this->db->query($sql, $data);
	}

	/**
	 * Save an institute
	 * @param 	array $row
	 * @return 	bool
	 */
	public function save($row)
	{
		$sql = 'INSERT INTO `institute`(`chief`, `name`, `info`) VALUES (?, ?, ?)';
		$data = array($row['chief'], $row['name'], $row['info']);
		return $this->db->query($sql, $data);
	}

	/**
	 * Delete an institute
	 * @param 	int $ID
	 * @return 	bool
	 */
	public function delete($ID)
	{
		$sql = 'DELETE FROM `institute` WHERE `ID` = ?';
		return $this->db->query($sql, $ID);
	}

}
