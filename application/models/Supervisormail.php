<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Supervisormail extends CI_Model {

	public function __construct()
	{
		parent::__construct();
		$this->load->library('email');
		$this->email->from('scicompass@sina.com', 'SciCompass');
	}

	/**
	 * Notify a supervisor to verify the email address
	 * @param 	array $row
	 * @return 	bool
	 */
	public function register($row)
	{
		$this->email->to($row['email']);
		$this->email->subject('[SciCompass] Activate Admin email address');
		$this->email->message(json_encode($row, JSON_NUMERIC_CHECK));
		return $this->email->send();
	}
}
