<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Hierarchy extends CI_Model {

	public function __construct()
	{
		parent::__construct();
		$this->load->database();
	}

	/**
	 * Retrive hierarchy
	 * @return  array
	 */
	public function get()
	{
		$sql = 'SELECT `value` FROM `config` WHERE `key` = "hierarchy"';
		return $this->db->query($sql)->row_array()['value'];
	}

	/**
	 * Update hierarchy
	 * @param 	array $row
	 * @return 	bool
	 */
	public function set($data)
	{
		$sql = 'UPDATE `config` SET `value`=? WHERE `key` = "hierarchy"';
		return $this->db->query($sql, $data);
	}

	public function checkout()
	{
		$sql = 'SELECT `value` FROM `config` WHERE `key` = "hierarchy"';
		$row = $this->db->query($sql)->row_array();
		return json_decode($row['value'], TRUE);
	}
}
