<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Device_model extends CI_Model {

	public function checkout()
	{
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

}
