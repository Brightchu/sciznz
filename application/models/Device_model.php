<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Device_model extends CI_Model {

	public function checkout()
	{
		$this->load->database('slave');

		$device = [];
		$sql = 'SELECT `device`.`ID`, `device`.`city`, `supply`.`name` AS `supply`, `device`.`address`, `device`.`capacity`, `category`.`name` AS `category`, `model`.`vendor`, `model`.`name` AS `model`, `device`.`price`, `device`.`unit`, `model`.`field`, `device`.`field` AS `subfield`, `device`.`info`, `device`.`credit` FROM `device` JOIN `supply` ON `device`.`supplyID` = `supply`.`ID` JOIN `model` ON `device`.`modelID` = `model`.`ID` JOIN `category` ON `model`.`categoryID` = `category`.`ID`';
		$deviceList = $this->db->query($sql)->result_array();

		foreach ($deviceList as $row) {
			$row['field']  = array_merge(json_decode($row['field'], TRUE), json_decode($row['subfield'], TRUE));
			unset($row['subfield']);
			$device[$row['ID']] = $row;
		}

		return $device;
	}

}
