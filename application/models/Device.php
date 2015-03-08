<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Device extends CI_Model {

	public function __construct()
	{
		parent::__construct();
		$this->load->database();
	}

	/**
	 * Retrive all device
	 * @return  array
	 */
	public function query()
	{
		$sql = 'SELECT `ID`, `modelID`, `instituteID`, `city`, `location`, `address`, `price`, `unit`, `field`, `info`, `credit`, `online` FROM `device`';
		return $this->db->query($sql)->result_array();
	}

	/**
	 * Update a device
	 * @param 	array $row
	 * @return 	bool
	 */
	public function update($row)
	{
		$sql = 'UPDATE `device` SET `modelID`=?, `instituteID`=?, `city`=?, `location`=?, `address`=?, `price`=?, `unit`=?, `field`=?, `info`=?, `credit`=?, `online`=? WHERE `ID` = ?';
		$data = array($row['modelID'], $row['instituteID'], $row['city'], $row['location'], $row['address'], $row['price'], $row['unit'], $row['field'], $row['info'], $row['credit'], $row['online'], $row['ID']);
		return $this->db->query($sql, $data);
	}

	/**
	 * Save an device
	 * @param 	array $row
	 * @return 	bool
	 */
	public function save($row)
	{
		$sql = 'INSERT INTO `device`(`modelID`, `instituteID`, `city`, `location`, `address`, `price`, `unit`, `field`, `info`, `credit`, `online`) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?)';
		$data = array($row['modelID'], $row['instituteID'], $row['city'], $row['location'], $row['address'], $row['price'], $row['unit'], $row['field'], $row['info'], $row['credit'], $row['online']);
		return $this->db->query($sql, $data);
	}

	/**
	 * Delete an device
	 * @param 	int $ID
	 * @return 	bool
	 */
	public function delete($ID)
	{
		$sql = 'DELETE FROM `device` WHERE `ID` = ?';
		return $this->db->query($sql, $ID);
	}

}
