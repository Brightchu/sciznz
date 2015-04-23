<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Alipay extends CI_Controller {

	public function __construct() {
		parent::__construct();
		$this->load->model('alipay_service');
		$this->load->helper('url');
	}

	public function create($orderID) {
		redirect($this->alipay_service->create($orderID));
	}

}
