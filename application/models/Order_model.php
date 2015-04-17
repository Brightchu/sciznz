<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Order_model extends CI_Model {

	public function __construct() {
		parent::__construct();
		$this->load->database();
	}

	/**
	 * Create an order
	 * @param 	$userID, $deviceID, $date, $resource
	 * @return  bool
	 */
	public function create($userID, $deviceID, $method, $date, $resource, $budget) {
		if ($method === 'RESOURCE') {
			$sql = 'INSERT INTO `usage`(`deviceID`, `type`, `date`, `resource`) VALUES (?, "ORDER", ?, ?)';
			$result = $this->db->query($sql, [$deviceID, $date, $resource]);

			if ($result) {
				$usageID = $this->db->insert_id();
				$sql = 'INSERT INTO `order`(`userID`, `deviceID`, `detail`, `method`, `usageID`, `budget`) VALUES (?, ?, "{}", "RESOURCE", ?, ?)';
				return $this->db->query($sql, [$userID, $deviceID, $usageID, $budget]);
			}
		}

		if ($method === 'UNLIMITED') {
			$sql = 'INSERT INTO `order`(`userID`, `deviceID`, `detail`, `method`) VALUES (?, ?, "{}", "UNLIMITED")';
			return $this->db->query($sql, [$userID, $deviceID]);
		}

		return FALSE;
	}

	/**
	 * Update status of an order
	 * @param 	$ID, $status
	 * @return  bool
	 */
	public function status($ID, $status) {
		$sql = 'UPDATE `order` SET `status` = ? WHERE `ID` = ?';
		return $this->db->query($sql, [$status, $ID]);
	}

	public function info($ID) {
		$sql = 'SELECT `userID`, `deviceID`, `date`, `status`, `detail`, `method`, `usageID`, `budget`, `budgetID`, `fill`, `fillID` FROM `order` WHERE `ID` = ?';
		return $this->db->query($sql, $ID)->row_array();
	}

	public function budget($ID, $budgetID) {
		$sql = 'UPDATE `order` SET `status` = "BUDGET", `budgetID` = ? WHERE `ID` = ?';
		return $this->db->query($sql, [$budgetID, $ID]);
	}

	public function end($ID, $fill, $detail) {
		$sql = 'UPDATE `order` SET `status` = "END", `detail` = ?, `fill` = ? WHERE `ID` = ?';
		return $this->db->query($sql, [$detail, $fill, $ID]);
	}

	public function fill($ID, $fillID) {
		$sql = 'UPDATE `order` SET `status` = "DONE", `fillID` = ? WHERE `ID` = ?';
		return $this->db->query($sql, [$fillID, $ID]);
	}

	public function cancel($ID) {
		$sql = 'UPDATE `order` SET `status` = "CANCEL", `usageID` = 0, `budgetID` = 0, `fillID` = 0 WHERE `ID` = ?';
		return $this->db->query($sql, $ID);
	}

	public function userActive($userID) {
		$sql = 'SELECT `order`.`ID`, `category`.`name` AS `category`, `model`.`name` AS `model`, `device`.`ID` AS `deviceID`, `supply`.`name` AS `supply`, `order`.`date`, `usage`.`date` AS `useDate`, `usage`.`resource`, `status`, `detail`, `budget`, `fill` FROM `order` JOIN `device` ON `userID` = ? AND (`status` != "DONE" AND `status` != "CANCEL") AND `order`.`deviceID` = `device`.`ID` JOIN `model` ON `device`.`modelID` = `model`.`ID` JOIN `category` ON `model`.`categoryID` = `category`.`ID` JOIN `supply` ON `device`.`supplyID` = `supply`.`ID` JOIN `usage` ON `order`.`usageID` = `usage`.`ID`';
		return $this->db->query($sql, $userID)->result_array();
	}

	public function userDone($userID) {
		$sql = 'SELECT `order`.`ID`, `category`.`name` AS `category`, `model`.`name` AS `model`, `device`.`ID` AS `deviceID`, `supply`.`name` AS `supply`, `order`.`date`, `usage`.`date` AS `useDate`, `usage`.`resource`, `status`, `detail`, `budget`, `fill` FROM `order` JOIN `device` ON `userID` = ? AND (`status` = "DONE" OR `status` = "CANCEL") AND `order`.`deviceID` = `device`.`ID` JOIN `model` ON `device`.`modelID` = `model`.`ID` JOIN `category` ON `model`.`categoryID` = `category`.`ID` JOIN `supply` ON `device`.`supplyID` = `supply`.`ID` LEFT JOIN `usage` ON `order`.`usageID` = `usage`.`ID`';
		return $this->db->query($sql, $userID)->result_array();
	}

	public function supplyActive($supplyID) {
		$sql = 'SELECT `order`.`ID`, `category`.`name` AS `category`, `model`.`name` AS `model`, `device`.`ID` AS `deviceID`, `order`.`date`, `usage`.`date` AS `useDate`, `usage`.`resource`, `status`, `detail`, `budget`, `fill` FROM `order` JOIN `device` ON `supplyID` = ? AND (`status` != "DONE" AND `status` != "CANCEL") AND `order`.`deviceID` = `device`.`ID` JOIN `model` ON `device`.`modelID` = `model`.`ID` JOIN `category` ON `model`.`categoryID` = `category`.`ID` JOIN `usage` ON `order`.`usageID` = `usage`.`ID`';
		return $this->db->query($sql, $supplyID)->result_array();
	}

	public function supplyDone($supplyID) {
		$sql = 'SELECT `order`.`ID`, `category`.`name` AS `category`, `model`.`name` AS `model`, `device`.`ID` AS `deviceID`, `order`.`date`, `usage`.`date` AS `useDate`, `usage`.`resource`, `status`, `detail`, `budget`, `fill` FROM `order` JOIN `device` ON `supplyID` = ? AND (`status` = "DONE" OR `status` = "CANCEL") AND `order`.`deviceID` = `device`.`ID` JOIN `model` ON `device`.`modelID` = `model`.`ID` JOIN `category` ON `model`.`categoryID` = `category`.`ID` JOIN `usage` ON `order`.`usageID` = `usage`.`ID`';
		return $this->db->query($sql, $supplyID)->result_array();
	}

	public function helperActive() {
		$sql = 'SELECT `order`.`ID`, `category`.`name` AS `category`, `model`.`name` AS `model`, `device`.`ID` AS `deviceID`, `order`.`date`, `usage`.`date` AS `useDate`, `usage`.`resource`, `status`, `detail`, `budget`, `fill` FROM `order` JOIN `device` ON (`status` != "DONE" AND `status` != "CANCEL") AND `order`.`deviceID` = `device`.`ID` JOIN `model` ON `device`.`modelID` = `model`.`ID` JOIN `category` ON `model`.`categoryID` = `category`.`ID` JOIN `usage` ON `order`.`usageID` = `usage`.`ID`';
		return $this->db->query($sql)->result_array();
	}

	public function helperDone() {
		$sql = 'SELECT `order`.`ID`, `category`.`name` AS `category`, `model`.`name` AS `model`, `device`.`ID` AS `deviceID`, `order`.`date`, `usage`.`date` AS `useDate`, `usage`.`resource`, `status`, `detail`, `budget`, `fill` FROM `order` JOIN `device` ON (`status` = "DONE" OR `status` = "CANCEL") AND `order`.`deviceID` = `device`.`ID` JOIN `model` ON `device`.`modelID` = `model`.`ID` JOIN `category` ON `model`.`categoryID` = `category`.`ID` JOIN `usage` ON `order`.`usageID` = `usage`.`ID`';
		return $this->db->query($sql)->result_array();
	}

	public function groupBill($groupID) {
		$sql = 'SELECT `order`.`ID`, `userID`, `deviceID`, `order`.`date`, `status`, `detail`, `usageID`, `budgetID`, `fillID` FROM `order` JOIN `pay` ON `pay`.`method` = "GROUP" AND `pay`.`account` = ? AND (`order`.`budgetID` = `pay`.`ID` OR `order`.`fillID` = `pay`.`ID`)';
		return $this->db->query($sql, $groupID)->result_array();
	}

	public function all() {
		$sql = 'SELECT `ID`, `userID`, `deviceID`, `date`, `status`, `detail`, `usageID`, `budgetID`, `fillID` FROM `order`';
		return $this->db->query($sql)->result_array();
	}

}
