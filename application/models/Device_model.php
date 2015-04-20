<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Device_model extends CI_Model {

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
		$sql = 'SELECT `ID`, `modelID`, `supplyID`, `field`, `info`, `img`, `spec`, `schedule`, `contract`, `memo`, `online` FROM `device`';
		return $this->db->query($sql)->result_array();
	}

	/**
	 * Update a device
	 * @param 	array $row
	 * @return 	bool
	 */
	public function update($row)
	{
		$sql = 'UPDATE `device` SET `modelID`=?, `supplyID`=?, `field`=?, `info`=?, `img`=?, `spec`=?, `schedule`=?, `contract`=?, `memo`=?, `online`=? WHERE `ID` = ?';
		$data = [$row['modelID'], $row['supplyID'], $row['field'], $row['info'], $row['img'], $row['spec'], $row['schedule'], $row['contract'], $row['memo'], $row['online'], $row['ID']];
		return $this->db->query($sql, $data);
	}

	/**
	 * Save an device
	 * @param 	array $row
	 * @return 	bool
	 */
	public function save($row)
	{
		$sql = 'INSERT INTO `device`(`modelID`, `supplyID`, `field`, `info`, `img`, `spec`, `schedule`, `contract`, `memo`, `online`) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?)';
		$data = [$row['modelID'], $row['supplyID'], $row['field'], $row['info'], $row['img'], $row['spec'], $row['schedule'], $row['contract'], $row['memo'], $row['online']];
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

	public function checkout() {
		$device = [];
		$sql = 'SELECT `device`.`ID`, `supply`.`locale`, `supply`.`name` AS `supply`, `category`.`name` AS `category`, `model`.`name` AS `model`, `model`.`field`, `device`.`field` AS `subfield`, `device`.`info`, `model`.`img` AS `img`, `device`.`img` AS `subimg`, `model`.`spec` AS `spec`, `device`.`spec` AS `subspec`, `schedule` FROM `device` JOIN `supply` ON `device`.`supplyID` = `supply`.`ID` AND `device`.`online` = 1 JOIN `model` ON `device`.`modelID` = `model`.`ID` JOIN `category` ON `model`.`categoryID` = `category`.`ID`';

		$deviceList = $this->db->query($sql)->result_array();

		foreach ($deviceList as $row) {
			$row['field']  = array_merge(json_decode($row['field'], TRUE), json_decode($row['subfield'], TRUE));
			$row['spec']  = array_merge(json_decode($row['spec'], TRUE), json_decode($row['subspec'], TRUE));
			if ($row['subimg']) {
				$row['img'] = $row['subimg'];
			}
			$row['schedule'] = json_decode($row['schedule'], TRUE);
			unset($row['subfield']);
			unset($row['subspec']);
			unset($row['subimg']);
			$device[$row['ID']] = $row;
		}

		return $device;
	}

	public function schedule($ID) {
		$sql = 'SELECT `schedule` FROM `device` WHERE `ID` = ?';
		$schedule = $this->db->query($sql, $ID)->row_array()['schedule'];

		return json_decode($schedule, TRUE);
	}

	public function info($ID) {
		$sql = 'SELECT `modelID`, `supplyID`, `field`, `info`, `img`, `spec`, `schedule`, `contract`, `memo`, `online` FROM `device` WHERE `ID` = ?';
		return $this->db->query($sql, $ID)->row_array();
	}

	public function textInfo($ID) {
		$sql = 'SELECT `model`.`name` AS `model`, `category`.`name` AS `category`, `supply`.`name` AS `supply`, `supply`.`email` AS `supplyEmail` FROM `device` JOIN `model` ON `modelID` = `model`.`ID` AND `device`.`ID` = ? JOIN `category` ON `categoryID` = `category`.`ID` JOIN `supply` ON `supplyID` = `supply`.`ID`';
		return $this->db->query($sql, $ID)->row_array();
	}
}
