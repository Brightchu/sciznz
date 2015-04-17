<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Order extends CI_Controller {

	public function __construct() {
		parent::__construct();
		$this->load->model('order_service');
		$this->load->model('order_mail');
	}

	public function create() {
		$this->load->library('encryption');
		$this->load->model('user_model');
		$this->load->model('device_model');
		$this->lang->load('name');

		$userID = $this->encryption->decrypt($this->input->cookie('userID'));
		$deviceID = $this->input->json('deviceID');
		$method = $this->input->json('method');
		$date = $this->input->json('date');
		$resource = $this->input->json('resource');
		$note = $this->input->json('note');

		$result = $this->order_service->create($userID, $deviceID, $method, $date, $resource, $note);
		if ($result) {
			$userInfo = $this->user_model->info($userID);
			$deviceInfo = $this->device_model->textInfo($deviceID);
			$data = [
				'name' => $userInfo['name'],
				'model' => $deviceInfo['model'],
				'category' => $deviceInfo['category'],
				'supply' => $deviceInfo['supply'],
				'method' => $this->lang->line($method),
				'date' => $date, 
				'resource' => $resource,
				'note' => $note,
			];
			$this->order_mail->create($userInfo['email'], $deviceInfo['supplyEmail'], $data);
			$this->output->set_status_header(200);
		} else {
			$this->output->set_status_header(403);
		}
	}

	public function confirm() {
		$this->load->model('user_model');
		$this->load->model('device_model');

		$orderID = $this->input->json('orderID');
		$result = $this->order_service->confirm($orderID);
		if ($result) {
			$orderInfo = $this->order_service->info($orderID);
			$userInfo = $this->user_model->info($orderInfo['userID']);
			$deviceInfo = $this->device_model->textInfo($orderInfo['deviceID']);

			$data = [
				'name' => $userInfo['name'],
				'model' => $deviceInfo['model'],
				'category' => $deviceInfo['category'],
				'supply' => $deviceInfo['supply'],
			];
			$this->order_mail->confirm($userInfo['email'], $data);
			$this->output->set_status_header(200);
		} else {
			$this->output->set_status_header(403);
		}
	}

	public function budget() {
		$this->load->library('encryption');
		$this->load->model('user_model');
		$this->load->model('device_model');

		$orderID = $this->input->json('orderID');
		$method = $this->input->json('method');
		$account = $this->input->json('account');
		$transaction = $this->encryption->decrypt($this->input->cookie('userID'));

		$result = $this->order_service->budget($orderID, $method, $account, $transaction);
		if ($result) {
			$orderInfo = $this->order_service->info($orderID);
			$userInfo = $this->user_model->info($orderInfo['userID']);
			$deviceInfo = $this->device_model->textInfo($orderInfo['deviceID']);

			$data = [
				'name' => $userInfo['name'],
				'model' => $deviceInfo['model'],
				'category' => $deviceInfo['category'],
				'supply' => $deviceInfo['supply'],
			];
			$this->order_mail->budget($deviceInfo['supplyEmail'], $data);
			$this->output->set_status_header(200);
		} else {
			$this->output->set_status_header(403);
		}
	}

	public function begin() {
		$orderID = $this->input->json('orderID');
		$result = $this->order_service->begin($orderID);
		$this->output->set_status_header($result ? 200 : 403);
	}

	public function end() {
		$orderID = $this->input->json('orderID');
		$fill = $this->input->json('fill');
		$detail = $this->input->json('detail');
		$result = $this->order_service->end($orderID, $fill, $detail);
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
		$this->load->library('nsession');
		$supplyID = $this->nsession->get('supplyID');
		$this->output->set_json($this->order_service->supplyActive($supplyID));
	}

	public function supplyDone() {
		$this->load->library('nsession');
		$supplyID = $this->nsession->get('supplyID');
		$this->output->set_json($this->order_service->supplyDone($supplyID));
	}

	public function helperActive() {
		$this->output->set_json($this->order_service->helperActive());
	}

	public function helperDone() {
		$this->output->set_json($this->order_service->helperDone());
	}

	public function groupBill() {
		$this->load->library('encryption');
		$groupID = $this->encryption->decrypt($this->input->cookie('groupID'));
		$this->output->set_json($this->order_service->groupBill($groupID));
	}

}
