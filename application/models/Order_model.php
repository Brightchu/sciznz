<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Order_model extends CI_Model {

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
		$sql = 'DELETE FROM `supply` WHERE `ID` = ?';
		return $this->db->query($sql, $ID);
	}

	public function count($deviceID, $useDate)
	{
		$sql = 'SELECT COUNT(*) AS `count` FROM `order` WHERE `deviceID` = ? AND `useDate` = ?';
		$data = array($deviceID, $useDate);
		return $this->db->query($sql, $data)->row_array();;
	}

	public function book($row)
	{
		$sql = 'SELECT `device`.`city`, `supply`.`name` AS `supply`, `device`.`address`, `category`.`name` AS `category`, `model`.`vendor`, `model`.`name` AS `model`, `device`.`price`, `device`.`unit` FROM `device` JOIN `supply` ON `device`.`ID` = ? AND `device`.`supplyID` = `supply`.`ID` JOIN `model` ON `device`.`modelID` = `model`.`ID` JOIN `category` ON `model`.`categoryID` = `category`.`ID`';
		$info = $this->db->query($sql, $row['deviceID'])->row_array();
		$row = array_merge($row, $info);

		$sql = 'INSERT INTO `order`(`userID`, `deviceID`, `useDate`, `status`, `price`, `payID`) VALUES (?, ?, ?, ?, ?, 0)';
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

	public function checkout($ID)
	{
		$sql = 'SELECT `order`.`ID`, `order`.`deviceID`, `supply`.`name` AS `supply`, `device`.`address`, `category`.`name` AS `category`, `model`.`vendor`, `model`.`name` AS `model`, `order`.`date`, `order`.`useDate`, `order`.`payID`, `order`.`price`, `order`.`status` FROM `order` JOIN `device` ON `order`.`userID` = ? AND `order`.`deviceID` = `device`.`ID` JOIN `supply` ON `device`.`supplyID` = `supply`.`ID` JOIN `model` ON `device`.`modelID` = `model`.`ID` JOIN `category` ON `model`.`categoryID` = `category`.`ID`';
		return $this->db->query($sql, $ID)->result_array();
	}

	public function getUnread($ID)
	{
		$sql = 'SELECT `order`.`ID`, `order`.`deviceID`, `device`.`address`, `category`.`name` AS `category`, `model`.`vendor`, `model`.`name` AS `model`, `order`.`date`, `order`.`useDate`, `order`.`payID`, `order`.`price`, `order`.`status` FROM `order` JOIN `device` ON `device`.`supplyID` = ? AND `order`.`deviceID` = `device`.`ID` JOIN `supply` ON `device`.`supplyID` = `supply`.`ID` JOIN `model` ON `device`.`modelID` = `model`.`ID` JOIN `category` ON `model`.`categoryID` = `category`.`ID`';
		return $this->db->query($sql, $ID)->result_array();
	}

	public function setStatus($row)
	{
		$sql = 'UPDATE `order` SET `status` = ? WHERE `ID` = ?';
		$data = array($row['status'], $row['ID']);
		return $this->db->query($sql, $data);
	}
}
