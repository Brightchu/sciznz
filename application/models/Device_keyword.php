<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Device_keyword extends CI_Model {

	public function __construct()
	{
		parent::__construct();
		$this->load->database();
	}

	/**
	 * Retrive all device_keyword
	 * @return  array
	 */
	public function query()
	{
		$sql = 'SELECT `ID`, `deviceID`, `name`, `rank` FROM `device_keyword`';
		return $this->db->query($sql)->result_array();
	}

	/**
	 * Update a device_keyword
	 * @param 	array $row
	 * @return 	bool
	 */
	public function update($row)
	{
		$sql = 'UPDATE `device_keyword` SET `deviceID`=?, `name`=?, `rank`=? WHERE `ID` = ?';
		$data = array($row['deviceID'], $row['name'], $row['rank'], $row['ID']);
		return $this->db->query($sql, $data);
	}

	/**
	 * Save an device_keyword
	 * @param 	array $row
	 * @return 	bool
	 */
	public function save($row)
	{
		$sql = 'INSERT INTO `device_keyword`(`deviceID`, `name`, `rank`) VALUES (?, ?, ?)';
		$data = array($row['deviceID'], $row['name'], $row['rank']);
		return $this->db->query($sql, $data);
	}

	/**
	 * Delete an device_keyword
	 * @param 	int $ID
	 * @return 	bool
	 */
	public function delete($ID)
	{
		$sql = 'DELETE FROM `device_keyword` WHERE `ID` = ?';
		return $this->db->query($sql, $ID);
	}

}
