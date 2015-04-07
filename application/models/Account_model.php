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

		$sql = "INSERT INTO `{$this->role}` (`name`, `email`, `password`) VALUES (?, ?, ?)";
		$data = [$email, $email, password_hash($password, PASSWORD_BCRYPT)];
		
		if ($this->db->query($sql, $data))
		{
			return array(
				'ID' => $this->db->insert_id(),
				'name' => $email,
			);
		}
		else
		{
			return FALSE;
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

		$sql = "SELECT `ID`, `name`, `password` FROM `{$this->role}` WHERE `email` = ?";
		$row = $this->db->query($sql, $email)->row_array();

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

		$sql = "SELECT `password` FROM `{$this->role}` WHERE `ID` = ?";
		$row = $this->db->query($sql, $ID)->row_array();

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
	 * Retrive all
	 * @return  array
	 */
	public function all()
	{
		$this->load->database('slave');

		$sql = "SELECT `ID`, `name`, `email`, `phone`, `email`, `verifyEmail`, `verifyPhone` FROM `{$this->role}`";
		return $this->db->query($sql)->result_array();
	}

}
