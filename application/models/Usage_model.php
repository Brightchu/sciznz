<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Usage_model extends CI_Model {

	public function __construct() {
		parent::__construct();
		$this->load->database();
	}

	public function usage($deviceID, $date) {
		$sql = 'SELECT `type`, `resource`, COUNT(*) AS `count` FROM `usage` WHERE `deviceID` = ? AND `date` = ? GROUP BY `type`, `resource` ORDER BY `type` ASC';
		return $this->db->query($sql, [$deviceID, $date])->result_array();
	}

	public function info($ID) {
		$sql = 'SELECT `deviceID`, `type`, `date`, `resource` FROM `usage` WHERE `ID` = ?';
		return $this->db->query($sql, $ID)->row_array();
	}

	public function cancel($ID) {
		$sql = 'DELETE FROM `usage` WHERE `ID` = ?';
		return $this->db->query($sql, $ID);
	}
}
