<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Supervisor extends CI_Controller {

	public function __construct()
	{
		parent::__construct();
		$this->load->library(array('nsession', 'parser'));
		$this->load->model('admin');
	}

	public function index()
	{
		if ($this->nsession->exists('name')) {
			echo "success";
		} else{
			$this->output->set_header('Location: /supervisor/login/');
		}
	}

	public function login()
	{
		if ($this->input->method() === 'post') {
			$result = $this->admin->login($this->input->post('username'), $this->input->post('password'));
			if ($result) {
				$this->nsession->set_data($result);
				$this->output->set_header('Location: /supervisor/');
			} else{
				$this->parser->parse('SupervisorLogin.html', array('error' => array(array('' => ''))));
			}
		} else{
			$this->parser->parse('SupervisorLogin.html', array('error' => array()));
		}
	}
}
