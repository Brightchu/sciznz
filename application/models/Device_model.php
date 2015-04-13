<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Device_model extends CI_Model {

	public function checkout() {
		$this->load->database('slave');

		$device = [];
		$sql = 'SELECT `device`.`ID`, `supply`.`locale`, `supply`.`name` AS `supply`, `category`.`name` AS `category`, `model`.`name` AS `model`, `model`.`field`, `device`.`field` AS `subfield`, `device`.`info`, `model`.`img` AS `img`, `device`.`img` AS `subimg`, `model`.`spec` AS `spec`, `device`.`spec` AS `subspec`, `schedule` FROM `device` JOIN `supply` ON `device`.`supplyID` = `supply`.`ID` JOIN `model` ON `device`.`modelID` = `model`.`ID` JOIN `category` ON `model`.`categoryID` = `category`.`ID`';

		$deviceList = $this->db->query($sql)->result_array();

		foreach ($deviceList as $row) {
			$row['field']  = array_merge(json_decode($row['field'], TRUE), json_decode($row['subfield'], TRUE));
			$row['spec']  = array_merge(json_decode($row['spec'], TRUE), json_decode($row['subspec'], TRUE));
			if ($row['subimg']) {
				$row['img'] = $row['subimg'];
			}
			$row['schedule'] = json_decode($row['schedule'], TRUE);
			unset($row['subfield']);
			unset($row['subspec']);
			unset($row['subimg']);
			$device[$row['ID']] = $row;
		}

		return $device;
	}

	public function info($ID) {
		$this->load->database('slave');

		$sql = 'SELECT `modelID`, `supplyID`, `field`, `info`, `img`, `spec`, `schedule`, `contract`, `memo`, `online` FROM `device` WHERE `ID` = ?';
		return $this->db->query($sql, $ID)->row_array();
	}
}
