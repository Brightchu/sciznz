<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Order extends CI_Model {

	public function __construct()
	{
		parent::__construct();
		$this->load->database();
		$this->load->model('ordermail');
	}

	public function query()
	{
		$sql = 'SELECT `ID`, `userID`, `deviceID`, `date`, `useDate`, `status`, `payMethod`, `transactionID`, `price` FROM `order`';
		return $this->db->query($sql)->result_array();
	}

	public function update($row)
	{
		$sql = 'UPDATE `order` SET `userID` = ?, `deviceID` = ?, `date` = ?, `useDate` = ?, `status` = ?, `payMethod` = ?, `transactionID` = ?, `price` = ? WHERE `ID` = ?';
		$data = array($row['userID'], $row['deviceID'], $row['date'], $row['ID'], $row['useDate'],  $row['status'],  $row['payMethod'],  $row['transactionID'], $row['price'], $row['ID']);
		return $this->db->query($sql, $data);
	}

	public function save($row)
	{
		$sql = 'INSERT INTO `order`(`userID`, `deviceID`, `date`, `useDate`, `status`, `payMethod`, `transactionID`, `price`) VALUES (?, ?, ?, ?, ?, ?, ?, ?)';
		$data = array($row['userID'], $row['deviceID'], $row['date'], $row['useDate'], $row['status'], $row['payMethod'], $row['transactionID'], $row['price']);
		return $this->db->query($sql, $data);
	}

	public function delete($ID)
	{
		$sql = 'DELETE FROM `institute` WHERE `ID` = ?';
		return $this->db->query($sql, $ID);
	}

	public function book($row)
	{
		$sql = 'SELECT `device`.`city`, `institute`.`name` AS `institute`, `device`.`address`, `category`.`name` AS `category`, `model`.`vendor`, `model`.`name` AS `model`, `device`.`price`, `device`.`unit` FROM `device` JOIN `institute` ON `device`.`ID` = ? AND `device`.`instituteID` = `institute`.`ID` JOIN `model` ON `device`.`modelID` = `model`.`ID` JOIN `category` ON `model`.`categoryID` = `category`.`ID`';
		$info = $this->db->query($sql, $row['deviceID'])->row_array();
		$row = array_merge($row, $info);

		$sql = 'INSERT INTO `order`(`userID`, `deviceID`, `useDate`, `status`, `price`) VALUES (?, ?, ?, ?, ?)';
		$data = array($row['userID'], $row['deviceID'], $row['useDate'], 1, $row['price']);
		$result = $this->db->query($sql, $data);
		if ($result) {
			$sql = 'SELECT `name`, `email` FROM `user` WHERE `ID` = ?';
			$namecard = $this->db->query($sql, $row['userID'])->row_array();;
			$row = array_merge($row, $namecard);
			$this->ordermail->book($row);
		}
		return $result;
	}
}
