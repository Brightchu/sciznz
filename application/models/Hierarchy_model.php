<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Hierarchy_model extends CI_Model {

	public function checkout()
	{
		$this->load->database('slave');

		$sql = 'SELECT `value` FROM `config` WHERE `key` = "hierarchy"';
		$row = $this->db->query($sql)->row_array();
		return json_decode($row['value'], TRUE);
	}
}
