<?php
defined('BASEPATH') OR exit('No direct script access allowed');

require_once(APPPATH . 'models/Account_model.php');

class Group_model extends Account_model {

	public function getMember($ID) {
		$sql = 'SELECT `userID`, `name`, `email`, `phone` FROM `member` JOIN `user` ON `groupID` = ? AND `userID` = `ID`';
		return $this->db->query($sql, $ID)->result_array();
	}

	public  function addMember($ID, $email) {
		$sql = 'SELECT `ID` FROM `user` WHERE `email` = ?';
		$userID = $this->db->query($sql, $email)->row_array()['ID'];
		$sql = 'INSERT INTO `member`(`groupID`, `userID`) VALUES (?, ?)';
		return $this->db->query($sql, [$ID, $userID]);
	}

	public function deleteMember($ID, $userID) {
		$sql = 'DELETE FROM `member` WHERE `groupID` = ? AND `userID` = ?';
		return $this->db->query($sql, [$ID, $userID]);
	}

	public function bill($ID) {
		$sql = 'SELECT `pay`.`ID`, `pay`.`date`, `pay`.`amount`, `user`.`name` AS `user`, `order`.`ID` AS `orderID`, `category`.`name` AS `category`, `model`.`name` AS `model`, `supply`.`name` AS `supply` FROM `member` JOIN `user` ON `groupID` = ? AND `member`.`userID` = `user`.`ID` JOIN `order` ON `member`.`userID` = `order`.`userID` JOIN `device` ON `order`.`deviceID` = `device`.`ID` JOIN `model` ON `device`.`modelID` = `model`.`ID` JOIN `category` ON `model`.`categoryID` = `category`.`ID` JOIN `supply` ON `device`.`supplyID` = `supply`.`ID` JOIN `pay` ON `order`.`budgetID` = `pay`.`ID` OR `order`.`fillID` = `pay`.`ID`';
		return $this->db->query($sql, $ID)->result_array();
	}

}
