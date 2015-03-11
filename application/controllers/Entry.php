<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Entry extends CI_Controller {

	public function index()
	{
		$this->load->view('entry.html');
	}

	public function mail()
	{
		$this->load->library('email');

		$this->email->from('scicompass@sina.com', 'Yuzo');
		$this->email->to('1104405025@qq.com');

		$this->email->subject(gmdate('D, d M Y H:i:s T'));
		$this->email->message(date(DATE_ATOM));

		$this->email->send();
	}
}
