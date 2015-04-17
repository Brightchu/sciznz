<?php
defined('BASEPATH') OR exit('No direct script access allowed');

require_once(APPPATH . 'controllers/Account.php');

class User extends Account {

	protected function initialize() {
		$this->load->helper('url');
		$this->load->library('encryption');
		$this->load->model('user_model');

		$this->role = 'user';
		$this->roleID = $this->encryption->decrypt($this->input->cookie('userID'));

		if (uri_string() !== 'user/auth' && uri_string() !== 'user/register') {
			if (!$this->roleID) {
				redirect('/');
			}
		}
	}

	public function auth() {
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

	public function updateInfo() {
		$name = $this->input->json('name');
		$phone = $this->input->json('phone');

		$result = $this->user_model->updateName($this->roleID, $name) && $this->user_model->updatePhone($this->roleID, $phone);
		$this->output->set_status_header($result ? 200 : 403);
	}

}
