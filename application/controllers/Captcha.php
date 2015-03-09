<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Captcha extends CI_Controller {

	public function index($filename = '')
	{
		$this->load->helper('file');

		$this->output->set_header('Content-Type: ' . get_mime_by_extension($filename));
		readfile('/tmp/' . $filename);
	}

}
