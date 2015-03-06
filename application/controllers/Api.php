<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Api extends CI_Controller {

	public function __construct()
	{
		parent::__construct();
		$this->load->model('portal');
	}

	public function query()
	{
		$cache_date = $this->portal->query_date();

		if ($cache_date === $this->input->get_request_header('If-Modified-Since')) {
			$this->output->set_status_header(304);
		} else {
			$this->input->get_request_header('If-Modified-Since');
			$this->output->set_header('Cache-Control: public');
			$this->output->set_header('Last-Modified: ' . $cache_date);
			$this->output->set_content_type('application/json');
			$this->output->set_output($this->portal->query());
		}
	}
}
