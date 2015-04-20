<?php
defined('BASEPATH') OR exit('No direct script access allowed');

require_once(APPPATH . 'models/Account_model.php');

class Supply_model extends Account_model {

	public function locale() 
	{
		$this->load->database('slave');
		$sql = 'SELECT DISTINCT `locale` FROM `supply`';
		return array_column($this->db->query($sql)->result_array(), 'locale');
	}

	public function query()
	{
		$sql = "SELECT `ID`, `name`, `email`, `phone`, `email`, `city`, `locale`, `address`, `memo` FROM `{$this->role}`";
		return $this->db->query($sql)->result_array();
	}

	public function update($row)
	{
		if (isset($row['password'])) {
			$sql = "UPDATE `{$this->role}` SET `name`=?, `email`=?, `password`=?, `phone`=?, `city`=?, `locale`=?, `address`=?, `memo`=? WHERE `ID` = ?";
			$data = array($row['name'], $row['email'], password_hash($row['password'], PASSWORD_BCRYPT), $row['phone'], $row['city'], $row['locale'], $row['address'], $row['memo'], $row['ID']);
			return $this->db->query($sql, $data);
		} else {
			$sql = "UPDATE `{$this->role}` SET `name`=?, `email`=?, `phone`=?, `city`=?, `locale`=?, `address`=?, `memo`=? WHERE `ID` = ?";
			$data = array($row['name'], $row['email'], $row['phone'], $row['city'], $row['locale'], $row['address'], $row['memo'], $row['ID']);
			return $this->db->query($sql, $data);
		}
	}

	public function save($row)
	{
		$sql = "INSERT INTO `{$this->role}` (`name`, `email`, `password`, `phone`, `city`, `locale`, `address`, `memo`) VALUES (?, ?, ?, ?, ?, ?, ?, ?)";
		$data = array($row['name'], $row['email'], password_hash($row['password'], PASSWORD_BCRYPT), $row['phone'], $row['city'], $row['locale'], $row['address'], $row['memo']);
		return $this->db->query($sql, $data);
	}

}
