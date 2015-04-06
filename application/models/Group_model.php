<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Group_model extends CI_Model {

	public function __construct()
	{
		parent::__construct();
		$this->load->database();
	}

	/**
	 * Check privilege of a login attempt
	 * @param	string	$email
	 * @param	string	$password
	 * @return  array   $name
	 * @return	bool    FALSE, if falied
	 */
	public function login($email, $password)
	{
		$sql = 'SELECT `ID`, `name`, `password` FROM `group` WHERE `email` = ?';
		$query = $this->db->query($sql, $email);
		$row = $query->row_array();

		if ($row) {
			if (password_verify($password, $row['password'])) {
				unset($row['password']);
				return $row;
			}
		}

		return FALSE;
	}

	/**
	 * Retrive all user
	 * @return  array
	 */
	public function query()
	{
		$sql = 'SELECT `ID`, `name`, `email`, `phone` FROM `group`';
		return $this->db->query($sql)->result_array();
	}

	/**
	 * Update an user
	 * @param 	array $row
	 * @return 	bool
	 */
	public function update($row)
	{
		if (isset($row['password'])) {
			$sql = 'UPDATE `group` SET `name`=?, `email`=?, `password`=?, `phone`=? WHERE `ID` = ?';
			$data = array($row['name'], $row['email'], password_hash($row['password'], PASSWORD_BCRYPT), $row['phone'], $row['ID']);
			return $this->db->query($sql, $data);
		} else {
			$sql = 'UPDATE `group` SET `name`=?, `email`=?, `phone`=? WHERE `ID` = ?';
			$data = array($row['name'], $row['email'], $row['phone'], $row['ID']);
			return $this->db->query($sql, $data);
		}
	}

	/**
	 * Save an user
	 * @param 	array $row
	 * @return 	bool
	 */
	public function save($row)
	{
		$sql = 'INSERT INTO `group`(`name`, `email`, `password`, `phone`) VALUES (?, ?, ?, ?)';
		$data = array($row['name'], $row['email'], password_hash($row['password'], PASSWORD_BCRYPT), $row['phone']);
		$result = $this->db->query($sql, $data);
		if ($result) {
			$this->usermail->register($row);
		}
		return $result;
	}

	/**
	 * Delete an user
	 * @param 	int $ID
	 * @return 	bool
	 */
	public function delete($ID)
	{
		$sql = 'DELETE FROM `group` WHERE `ID` = ?';
		return $this->db->query($sql, $ID);
	}

	public function getInfo($ID)
	{
		$sql = 'SELECT `name`, `email`, `phone` FROM `group` WHERE `ID` = ?';
		return $this->db->query($sql, $ID)->row_array();
	}

	public function setInfo($row)
	{
		$sql = 'UPDATE `group` SET `name`=?, `email`=?, `phone`=? WHERE `ID` = ?';
		$data = array($row['name'], $row['email'], $row['phone'], $row['ID']);
		return $this->db->query($sql, $data);
	}

	public function updatePassword($row)
	{
		$sql = 'SELECT `password` FROM `group` WHERE `ID` = ?';
		$query = $this->db->query($sql, $row['ID']);
		$info = $query->row_array();

		if ($info) {
			if (password_verify($row['oldPassword'], $info['password'])) {
				$sql = 'UPDATE `group` SET `password`=? WHERE `ID` = ?';
				$data = array(password_hash($row['newPassword'], PASSWORD_BCRYPT), $row['ID']);
				return $this->db->query($sql, $data);
			}
		}

		return FALSE;
	}

	public function pay($userID, $orderID) {
		$sql = 'SELECT `groupID` FROM `user` WHERE `ID` = ?';
		$groupID = $this->db->query($sql, $userID)->row_array()['groupID'];

		$sql = 'SELECT `price` FROM `order` WHERE `ID` = ?';
		$amount = $this->db->query($sql, $orderID)->row_array()['price'];

		$sql = 'INSERT INTO `pay`(`amount`, `method`, `account`, `transaction`) VALUES (?, "group", ?, ?)';
		$this->db->query($sql, [$amount, $groupID, $userID]);

		$payID = $this->db->insert_id();

		$sql = 'UPDATE `order` SET `payID` = ? WHERE `ID` = ?';
		return $this->db->query($sql, [$payID, $orderID]);
	}

	public function bill($groupID) {
		$sql = 'SELECT `pay`.`ID`, `date`, `amount`, `name` FROM `pay` JOIN `user` ON `method` = "group" AND `account` = ? AND `user`.`ID` = `pay`.`transaction`';
		return $this->db->query($sql, $groupID)->result_array();
	}

}
