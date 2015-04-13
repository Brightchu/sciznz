<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Order_model extends CI_Model {

	/**
	 * Create an order
	 * @param 	$userID, $deviceID, $date, $resource
	 * @return  bool
	 */
	public function create($userID, $deviceID, $method, $date, $resource)
	{
		$this->load->database();

		if ($method === 'RESOURCE') {
			$sql = 'INSERT INTO `usage`(`deviceID`, `type`, `date`, `resource`) VALUES (?, "ORDER", ?, ?)';
			$data = [$deviceID, $date, $resource];
			$result = $this->db->query($sql, $data);

			if ($result) {
				$usageID = $this->db->insert_id();
				$sql = 'INSERT INTO `order`(`userID`, `deviceID`, `detail`, `method`, `usageID`) VALUES (?, ?, "{}", "RESOURCE", ?)';
				$data = [$userID, $deviceID, $usageID];
				return $this->db->query($sql, $data);
			}
		}

		if ($method === 'UNLIMITED') {
			$sql = 'INSERT INTO `order`(`userID`, `deviceID`, `detail`, `method`) VALUES (?, ?, "{}", "UNLIMITED")';
			$data = [$userID, $deviceID];
			return $this->db->query($sql, $data);
		}

		return FALSE;
	}

	/**
	 * Update status of an order
	 * @param 	$ID, $status
	 * @return  bool
	 */
	public function status($ID, $status)
	{
		$sql = 'UPDATE `order` SET `status` = ? WHERE `ID` = ?';
		$data = [$status, $ID];
		return $this->db->query($sql, $data);
	}

	public function user($userID)
	{
		$sql = 'SELECT `ID`, `userID`, `deviceID`, `date`, `status`, `detail`, `usageID`, `budgetID`, `payID` FROM `order` WHERE `userID` = ?';
		return $this->db->query($sql, $userID)->result_array();
	}

	public function userNow($userID)
	{
		$sql = 'SELECT `ID`, `userID`, `deviceID`, `date`, `status`, `detail`, `usageID`, `budgetID`, `payID` FROM `order` WHERE `userID` = ? AND `status` != "DONE"';
		return $this->db->query($sql, $userID)->result_array();
	}

	public function supply($supplyID)
	{
		$sql = 'SELECT `order`.`ID`, `userID`, `deviceID`, `date`, `status`, `detail`, `usageID`, `budgetID`, `payID` FROM `order` JOIN `device` ON `order`.`deviceID` = `device`.`ID` AND `device`.`supplyID` = ?';
		return $this->db->query($sql, $supplyID)->result_array();
	}

	public function supplyNow($supplyID)
	{
		$sql = 'SELECT `order`.`ID`, `userID`, `deviceID`, `date`, `status`, `detail`, `usageID`, `budgetID`, `payID` FROM `order` JOIN `device` ON `status` != "DONE" AND `order`.`deviceID` = `device`.`ID` AND `device`.`supplyID` = ?';
		return $this->db->query($sql, $supplyID)->result_array();
	}

	public function group($groupID)
	{
		$sql = 'SELECT `order`.`ID`, `userID`, `deviceID`, `order`.`date`, `status`, `detail`, `usageID`, `budgetID`, `payID` FROM `order` JOIN `pay` ON `pay`.`method` = "GROUP" AND `pay`.`account` = ? AND (`order`.`budgetID` = `pay`.`ID` OR `order`.`payID` = `pay`.`ID`)';
		return $this->db->query($sql, $groupID)->result_array();
	}

	public function all()
	{
		$sql = 'SELECT `ID`, `userID`, `deviceID`, `date`, `status`, `detail`, `usageID`, `budgetID`, `payID` FROM `order`';
		return $this->db->query($sql)->result_array();
	}

}
