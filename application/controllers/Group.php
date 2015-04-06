<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Group extends CI_Controller {

	public function __construct()
	{
		parent::__construct();
		$this->load->library('nsession');
		$this->load->helper('url');

		if (uri_string() !== 'group/login') {
			if (!$this->nsession->exists('name')) {
				redirect('/group/login/');
			}
		}
	}

	public function index()
	{
		$this->load->view('group.html');
	}

	public function login()
	{
		$this->load->model('group_model');
		$this->load->library('parser');
		$this->load->helper('captcha');

		$error = [];

		if ($this->input->method() === 'post') {
			if ($this->nsession->get('captcha') === strtoupper($this->input->post('captcha'))) {
				$result = $this->group_model->login($this->input->post('email'), $this->input->post('password'));
				if ($result) {
					$this->nsession->set_data($result);
					redirect('/group/');
				} else{
					$error = array(array('text' => '账号密码有误'));
				}
			} else {
				$error = array(array('text' => '验证码有误'));
			}
		}

		$cap = create_captcha();
		$this->nsession->set('captcha', strtoupper($cap['word']));
		$this->parser->parse('groupLogin.html', array('error' => $error, 'src' => $cap['image']));
	}

	public function info()
	{
		$this->load->library('kvdb');
		$this->load->model('group_model');

		switch ($this->input->method()) {
			case 'get':
				$this->output->set_json($this->group_model->getInfo($this->nsession->get('ID')));
				break;

			case 'put':
				$req = $this->input->json();
				$req['ID'] = $this->nsession->get('ID');
				$result = $this->group_model->setInfo($req);
				$this->output->set_status_header($result ? 200 : 403);
				break;

			case 'post':
				$req = $this->input->json();
				$req['ID'] = $this->nsession->get('ID');
				$result = $this->group_model->updatePassword($req);
				$this->output->set_status_header($result ? 200 : 403);
				break;
		}
	}

	public function order()
	{
		$this->load->library('kvdb');
		$this->load->model('order');

		$ID = $this->nsession->get('ID');

		switch ($this->input->method()) {
			case 'get':
				$this->output->set_json($this->order->getUnread($ID));
				break;

			case 'put':
				$result = $this->order->setStatus($this->input->json());
				$this->output->set_status_header($result ? 200 : 403);
				break;
		}
	}

	public function member()
	{
		$this->load->model('user');

		switch ($this->input->method()) {
			case 'get':
				$this->output->set_json($this->user->getMember($this->nsession->get('ID')));
				break;

			case 'post':
				$result = $this->user->addMember($this->nsession->get('ID'), $this->input->json('email'));
				$this->output->set_status_header($result ? 200 : 403);
				break;

			case 'delete':
				$result = $this->user->deleteMember($this->input->get('ID'));
				$this->output->set_status_header($result ? 200 : 403);
				break;
		}
	}
}
