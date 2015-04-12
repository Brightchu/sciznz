<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Config_model extends CI_Model {

	public function hierarchy()
	{
		$this->load->database('slave');

		$sql = 'SELECT `value` FROM `config` WHERE `name` = "hierarchy"';
		$row = $this->db->query($sql)->row_array();
		return json_decode($row['value'], TRUE);
	}
}
