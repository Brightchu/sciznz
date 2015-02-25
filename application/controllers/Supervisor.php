<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Supervisor extends CI_Controller {

	public function __construct()
	{
		parent::__construct();
		$this->load->library('session');
		$this->load->model('supervisor_model');
	}

	public function index()
	{
		if($this->session->has_userdata('name')){
			echo "success";
		} else{
			$this->output->set_header('Location: /supervisor/login/');
		}
	}

	public function login()
	{
		if($this->input->method() == 'post'){
			$result = $this->supervisor_model->login($this->input->post('username'), $this->input->post('password'));
			if($result){
				$this->session->set_userdata($result);
				$this->output->set_header('Location: /supervisor/');
			} else{
				echo "false";
			}
		} else{
			$this->load->view('SupervisorLogin.html');
		}
	}
}
