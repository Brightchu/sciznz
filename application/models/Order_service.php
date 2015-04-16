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

	public function fill($ID, $method, $account, $transaction) {
		$this->load->model('pay_model');

		switch ($method) {
			case 'GROUP':
				$orderInfo = $this->order_model->info($ID);
				$detail = json_decode($orderInfo['detail'], TRUE);
				$amount = $detail['total'] - $detail['budget'];

				$payID = $this->pay_model->pay($amount, 'GROUP', $account, $transaction);
				return $this->order_model->fill($ID, $payID);
			
			case 'NONE':
				return $this->order_model->fill($ID, 0);

			default:
				return FALSE;
		}
	}

	public function cancel($ID) {
		$this->load->model('usage_model');
		$this->load->model('pay_model');

		$orderInfo = $this->order_model->info($ID);
		$result = $this->usage_model->cancel($orderInfo['usageID']);

		if ($result && $orderInfo['budgetID']) {
			$result = $this->pay_model->refund($orderInfo['budgetID']);
		}

		if ($result && $orderInfo['fillID']) {
			$result = $this->pay_model->refund($orderInfo['fillID']);
		}

		if ($result) {
			$result = $this->order_model->cancel($ID);
		}

		return $result;
	}

	public function userActive($userID) {
		return $this->order_model->userActive($userID);
	}

	public function userDone($userID) {
		return $this->order_model->userDone($userID);
	}


	public function supplyActive($supplyID) {
		return $this->order_model->supplyActive($supplyID);
	}

	public function supplyDone($supplyID) {
		return $this->order_model->supplyDone($supplyID);
	}

	public function groupBill($groupID) {
		return $this->order_model->groupBill($groupID);
	}

}
