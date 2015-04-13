<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Device_model extends CI_Model {

	public function checkout() {
		$this->load->database('slave');

		$device = [];
		$sql = 'SELECT `device`.`ID`, `supply`.`locale`, `supply`.`name` AS `supply`, `category`.`name` AS `category`, `model`.`name` AS `model`, `model`.`field`, `device`.`field` AS `subfield`, `device`.`info` FROM `device` JOIN `supply` ON `device`.`supplyID` = `supply`.`ID` JOIN `model` ON `device`.`modelID` = `model`.`ID` JOIN `category` ON `model`.`categoryID` = `category`.`ID`';
		$deviceList = $this->db->query($sql)->result_array();

		foreach ($deviceList as $row) {
			$row['field']  = array_merge(json_decode($row['field'], TRUE), json_decode($row['subfield'], TRUE));
			unset($row['subfield']);
			$device[$row['ID']] = $row;
		}

		return $device;
	}

	public function schedule($ID) {
		$this->load->database('slave');

		$sql = 'SELECT `schedule` FROM `device` WHERE `ID` = ?';
		$schedule = $this->db->query($sql, $ID)->row_array()['schedule'];

		return json_decode($schedule, TRUE);
	}

	public function info($ID) {
		$this->load->database('slave');

		$sql = 'SELECT `modelID`, `supplyID`, `field`, `info`, `img`, `spec`, `schedule`, `contract`, `memo`, `online` FROM `device` WHERE `ID` = ?';
		return $this->db->query($sql, $ID)->row_array();
	}
}
