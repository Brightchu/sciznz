<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Admin extends CI_Controller {

	public function __construct()
	{
		parent::__construct();
		$this->load->library('nsession');
		$this->load->helper('url');

		if (uri_string() !== 'admin/login') {
			if (!$this->nsession->exists('name')) {
				redirect('/admin/login/');
			}
		}
	}

	public function index()
	{
		$this->load->view('admin.html');
	}

	public function login()
	{
		$this->load->model('supervisor');
		$this->load->library('parser');

		if ($this->input->method() === 'post') {
			$result = $this->supervisor->login($this->input->post('username'), $this->input->post('password'));
			if ($result) {
				$this->nsession->set_data($result);
				redirect('/admin/');
			} else{
				$this->parser->parse('adminLogin.html', array('error' => array(array('' => ''))));
			}
		} else{
			$this->parser->parse('adminLogin.html', array('error' => array()));
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

	public function frontCache()
	{
		$this->load->model('portal');

		switch ($this->input->method()) {
			case 'put':
				$this->portal->update();
				break;
		}
	}

	public function frontGroup()
	{
		$this->load->model('group');

		switch ($this->input->method()) {
			case 'get':
				$this->output->set_content_type('application/json')->set_output($this->group->get());
				break;

			case 'put':
				$result = $this->group->set(file_get_contents('php://input'));
				$this->output->set_status_header($result ? 200 : 403);
				break;
		}
	}

	public function frontCategory()
	{
		$this->handler('category');
	}

	public function modelAdmin()
	{
		$this->handler('model');
	}

	public function modelField()
	{
		$this->handler('model_field');
	}

	public function modelKeyword()
	{
		$this->handler('model_keyword');
	}

	public function deviceAdmin()
	{
		$this->handler('device');
	}

	public function deviceField()
	{
		$this->handler('device_field');
	}

	public function deviceKeyword()
	{
		$this->handler('device_keyword');
	}

	public function instituteAdmin()
	{
		$this->handler('institute');
	}

	public function peopleUser()
	{
		$this->handler('user');
	}

	public function peopleStaff()
	{
		$this->handler('operator');
	}

	public function peopleAdmin()
	{
		$this->handler('supervisor');
	}

}
