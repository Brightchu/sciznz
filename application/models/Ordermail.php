<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Ordermail extends CI_Model {

	public function __construct()
	{
		parent::__construct();
		$this->load->library('parser');
		$this->load->library('email');
		$this->email->from('scicompass@sina.com', 'SciCompass');
	}

	/**
	 * Notify a new supervisor
	 * @param 	array $row
	 * @return 	bool
	 */
	public function book($row)
	{
		$row['datetime'] = date(DATE_RSS);
		$this->email->to($row['email']);
		$this->email->subject('You have booked an device on SciCompass');
		$this->email->message($this->parser->parse('mail/book.html', $row, TRUE));
		return $this->email->send();
	}
}
