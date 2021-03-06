<?php
defined('BASEPATH') OR exit('No direct script access allowed');

abstract class Account_model extends CI_Model {

	protected $role = '';

	public function __construct()
	{
		parent::__construct();
		$this->role = strtolower(explode('_', get_called_class())[0]);
		$this->load->database();
	}

	/**
	 * Register an account
	 * @param 	$email, $password
	 * @return  array   $ID, $name or FLASE
	 */
	public function register($email, $password)
	{
		$sql = "INSERT INTO `{$this->role}` (`name`, `email`, `password`) VALUES (?, ?, ?)";
		$data = [$email, $email, password_hash($password, PASSWORD_BCRYPT)];
		
		if ($this->db->query($sql, $data))
		{
			return [
				'ID' => $this->db->insert_id(),
				'name' => $email,
			];
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
		$sql = "SELECT `password` FROM `{$this->role}` WHERE `ID` = ?";
		$row = $this->db->query($sql, $ID)->row_array();

		if ($row)
		{
			if (password_verify($oldPassword, $row['password']))
			{
				$sql = "UPDATE `{$this->role}` SET `password`=? WHERE `ID` = ?";
				return $this->db->query($sql, [password_hash($newPassword, PASSWORD_BCRYPT), $ID]);
			}
		}

		return FALSE;
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

	public function info($ID) {
		$sql = "SELECT `name`, `email`, `phone` FROM `{$this->role}` WHERE `ID` = ?";
		return $this->db->query($sql, $ID)->row_array();
	}

	/**
	 * Retrive all
	 * @return  array
	 */
	public function query()
	{
		$sql = "SELECT `ID`, `name`, `email`, `phone`, `email` FROM `{$this->role}`";
		return $this->db->query($sql)->result_array();
	}

	public function update($row)
	{
		if (isset($row['password'])) {
			$sql = "UPDATE `{$this->role}` SET `name`=?, `email`=?, `password`=?, `phone`=? WHERE `ID` = ?";
			$data = array($row['name'], $row['email'], password_hash($row['password'], PASSWORD_BCRYPT), $row['phone'], $row['ID']);
			return $this->db->query($sql, $data);
		} else {
			$sql = "UPDATE `{$this->role}` SET `name`=?, `email`=?, `phone`=? WHERE `ID` = ?";
			$data = array($row['name'], $row['email'], $row['phone'], $row['ID']);
			return $this->db->query($sql, $data);
		}
	}

	public function save($row)
	{
		$sql = "INSERT INTO `{$this->role}` (`name`, `email`, `password`, `phone`) VALUES (?, ?, ?, ?)";
		$data = array($row['name'], $row['email'], password_hash($row['password'], PASSWORD_BCRYPT), $row['phone']);
		return $this->db->query($sql, $data);
	}

	public function delete($ID)
	{
		$sql = "DELETE FROM `{$this->role}` WHERE `ID` = ?";
		return $this->db->query($sql, $ID);
	}

}
