<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Account_model extends CI_Model {

	protected $role = '';

	/**
	 * Register an account
	 * @param 	$email, $password
	 * @return  array   $ID, $name or FLASE
	 */
	public function register($email, $password)
	{
		$this->load->database();

		$sql = 'INSERT INTO `?` (`name`, `email`, `password`) VALUES (?, ?, ?)';
		$data = [$this->role, $email, $email, password_hash($password, PASSWORD_BCRYPT)];
		
		if ($this->db->query($sql, $data))
		{
			return array(
				'ID' => $this->db->insert_id(),
				'name' => $email,
			);
		}
		else
		{
			return FALSE
		}
	}

	/**
	 * Auth a login attempt
	 * @param	string	$email, $password
	 * @return  array   $ID, $name or FLASE
	 */
	public function auth($email, $password)
	{
		$this->load->database('slave');

		$sql = 'SELECT `ID`, `name`, `password` FROM `?` WHERE `email` = ?';
		$data = [$this->role, $email];
		$row = $this->db->query($sql, $data)->row_array();

		if ($row)
		{
			if (password_verify($password, $row['password']))
			{
				unset($row['password']);
				return $row;
			}
		}

		return FALSE;
	}

	/**
	 * Update password
	 * @param	string	$ID, $oldPassword, $newPassword
	 * @return  bool
	 */
	public function updatePassword($ID, $oldPassword, $newPassword)
	{
		$this->load->database();

		$sql = 'SELECT `password` FROM `?` WHERE `ID` = ?';
		$data = [$this->role, $ID];
		$row = $this->db->query($sql, $data)->row_array();

		if ($row)
		{
			if (password_verify($oldPassword, $row['password']))
			{
				$sql = 'UPDATE `?` SET `password`=? WHERE `ID` = ?';
				$data = [$this->role, $newPassword, $ID];
				return $this->db->query($sql, $data);
			}
		}

		return FALSE;
	}

	/**
	 * Update name
	 * @param	string	$ID, $name
	 * @return  bool
	 */
	public function updateName($ID, $name)
	{
		$this->load->database();

		$sql = 'UPDATE `?` SET `name`=? WHERE `ID` = ?';
		$data = [$this->role, $name, $ID];

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

		$sql = 'UPDATE `?` SET `phone`=? WHERE `ID` = ?';
		$data = [$this->role, $phone, $ID];

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

		$sql = 'UPDATE `?` SET `verifyEmail`= 1 WHERE `ID` = ?';
		$data = [$this->role, $ID];

		return $this->db->query($sql, $data);
	}

	/**
	 * Verify phone
	 * @param	string	$ID
	 * @return  bool
	 */
	public function verifyPhone($ID)
	{
		$this->load->database();

		$sql = 'UPDATE `?` SET `verifyPhone`= 1 WHERE `ID` = ?';
		$data = [$this->role, $ID];

		return $this->db->query($sql, $data);
	}

	/**
	 * Retrive all
	 * @return  array
	 */
	public function query()
	{
		$sql = 'SELECT `ID`, `name`, `email`, `phone`, `email`, `verifyEmail`, `verifyPhone` FROM `?`';
		return $this->db->query($sql, $this->role)->result_array();
	}

}
