<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Category_model extends CI_Model {

	public function field()
	{
		$this->load->database('slave');

		$sql = 'SELECT `name`, `field` FROM `category`';
		$result = $this->db->query($sql)->result_array();

		$field = [];
		foreach ($result as $row) {
			$field[$row['name']] = json_decode($row['field'], TRUE);
		}

		return $field;
	}
}
