<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Usage_model extends CI_Model {

	public function resource($deviceID, $date)
	{
		$this->load->database('slave');

		$sql = 'SELECT `type`, `resource`, COUNT(*) AS `count` FROM `usage` WHERE `deviceID` = ? AND `date` = ? GROUP BY `type`, `resource`';
		$data = [$deviceID, $date];
		return $this->db->query($sql, $data)->result_array();
	}
}
