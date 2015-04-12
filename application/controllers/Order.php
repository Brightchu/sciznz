<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Order extends CI_Controller {

	public function create()
	{
		$this->load->library('encryption');
		$this->load->model('order_model');

		$userID = $this->encryption->decrypt($this->input->cookie('userID'));
		$deviceID = $this->input->json('deviceID');
		$method = $this->input->json('method');
		$date = $this->input->json('date');
		$resource = $this->input->json('resource');

		$result = $this->order_model->create($userID, $deviceID, $method, $date, $resource);
		$this->output->set_status_header($result ? 200 : 403);
	}
	
}
