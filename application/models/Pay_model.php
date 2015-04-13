<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Pay_model extends CI_Model {

	public function __construct() {
		parent::__construct();
		$this->load->database();
	}

	public function pay($amount, $method, $account, $transaction) {
		$sql = 'INSERT INTO `pay`(`amount`, `method`, `account`, `transaction`) VALUES (?, ?, ?, ?)';
		$data = [$amount, $method, $account, $transaction];

		$result = $this->db->query($sql, $data);
		if ($result) {
			return $this->db->insert_id();
		} else {
			return FALSE;
		}
	}
}
