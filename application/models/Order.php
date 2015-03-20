<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Order extends CI_Model {

	public function __construct()
	{
		parent::__construct();
		$this->load->database();
	}

	public function query()
	{
		$sql = 'SELECT `ID`, `userID`, `deviceID`, `date`, `useDate`, `status`, `payMethod`, `transactionID`, `fee` FROM `order`';
		return $this->db->query($sql)->result_array();
	}

	public function update($row)
	{
		$sql = 'UPDATE `order` SET `userID` = ?, `deviceID` = ?, `date` = ?, `useDate` = ?, `status` = ?, `payMethod` = ?, `transactionID` = ?, `fee` = ? WHERE `ID` = ?';
		$data = array($row['userID'], $row['deviceID'], $row['date'], $row['ID'], $row['useDate'],  $row['status'],  $row['payMethod'],  $row['transactionID'], $row['fee'], $row['ID']);
		return $this->db->query($sql, $data);
	}

	public function save($row)
	{
		$sql = 'INSERT INTO `order`(`userID`, `deviceID`, `date`, `useDate`, `status`, `payMethod`, `transactionID`, `fee`) VALUES (?, ?, ?, ?, ?, ?, ?, ?)';
		$data = array($row['userID'], $row['deviceID'], $row['date'], $row['useDate'], $row['status'], $row['payMethod'], $row['transactionID'], $row['fee']);
		return $this->db->query($sql, $data);
	}

	public function delete($ID)
	{
		$sql = 'DELETE FROM `institute` WHERE `ID` = ?';
		return $this->db->query($sql, $ID);
	}

	public function book($row)
	{
		$sql = 'SELECT `price` FROM `device` WHERE `ID` = ?';
		$info = $this->db->query($sql, $row['deviceID'])->row_array();
		$price = $info['price'];

		$sql = 'INSERT INTO `order`(`userID`, `deviceID`, `useDate`, `status`, `fee`) VALUES (?, ?, ?, ?, ?)';
		$data = array($row['userID'], $row['deviceID'], $row['useDate'], 1, $price);
		return $this->db->query($sql, $data);
	}
}
