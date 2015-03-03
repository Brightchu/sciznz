<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Operator extends CI_Model {

	public function __construct()
	{
		parent::__construct();
		$this->load->database();
	}

	/**
	 * Check privilege of a login attempt
	 * @param	string	$username
	 * @param	string	$password
	 * @return  array   $name, $orgID
	 * @return	bool    FALSE, if falied
	 */
	public function login($username, $password)
	{
		$sql = 'SELECT `name`, `password`, `orgID` FROM `operator` WHERE `username` = ?';
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
	 * Retrive all operator
	 * @return  array
	 */
	public function query()
	{
		$sql = 'SELECT `ID`, `orgID`, `name`, `username`, `phone`, `email`, `credit` FROM `operator`';
		return $this->db->query($sql)->result_array();
	}

	/**
	 * Update a operator
	 * @param 	array $row
	 * @return 	bool
	 */
	public function update($row)
	{
		if (isset($row['password'])) {
			$sql = 'UPDATE `operator` SET `orgID`=?, `name`=?, `username`=?, `password`=?, `phone`=?, `email`=?, `credit`=? WHERE `ID` = ?';
			$data = array($row['orgID'], $row['name'], $row['username'], password_hash($row['password'], PASSWORD_BCRYPT), $row['phone'], $row['email'], $row['credit'], $row['ID']);
			return $this->db->query($sql, $data);
		} else {
			$sql = 'UPDATE `operator` SET `orgID`=?, `name`=?, `username`=?, `phone`=?, `email`=?, `credit`=? WHERE `ID` = ?';
			$data = array($row['orgID'], $row['name'], $row['username'], $row['phone'], $row['email'], $row['credit'], $row['ID']);
			return $this->db->query($sql, $data);
		}
	}

	/**
	 * Save an operator
	 * @param 	array $row
	 * @return 	bool
	 */
	public function save($row)
	{
		$sql = 'INSERT INTO `operator`(`orgID`, `name`, `username`, `password`, `phone`, `email`, `credit`) VALUES (?, ?, ?, ?, ?, ?, ?)';
		$data = array($row['orgID'], $row['name'], $row['username'], password_hash($row['password'], PASSWORD_BCRYPT), $row['phone'], $row['email'], $row['credit']);
		return $this->db->query($sql, $data);
	}

	/**
	 * Delete an operator
	 * @param 	int $ID
	 * @return 	bool
	 */
	public function delete($ID)
	{
		$sql = 'DELETE FROM `operator` WHERE `ID` = ?';
		return $this->db->query($sql, $ID);
	}

}
