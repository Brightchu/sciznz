<?php
defined('BASEPATH') OR exit('No direct script access allowed');

require_once(APPPATH . 'controllers/Account.php');

class User extends Account {

	public function info()
	{
		$this->load->library('kvdb');
		$this->load->model('user');

		$session = json_decode($this->kvdb->get('session_' . $this->input->cookie('session')), TRUE);

		switch ($this->input->method()) {
			case 'get':
				$this->output->set_json($this->user->getInfo($session['ID']));
				break;

			case 'put':
				$req = $this->input->json();
				$req['ID'] = $session['ID'];
				$result = $this->user->setInfo($req);
				$this->output->set_status_header($result ? 200 : 403);
				break;

			case 'post':
				$req = $this->input->json();
				$req['ID'] = $session['ID'];
				$result = $this->user->updatePassword($req);
				$this->output->set_status_header($result ? 200 : 403);
				break;
		}
	}

	public function order()
	{
		$this->load->library('kvdb');
		$this->load->model('order');

		$session = json_decode($this->kvdb->get('session_' . $this->input->cookie('session')), TRUE);

		switch ($this->input->method()) {
			case 'get':
				$this->output->set_json($this->order->checkout($session['ID']));
				break;
			case 'put':
				$json = $this->input->json();
				$result = $this->order->setStatus($json);
				if ($json['status'] == 3 && $result) {
					$this->load->model('group_model');
					$result = $this->group_model->pay($session['ID'], $json['ID']);
				}
				$this->output->set_status_header($result ? 200 : 403);
		}
	}
}
