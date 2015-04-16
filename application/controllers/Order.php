<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Order extends CI_Controller {

	public function __construct() {
		parent::__construct();
		$this->load->model('order_service');
	}

	public function create()
	{
		$this->load->library('encryption');

		$userID = $this->encryption->decrypt($this->input->cookie('userID'));
		$deviceID = $this->input->json('deviceID');
		$method = $this->input->json('method');
		$date = $this->input->json('date');
		$resource = $this->input->json('resource');

		$result = $this->order_service->create($userID, $deviceID, $method, $date, $resource);
		$this->output->set_status_header($result ? 200 : 403);
	}

	public function confirm() {
		$orderID = $this->input->json('orderID');
		$result = $this->order_service->confirm($orderID);
		$this->output->set_status_header($result ? 200 : 403);
	}

	public function budget() {
		$this->load->library('encryption');

		$orderID = $this->input->json('orderID');
		$method = $this->input->json('method');
		$account = $this->input->json('account');
		$transaction = $this->encryption->decrypt($this->input->cookie('userID'));

		$result = $this->order_service->budget($orderID, $method, $account, $transaction);
		$this->output->set_status_header($result ? 200 : 403);
	}

	public function begin() {
		$orderID = $this->input->json('orderID');
		$result = $this->order_service->begin($orderID);
		$this->output->set_status_header($result ? 200 : 403);
	}

	public function end() {
		$orderID = $this->input->json('orderID');
		$result = $this->order_service->end($orderID);
		$this->output->set_status_header($result ? 200 : 403);
	}

	public function detail() {
		$orderID = $this->input->json('orderID');
		$detail = json_encode($this->input->json('detail'));

		$result = $this->order_service->detail($orderID, $detail);
		$this->output->set_status_header($result ? 200 : 403);
	}

	public function fill() {
		$this->load->library('encryption');

		$orderID = $this->input->json('orderID');
		$method = $this->input->json('method');
		$account = $this->input->json('account');
		$transaction = $this->encryption->decrypt($this->input->cookie('userID'));

		$result = $this->order_service->fill($orderID, $method, $account, $transaction);
		$this->output->set_status_header($result ? 200 : 403);
	}

	public function cancel() {
		$orderID = $this->input->json('orderID');
		$result = $this->order_service->cancel($orderID);
		$this->output->set_status_header($result ? 200 : 403);
	}

	public function userActive() {
		$this->load->library('encryption');
		$userID = $this->encryption->decrypt($this->input->cookie('userID'));
		$this->output->set_json($this->order_service->userActive($userID));
	}

	public function userDone() {
		$this->load->library('encryption');
		$userID = $this->encryption->decrypt($this->input->cookie('userID'));
		$this->output->set_json($this->order_service->userDone($userID));
	}

	public function supplyActive() {
		$this->load->library('encryption');
		$supplyID = $this->encryption->decrypt($this->input->cookie('supplyID'));
		$this->output->set_json($this->order_service->supplyActive($supplyID));
	}

	public function supplyDone() {
		$this->load->library('encryption');
		$supplyID = $this->encryption->decrypt($this->input->cookie('supplyID'));
		$this->output->set_json($this->order_service->supplyDone($supplyID));
	}

	public function groupBill() {
		$this->load->library('encryption');
		$groupID = $this->encryption->decrypt($this->input->cookie('groupID'));
		$this->output->set_json($this->order_service->groupBill($groupID));
	}

}
