<?php
defined('BASEPATH') OR exit('No direct script access allowed');

require_once(APPPATH . 'controllers/Account.php');

class Supply extends Account {

	public function order()
	{
		$this->load->library('kvdb');
		$this->load->model('order');

		$ID = $this->nsession->get('ID');

		switch ($this->input->method()) {
			case 'get':
				$this->output->set_json($this->order->getUnread($ID));
				break;

			case 'put':
				$result = $this->order->setStatus($this->input->json());
				$this->output->set_status_header($result ? 200 : 403);
		}
	}
}
