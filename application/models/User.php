<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class User extends CI_Model {

	public function __construct()
	{
		parent::__construct();
		$this->load->database();
		$this->load->model('usermail');
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
		$sql = 'SELECT `ID`, `name`, `password`, `credit` FROM `user` WHERE `email` = ?';
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
		$sql = 'SELECT `ID`, `name`, `email`, `phone`, `credit` FROM `user`';
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
			$sql = 'UPDATE `user` SET `name`=?, `email`=?, `password`=?, `phone`=?, `credit`=? WHERE `ID` = ?';
			$data = array($row['name'], $row['email'], password_hash($row['password'], PASSWORD_BCRYPT), $row['phone'], $row['credit'], $row['ID']);
			return $this->db->query($sql, $data);
		} else {
			$sql = 'UPDATE `user` SET `name`=?, `email`=?, `phone`=?, `credit`=? WHERE `ID` = ?';
			$data = array($row['name'], $row['email'], $row['phone'], $row['credit'], $row['ID']);
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
		$sql = 'INSERT INTO `user`(`name`, `email`, `password`, `phone`, `credit`) VALUES (?, ?, ?, ?, ?)';
		$data = array($row['name'], $row['email'], password_hash($row['password'], PASSWORD_BCRYPT), $row['phone'], $row['credit']);
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
		$sql = 'DELETE FROM `user` WHERE `ID` = ?';
		return $this->db->query($sql, $ID);
	}

	public function getInfo($ID)
	{
		$sql = 'SELECT `name`, `email`, `phone`, `credit` FROM `user` WHERE `ID` = ?';
		return $this->db->query($sql, $ID)->row_array();
	}

	public function setInfo($row)
	{
		$sql = 'UPDATE `user` SET `name`=?, `email`=?, `phone`=? WHERE `ID` = ?';
		$data = array($row['name'], $row['email'], $row['phone'], $row['ID']);
		return $this->db->query($sql, $data);
	}

	public function updatePassword($row)
	{
		$sql = 'SELECT `password` FROM `user` WHERE `ID` = ?';
		$query = $this->db->query($sql, $row['ID']);
		$info = $query->row_array();

		if ($info) {
			if (password_verify($row['oldPassword'], $info['password'])) {
				$sql = 'UPDATE `user` SET `password`=? WHERE `ID` = ?';
				$data = array(password_hash($row['newPassword'], PASSWORD_BCRYPT), $row['ID']);
				return $this->db->query($sql, $data);
			}
		}

		return FALSE;
	}
}
