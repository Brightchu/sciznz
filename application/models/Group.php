<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Group extends CI_Model {

	public function __construct()
	{
		parent::__construct();
		$this->load->database();
	}

	/**
	 * Retrive group
	 * @return  array
	 */
	public function get()
	{
		$sql = 'SELECT `value` FROM `config` WHERE `key` = "group"';
		$data = $this->db->query($sql)->row_array();
		return $data['value'];
	}

	/**
	 * Update group
	 * @param 	array $row
	 * @return 	bool
	 */
	public function set($data)
	{
		$sql = 'UPDATE `config` SET `value`=? WHERE `key` = "group"';
		return $this->db->query($sql, $data);
	}

}
