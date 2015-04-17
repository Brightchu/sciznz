<?php
defined('BASEPATH') OR exit('No direct script access allowed');

require_once(APPPATH . 'models/Account_model.php');

class User_model extends Account_model {

	/**
	 * Update name
	 * @param	string	$ID, $name
	 * @return  bool
	 */
	public function updateName($ID, $name)
	{
		$sql = "UPDATE `{$this->role}` SET `name`=? WHERE `ID` = ?";
		return $this->db->query($sql, [$name, $ID]);
	}

	/**
	 * Update phone
	 * @param	string	$ID, $phone
	 * @return  bool
	 */
	public function updatePhone($ID, $phone)
	{
		$sql = "UPDATE `{$this->role}` SET `phone`=? WHERE `ID` = ?";
		return $this->db->query($sql, [$phone, $ID]);
	}

	/**
	 * Verify email
	 * @param	string	$email
	 * @return  bool
	 */
	public function verifyEmail($email)
	{
		$sql = "UPDATE `{$this->role}` SET `verifyEmail`= 1 WHERE `email` = ?";
		return $this->db->query($sql, $email);
	}

	/**
	 * Verify phone
	 * @param	string	$ID
	 * @return  bool
	 */
	public function verifyPhone($ID)
	{
		$sql = "UPDATE `{$this->role}` SET `verifyPhone`= 1 WHERE `ID` = ?";
		return $this->db->query($sql, $ID);
	}


	public function payMethod($ID) {
		$sql = 'SELECT `member`.`groupID`, `group`.`name` AS `groupName` FROM `member` JOIN `group` ON `userID` = ? AND `member`.`groupID` = `group`.`ID`';
		return $this->db->query($sql, $ID)->result_array();
	}

}
