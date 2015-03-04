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
		$this->output->set_json($this->portal->query());
	}
}
