<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Account extends CI_Controller {

	protected $role = '';

	public function __construct()
	{
		parent::__construct();

		$this->load->library('nsession');
		$this->load->helper('url');

		if ($this->role) {
			if (uri_string() !== "{$this->role}/login") {
				if (!$this->nsession->exists("{$this->role}ID")) {
					redirect("/{$this->role}/login/");
				}
			}
		} else {
			show_404();
		}
	}

	public function index()
	{
		$this->load->view("{$this->role}.html");
	}

	public function login()
	{
		$modelName = "{$this->role}_model";
		$this->load->model($modelName);
		$this->load->library('parser');
		$this->load->helper('captcha');
		$this->lang->load(['name', 'error']);

		$error = [];

		if ($this->input->method() === 'post') {
			if ($this->nsession->get('captcha') === strtoupper($this->input->post('captcha'))) {
				$result = $this->$modelName->auth($this->input->post('email'), $this->input->post('password'));
				if ($result) {
					$this->nsession->set_data($result);
					redirect('/admin/');
				} else{
					$error = [array('text' => $this->lang->line('E_PASSWORD'))];
				}
			} else {
				$error = [array('text' => $this->lang->line('E_VCODE'))];
			}
		}

		$cap = create_captcha();
		$this->nsession->set('captcha', strtoupper($cap['word']));

		$data = array(
			'role' => $this->role,
			'role_zh' => $this->lang->line($this->role),
			'error' => $error,
			'src' => $cap['image'],
		);

		$this->parser->parse('login.html', $data);
	}

}
