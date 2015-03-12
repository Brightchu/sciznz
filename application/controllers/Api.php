<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Api extends CI_Controller {

	public function __construct()
	{
		parent::__construct();
	}

	public function query()
	{
		$this->load->model('checkout');
		$cache_date = $this->checkout->query_date();

		if ($cache_date === $this->input->get_request_header('If-Modified-Since')) {
			$this->output->set_status_header(304);
		} else {
			$this->output->set_header('Cache-Control: public');
			$this->output->set_header('Last-Modified: ' . $cache_date);
			$this->output->set_content_type('application/json');
			$this->output->set_output($this->checkout->query());
		}
	}

	public function login()
	{
		$this->load->model('user');
		$this->load->library('nsession');

		if ($this->input->method() == 'post') {
			$result = $this->user->login($this->input->json('username'), $this->input->json('password'));
			if ($result) {
				$this->nsession->set_data($result);
				$this->output->set_status_header(200);
				$this->output->set_output($result['name']);
			} else {
				$this->output->set_status_header(403);
			}
		}
	}
}
