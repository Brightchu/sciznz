<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Config_model extends CI_Model {

	public function __construct() {
		parent::__construct();
		$this->load->database();
	}

	public function hierarchy($data = NULL) {
		if ($data) {
			$sql = 'UPDATE `config` SET `value`=? WHERE `name` = "hierarchy"';
			return $this->db->query($sql, $data);
		} else {
			$sql = 'SELECT `value` FROM `config` WHERE `name` = "hierarchy"';
			$row = $this->db->query($sql)->row_array();
			return json_decode($row['value'], TRUE);
		}
	}
}
