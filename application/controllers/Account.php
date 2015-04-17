<?php
defined('BASEPATH') OR exit('No direct script access allowed');

abstract class Account extends CI_Controller {

	protected $role = '';

	public function __construct()
	{
		parent::__construct();

		$this->load->library('nsession');
		$this->load->helper('url');
		$this->role = strtolower(get_called_class());
		$this->roleID = $this->nsession->get("{$this->role}ID");

		if (uri_string() !== "{$this->role}/login") {
			if (!$this->roleID) {
				redirect("/{$this->role}/login/");
			}
		}
	}

	public function index()
	{
		$this->load->view("{$this->role}.html");
	}

	public function login()
	{
		$model = "{$this->role}_model";
		$this->load->model($model);
		$this->load->library('parser');
		$this->load->helper('captcha');
		$this->lang->load(['name', 'error']);

		$error = [];

		if ($this->input->method() === 'post') {
			if ($this->nsession->get('captcha') === strtoupper($this->input->post('captcha'))) {
				$result = $this->$model->auth($this->input->post('email'), $this->input->post('password'));
				if ($result) {
					$this->nsession->set("{$this->role}ID", $result['ID']);
					$this->nsession->set('name', $result['name']);
					redirect("/{$this->role}/");
				} else{
					$error = [['text' => $this->lang->line('E_PASSWORD')]];
				}
			} else {
				$error = [['text' => $this->lang->line('E_VCODE')]];
			}
		}

		$cap = create_captcha();
		$this->nsession->set('captcha', strtoupper($cap['word']));

		$data = [
			'role' => $this->role,
			'role_zh' => $this->lang->line($this->role),
			'error' => $error,
			'src' => $cap['image'],
		];

		$this->parser->parse('login.html', $data);
	}

	public function info() {
		$model = "{$this->role}_model";
		$this->load->model($model);
		$ID = $this->nsession->get("{$this->role}ID");
		$this->output->set_json($this->$model->info($ID));
	}

	public function updatePassword() {
		$model = "{$this->role}_model";
		$this->load->model($model);

		$ID = $this->nsession->get("{$this->role}ID");
		$oldPassword = $this->input->json('oldPassword');
		$newPassword = $this->input->json('newPassword');

		$result = $this->$model->updatePassword($ID, $oldPassword, $newPassword);
		$this->output->set_status_header($result ? 200 : 403);
	}

}
