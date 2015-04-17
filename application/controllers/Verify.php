<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Verify extends CI_Controller {

	public function index()
	{
		$this->load->library('parser');
		$this->load->library('encryption');
		$this->load->model('user_model');

		$token = base64_decode($this->input->get('token'));
		$email = $this->encryption->decrypt($token);

		if ($email && $this->user_model->verifyEmail($email)) {
			$this->parser->parse('mail/register/success.html', ['email' => $email]);
		} else {
			$this->load->view('mail/register/fail.html');
		}
	}

}
