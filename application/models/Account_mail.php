<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Account_mail extends CI_Model {

	public function __construct()
	{
		parent::__construct();
		$this->load->library('parser');
		$this->load->library('email');
		$this->email->from('scicompass@sina.com', 'SciCompass');
	}

	/**
	 * Notify a new account
	 * @param 	$role, $email, $name
	 * @return 	bool
	 */
	public function register($role, $email, $name)
	{
		$this->email->to($email);
		$this->email->subject('SciCompass notification');

		$data = array(
			'name' => $name,
			'datetime' => date(DATE_RSS),
		);

		$this->email->message($this->parser->parse("mail/{$role}Register.html", $data, TRUE));
		return $this->email->send();
	}
}
