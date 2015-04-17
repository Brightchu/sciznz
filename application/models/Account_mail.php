<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Account_mail extends CI_Model {

	public function __construct()
	{
		parent::__construct();
		$this->load->library('parser');
		$this->load->library('email');
		$this->email->from('scicompass@sina.com', 'Sciclubs');
	}

	/**
	 * Request verify a new account
	 * @param 	$role, $email
	 * @return 	bool
	 */
	public function register($role, $email)
	{
		$this->load->library('encryption');
		$this->email->to($email);
		$this->email->subject('Sciclubs邮箱验证');
		$this->load->helper('url');

		$data = [
			'email' => $email,
			'link' => site_url('verify?token=' . base64_encode($this->encryption->encrypt($email))),
			'logo' => site_url('static/img/logo-landscape.png'),
			'datetime' => date(DATE_RSS),
		];

		$this->email->message($this->parser->parse("mail/register/{$role}.html", $data, TRUE));
		return $this->email->send();
	}
}
