<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Admin extends CI_Model {

	public function __construct()
	{
		parent::__construct();
		$this->load->database();
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
		$sql = 'SELECT `name`, `password`, `privilege` FROM `supervisor` WHERE `username` = ?';
		$query = $this->db->query($sql, $username);
		$row = $query->row_array();

		if ($row) {
			if (password_verify($username.$password, $row['password'])) {
				unset($row['password']);
				return $row;
			} else{
				return FALSE;
			}
		} else{
			return FALSE;
		}
	}

	/**
	 * Retrive all admin
	 * @return  array   $name, $privilege
	 */
	public function query()
	{
		$sql = 'SELECT `ID`, `privilege`, `name`, `username`, `phone`, `email`, `credit` FROM `supervisor`';
		return $this->db->query($sql)->result_array();
	}
}
