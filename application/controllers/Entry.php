<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Entry extends CI_Controller {

	public function index()
	{
		$this->load->view('entry.html');
	}

	public function test()
	{
		$this->load->helper('captcha');
		$cap = create_captcha();
		var_dump($cap);
	}
}
