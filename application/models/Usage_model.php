<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Usage_model extends CI_Model {

	public function usage($deviceID, $date)
	{
		$this->load->database('slave');

		$sql = 'SELECT `type`, `resource`, COUNT(*) AS `count` FROM `usage` WHERE `deviceID` = ? AND `date` = ? GROUP BY `type`, `resource` ORDER BY `type` ASC';
		$data = [$deviceID, $date];
		return $this->db->query($sql, $data)->result_array();
	}

	public function info($ID) {
		$this->load->database('slave');

		$sql = 'SELECT `deviceID`, `type`, `date`, `resource` FROM `usage` WHERE `ID` = ?';
		return $this->db->query($sql, $ID)->row_array();
	}
}
