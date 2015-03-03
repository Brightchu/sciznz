<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Device_field extends CI_Model {

	public function __construct()
	{
		parent::__construct();
		$this->load->database();
	}

	/**
	 * Retrive all device_field
	 * @return  array
	 */
	public function query()
	{
		$sql = 'SELECT `ID`, `deviceID`, `name`, `value` FROM `device_field`';
		return $this->db->query($sql)->result_array();
	}

	/**
	 * Update a device_field
	 * @param 	array $row
	 * @return 	bool
	 */
	public function update($row)
	{
		$sql = 'UPDATE `device_field` SET `deviceID`=?, `name`=?, `value`=? WHERE `ID` = ?';
		$data = array($row['deviceID'], $row['name'], $row['value'], $row['ID']);
		return $this->db->query($sql, $data);
	}

	/**
	 * Save an device_field
	 * @param 	array $row
	 * @return 	bool
	 */
	public function save($row)
	{
		$sql = 'INSERT INTO `device_field`(`deviceID`, `name`, `value`) VALUES (?, ?, ?)';
		$data = array($row['deviceID'], $row['name'], $row['value']);
		return $this->db->query($sql, $data);
	}

	/**
	 * Delete an device_field
	 * @param 	int $ID
	 * @return 	bool
	 */
	public function delete($ID)
	{
		$sql = 'DELETE FROM `device_field` WHERE `ID` = ?';
		return $this->db->query($sql, $ID);
	}

}
