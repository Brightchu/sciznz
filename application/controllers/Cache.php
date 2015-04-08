<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Cache extends CI_Controller {

	public function index()
	{
		$this->load->model('cache_model');
		$cache_date = $this->cache_model->query_date();

		if ($cache_date === $this->input->get_request_header('If-Modified-Since')) {
			$this->output->set_status_header(304);
		} else {
			$this->output->set_header('Cache-Control: public');
			$this->output->set_header('Last-Modified: ' . $cache_date);
			$this->output->set_content_type('application/json');
			$this->output->set_output($this->cache_model->query());
		}
	}

}
