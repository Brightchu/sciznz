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
}
