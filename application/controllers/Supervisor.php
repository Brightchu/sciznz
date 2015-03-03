<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Supervisor extends CI_Controller {

	public function __construct()
	{
		parent::__construct();
		$this->load->library('nsession');
		$this->load->helper('url');

		if (uri_string() !== 'supervisor/login') {
			if (!$this->nsession->exists('name')) {
				redirect('/supervisor/login/');
			}
		}
	}

	public function index()
	{
		$this->load->view('Supervisor.html');
	}

	public function login()
	{
		$this->load->model('admin');
		$this->load->library('parser');

		if ($this->input->method() === 'post') {
			$result = $this->admin->login($this->input->post('username'), $this->input->post('password'));
			if ($result) {
				$this->nsession->set_data($result);
				redirect('/supervisor/');
			} else{
				$this->parser->parse('SupervisorLogin.html', array('error' => array(array('' => ''))));
			}
		} else{
			$this->parser->parse('SupervisorLogin.html', array('error' => array()));
		}
	}

	protected function handler($name)
	{
		$this->load->model($name);

		switch ($this->input->method()) {
			case 'get':
				$this->output->set_json($this->$name->query());
				break;

			case 'put':
				$result = $this->$name->update($this->input->json());
				$this->output->set_status_header($result ? 200 : 403);
				break;

			case 'post':
				$result = $this->$name->save($this->input->json());
				$this->output->set_status_header($result ? 200 : 403);
				break;

			case 'delete':
				$result = $this->$name->delete($this->input->get('ID'));
				$this->output->set_status_header($result ? 200 : 403);
				break;
		}
	}

	public function peopleUser()
	{
		$this->handler('user');
	}

	public function peopleOperator()
	{
		$this->handler('staff');
	}

	public function peopleSupervisor()
	{
		$this->handler('admin');
	}

}
