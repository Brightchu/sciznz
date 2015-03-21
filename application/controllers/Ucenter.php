<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Ucenter extends CI_Controller {

	public function index()
	{
		$this->load->view('ucenter.html');
	}

	public function info()
	{
		$this->load->library('kvdb');
		$this->load->model('user');

		$session = json_decode($this->kvdb->get('session_' . $this->input->cookie('session')), TRUE);
		$userID = $session['ID'];

		switch ($this->input->method()) {
			case 'get':
				$this->output->set_json($this->user->getInfo($userID));
				break;

			case 'put':
				$req = $this->input->json();
				$req['ID'] = $userID;
				$result = $this->user->setInfo($req);
				$this->output->set_status_header($result ? 200 : 403);
				break;

			case 'post':
				$req = $this->input->json();
				$req['ID'] = $userID;
				$result = $this->user->updatePassword($req);
				$this->output->set_status_header($result ? 200 : 403);
				break;
		}
	}
}
