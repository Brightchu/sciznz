<?php
defined('BASEPATH') OR exit('No direct script access allowed');

require_once(APPPATH . 'models/Account_model.php');

class Supply_model extends Account_model {

	public function locale() 
	{
		$this->load->database('slave');
		$sql = 'SELECT DISTINCT `locale` FROM `supply`';
		return array_column($this->db->query($sql)->result_array(), 'locale');
	}
}
