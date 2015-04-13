<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Order_service extends CI_Model {

	public function __construct() {
		parent::__construct();
		$this->load->model('order_model');
	}

	/**
	 * Create an order
	 * @param 	$userID, $deviceID, $date, $resource
	 * @return  bool
	 */
	public function create($userID, $deviceID, $method, $date, $resource) {
		return $this->order_model->create($userID, $deviceID, $method, $date, $resource);
	}

	public function confirm($ID) {
		return $this->order->model->status($ID, 'CONFIRM');
	}

}
