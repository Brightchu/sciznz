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
		$this->load->helper('captcha');

		$error = array();

		if ($this->input->method() === 'post') {
			if ($this->nsession->get('captcha') === strtoupper($this->input->post('captcha'))) {
				$result = $this->supervisor->login($this->input->post('username'), $this->input->post('password'));
				if ($result) {
					$this->nsession->set_data($result);
					redirect('/admin/');
				} else{
					$error = array(array('text' => '账号密码有误'));
				}
			} else {
				$error = array(array('text' => '验证码有误'));
			}
		}

		$cap = create_captcha();
		$this->nsession->set('captcha', strtoupper($cap['word']));
		$this->parser->parse('adminLogin.html', array('error' => $error, 'src' => $cap['image']));
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

	public function frontModel()
	{
		$this->handler('model');
	}

	public function frontDevice()
	{
		$this->handler('device');
	}

	public function frontCache()
	{
		$this->handler('kvcache');
	}

	public function cacheAdmin()
	{
		$this->load->model('kvadmin');
		switch ($this->input->method()) {
			case 'get':
				$this->output->set_json($this->kvadmin->query());
				break;

			case 'put':
				$result = $this->kvadmin->update($this->input->json());
				$this->output->set_status_header($result ? 200 : 403);
				break;

			case 'delete':
				$result = $this->kvadmin->delete($this->input->get('key'));
				$this->output->set_status_header($result ? 200 : 403);
				break;
		}
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
