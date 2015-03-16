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
	 * @param	string	$username
	 * @param	string	$password
	 * @return  array   $name
	 * @return	bool    FALSE, if falied
	 */
	public function login($username, $password)
	{
		$sql = 'SELECT `ID`, `name`, `password` FROM `user` WHERE `username` = ?';
		$query = $this->db->query($sql, $username);
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
		$sql = 'SELECT `ID`, `name`, `username`, `phone`, `email`, `credit` FROM `user`';
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
			$sql = 'UPDATE `user` SET `name`=?, `username`=?, `password`=?, `phone`=?, `email`=?, `credit`=? WHERE `ID` = ?';
			$data = array($row['name'], $row['username'], password_hash($row['password'], PASSWORD_BCRYPT), $row['phone'], $row['email'], $row['credit'], $row['ID']);
			return $this->db->query($sql, $data);
		} else {
			$sql = 'UPDATE `user` SET `name`=?, `username`=?, `phone`=?, `email`=?, `credit`=? WHERE `ID` = ?';
			$data = array($row['name'], $row['username'], $row['phone'], $row['email'], $row['credit'], $row['ID']);
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
		$sql = 'INSERT INTO `user`(`name`, `username`, `password`, `phone`, `email`, `credit`) VALUES (?, ?, ?, ?, ?, ?)';
		$data = array($row['name'], $row['username'], password_hash($row['password'], PASSWORD_BCRYPT), $row['phone'], $row['email'], $row['credit']);
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

}
