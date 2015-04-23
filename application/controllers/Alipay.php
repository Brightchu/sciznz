<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Alipay extends CI_Controller {

	public function __construct() {
		parent::__construct();
		$this->load->model('alipay_service');
		$this->load->helper('url');
	}

	public function budgetCreate($orderID) {
		redirect($this->alipay_service->budgetCreate($orderID));
	}

	public function budgetNotify() {
		$this->load->model('order_service');
		$trade_no = $this->input->post('trade_no');
		$orderID = $this->input->post('out_trade_no');
		$buyer_email = $this->input->post('buyer_email');

		if ($this->order_service->budget($orderID, 'ALIPAY', $buyer_email, $trade_no)) {
			$this->output->set_output('success');
		}
	}

	public function fillCreate($orderID) {
		redirect($this->alipay_service->fillCreate($orderID));
	}

	public function fillNotify() {
		$this->load->model('order_service');
		$trade_no = $this->input->post('trade_no');
		$orderID = $this->input->post('out_trade_no');
		$buyer_email = $this->input->post('buyer_email');

		if ($this->order_service->fill($orderID, 'ALIPAY', $buyer_email, $trade_no)) {
			$this->output->set_output('success');
		}
	}
}
