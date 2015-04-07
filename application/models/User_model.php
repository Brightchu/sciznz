<?php
defined('BASEPATH') OR exit('No direct script access allowed');
require_once(APPPATH . 'models/Account_model.php');

class User_model extends Account_model {

	protected $role = 'user';

	/**
	 * Update name
	 * @param	string	$ID, $name
	 * @return  bool
	 */
	public function updateName($ID, $name)
	{
		$this->load->database();

		$sql = "UPDATE `{$this->role}` SET `name`=? WHERE `ID` = ?";
		$data = [$name, $ID];

		return $this->db->query($sql, $data);
	}

	/**
	 * Update phone
	 * @param	string	$ID, $phone
	 * @return  bool
	 */
	public function updatePhone($ID, $phone)
	{
		$this->load->database();

		$sql = "UPDATE `{$this->role}` SET `phone`=? WHERE `ID` = ?";
		$data = [$phone, $ID];

		return $this->db->query($sql, $data);
	}

	/**
	 * Verify email
	 * @param	string	$ID
	 * @return  bool
	 */
	public function verifyEmail($ID)
	{
		$this->load->database();

		$sql = "UPDATE `{$this->role}` SET `verifyEmail`= 1 WHERE `ID` = ?";

		return $this->db->query($sql, $ID);
	}

	/**
	 * Verify phone
	 * @param	string	$ID
	 * @return  bool
	 */
	public function verifyPhone($ID)
	{
		$this->load->database();

		$sql = "UPDATE `{$this->role}` SET `verifyPhone`= 1 WHERE `ID` = ?";

		return $this->db->query($sql, $ID);
	}

}
