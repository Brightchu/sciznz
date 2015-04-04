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
		$sql = 'SELECT `ID`, `modelID`, `supplyID`, `city`, `location`, `address`, `price`, `unit`, `field`, `info`, `credit`, `online` FROM `device`';
		return $this->db->query($sql)->result_array();
	}

	/**
	 * Update a device
	 * @param 	array $row
	 * @return 	bool
	 */
	public function update($row)
	{
		$sql = 'UPDATE `device` SET `modelID`=?, `supplyID`=?, `city`=?, `location`=?, `address`=?, `price`=?, `unit`=?, `field`=?, `info`=?, `credit`=?, `online`=? WHERE `ID` = ?';
		$data = array($row['modelID'], $row['supplyID'], $row['city'], $row['location'], $row['address'], $row['price'], $row['unit'], $row['field'], $row['info'], $row['credit'], $row['online'], $row['ID']);
		return $this->db->query($sql, $data);
	}

	/**
	 * Save an device
	 * @param 	array $row
	 * @return 	bool
	 */
	public function save($row)
	{
		$sql = 'INSERT INTO `device`(`modelID`, `supplyID`, `city`, `location`, `address`, `price`, `unit`, `field`, `info`, `credit`, `online`) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?)';
		$data = array($row['modelID'], $row['supplyID'], $row['city'], $row['location'], $row['address'], $row['price'], $row['unit'], $row['field'], $row['info'], $row['credit'], $row['online']);
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

	public function checkout()
	{
		$device = [];
		$sql = 'SELECT `device`.`ID`, `device`.`city`, `supply`.`name` AS `supply`, `device`.`address`, `device`.`capacity`, `category`.`name` AS `category`, `model`.`vendor`, `model`.`name` AS `model`, `device`.`price`, `device`.`unit`, `model`.`field`, `device`.`field` AS `subfield`, `device`.`info`, `device`.`credit` FROM `device` JOIN `supply` ON `device`.`supplyID` = `supply`.`ID` JOIN `model` ON `device`.`modelID` = `model`.`ID` JOIN `category` ON `model`.`categoryID` = `category`.`ID`';
		$deviceList = $this->db->query($sql)->result_array();

		foreach ($deviceList as $row) {
			$row['field']  = array_merge(json_decode($row['field'], TRUE), json_decode($row['subfield'], TRUE));
			unset($row['subfield']);
			$device[$row['ID']] = $row;
		}

		return $device;
	}

	public function address()
	{
		$sql = 'SELECT DISTINCT `address` FROM `device`';
		return array_column($this->db->query($sql)->result_array(), 'address');
	}
}
