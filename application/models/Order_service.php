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
		return $this->order_model->status($ID, 'CONFIRM');
	}

	public function budget($ID, $method, $account, $transaction) {
		$this->load->model('pay_model');
		$this->load->model('device_model');
		$this->load->model('usage_model');

		switch ($method) {
			case 'GROUP':
				$orderInfo = $this->order_model->info($ID);
				$deviceInfo = $this->device_model->info($orderInfo['deviceID']);
				$usageInfo = $this->usage_model->info($orderInfo['usageID']);

				$schedule = json_decode($deviceInfo['schedule'], TRUE);
				$amount = $schedule[strtolower($orderInfo['method'])][$usageInfo['resource']]['price'];

				$payID = $this->pay_model->pay($amount, 'GROUP', $account, $transaction);
				return $this->order_model->budget($ID, $payID);
			
			default:
				return FALSE;
		}
	}

	public function begin($ID) {
		return $this->order_model->status($ID, 'BEGIN');
	}

	public function end($ID) {
		return $this->order_model->status($ID, 'END');
	}

	public function detail($ID, $detail) {
		return $this->order_model->detail($ID, $detail);
	}
}
