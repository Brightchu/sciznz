<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Admin_model extends CI_Model {

	public function __construct()
	{
		parent::__construct();
		$this->load->database();
		$this->load->model('admin_mail');
	}

	/**
	 * Check privilege of a login attempt
	 * @param	string	$username
	 * @param	string	$password
	 * @return  array   $name, $privilege
	 * @return	bool    FALSE, if falied
	 */
	public function login($username, $password)
	{
		$sql = 'SELECT `ID`, `name`, `password`, `privilege` FROM `admin` WHERE `username` = ?';
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
	 * Retrive all admin
	 * @return  array
	 */
	public function query()
	{
		$sql = 'SELECT `ID`, `privilege`, `name`, `username`, `phone`, `email`, `credit` FROM `admin`';
		return $this->db->query($sql)->result_array();
	}

	/**
	 * Update a admin
	 * @param 	array $row
	 * @return 	bool
	 */
	public function update($row)
	{
		if (isset($row['password'])) {
			$sql = 'UPDATE `admin` SET `privilege`=?, `name`=?, `username`=?, `password`=?, `phone`=?, `email`=?, `credit`=? WHERE `ID` = ?';
			$data = array($row['privilege'], $row['name'], $row['username'], password_hash($row['password'], PASSWORD_BCRYPT), $row['phone'], $row['email'], $row['credit'], $row['ID']);
			return $this->db->query($sql, $data);
		} else {
			$sql = 'UPDATE `admin` SET `privilege`=?, `name`=?, `username`=?, `phone`=?, `email`=?, `credit`=? WHERE `ID` = ?';
			$data = array($row['privilege'], $row['name'], $row['username'], $row['phone'], $row['email'], $row['credit'], $row['ID']);
			return $this->db->query($sql, $data);
		}
	}

	/**
	 * Save a admin
	 * @param 	array $row
	 * @return 	bool
	 */
	public function save($row)
	{
		$sql = 'INSERT INTO `admin`(`privilege`, `name`, `username`, `password`, `phone`, `email`, `credit`) VALUES (?, ?, ?, ?, ?, ?, ?)';
		$data = array($row['privilege'], $row['name'], $row['username'], password_hash($row['password'], PASSWORD_BCRYPT), $row['phone'], $row['email'], $row['credit']);
		$result = $this->db->query($sql, $data);
		if ($result) {
			$this->admin_mail->register($row);
		}
		return $result;
	}

	/**
	 * Delete a admin
	 * @param 	int $ID
	 * @return 	bool
	 */
	public function delete($ID)
	{
		$sql = 'DELETE FROM `admin` WHERE `ID` = ?';
		return $this->db->query($sql, $ID);
	}

}
