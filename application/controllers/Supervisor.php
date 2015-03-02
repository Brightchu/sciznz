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

	public function peopleUser()
	{
		$this->load->model('user');

		switch ($this->input->method()) {
			case 'get':
				$this->output->set_json($this->user->query());
				break;

			case 'put':
				$result = $this->user->update($this->input->json());
				$this->output->set_status_header($result ? 200 : 403);
				break;

			case 'post':
				$result = $this->user->save($this->input->json());
				$this->output->set_status_header($result ? 200 : 403);
				break;

			case 'delete':
				$result = $this->user->delete($this->input->get('ID'));
				$this->output->set_status_header($result ? 200 : 403);
				break;
		}
	}

	public function peopleOperator()
	{
		$this->load->model('staff');

		switch ($this->input->method()) {
			case 'get':
				$this->output->set_json($this->staff->query());
				break;

			case 'put':
				$result = $this->staff->update($this->input->json());
				$this->output->set_status_header($result ? 200 : 403);
				break;

			case 'post':
				$result = $this->staff->save($this->input->json());
				$this->output->set_status_header($result ? 200 : 403);
				break;

			case 'delete':
				$result = $this->staff->delete($this->input->get('ID'));
				$this->output->set_status_header($result ? 200 : 403);
				break;
		}
	}

	public function peopleSupervisor()
	{
		$this->load->model('admin');

		switch ($this->input->method()) {
			case 'get':
				$this->output->set_json($this->admin->query());
				break;

			case 'put':
				$result = $this->admin->update($this->input->json());
				$this->output->set_status_header($result ? 200 : 403);
				break;

			case 'post':
				$result = $this->admin->save($this->input->json());
				$this->output->set_status_header($result ? 200 : 403);
				break;

			case 'delete':
				$result = $this->admin->delete($this->input->get('ID'));
				$this->output->set_status_header($result ? 200 : 403);
				break;
		}
	}

}
