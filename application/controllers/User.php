<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class User extends CI_Controller {

	public function __construct()
	{
		parent::__construct();
		$this->load->library('encryption');
		$this->load->model('user_model');
		$this->load->helper('url');

		if (uri_string() !== 'user/auth' && uri_string() !== 'user/register') {
			if (!is_numeric($this->encryption->decrypt($this->input->cookie('userID')))) {
				redirect('/');
			}
		}
	}

	public function index()
	{
		$this->load->view('user.html');
	}

	public function auth()
	{
		switch ($this->input->method()) {
			case 'post':
				$result = $this->user_model->auth($this->input->json('email'), $this->input->json('password'));
				if ($result) {
					$this->input->set_cookie('name', $result['name'], SECONDS_YEAR);
					$this->input->set_cookie('userID', $this->encryption->encrypt($result['ID']), SECONDS_YEAR);
					unset($result['ID']);
					$this->output->set_json($result);
					break;
				}

			default:
				$this->output->set_status_header(403);
		}
	}

	public function register()
	{
		$this->load->model('account_mail');

		switch ($this->input->method()) {
			case 'post':
				$result = $this->user_model->register($this->input->json('email'), $this->input->json('password'));
				if ($result) {
					$this->input->set_cookie('name', $result['name'], SECONDS_YEAR);
					$this->input->set_cookie('userID', $this->encryption->encrypt($result['ID']), SECONDS_YEAR);
					unset($result['ID']);

					$this->output->set_json($result);
					$this->account_mail->register('user', $this->input->json('email'));
					break;
				}

			default:
				$this->output->set_status_header(403);
		}
	}

	public function payMethod() {
		$this->load->library('encryption');
		$userID = $this->encryption->decrypt($this->input->cookie('userID'));
		$this->output->set_json($this->user_model->payMethod($userID));
	}

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

}
