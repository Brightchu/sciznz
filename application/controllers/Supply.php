<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Supply extends CI_Controller {

	public function __construct()
	{
		parent::__construct();
		$this->load->library('nsession');
		$this->load->helper('url');

		if (uri_string() !== 'supply/login') {
			if (!$this->nsession->exists('name')) {
				redirect('/supply/login/');
			}
		}
	}

	public function index()
	{
		$this->load->view('supply.html');
	}

	public function login()
	{
		$this->load->model('supply');
		$this->load->library('parser');
		$this->load->helper('captcha');

		$error = array();

		if ($this->input->method() === 'post') {
			if ($this->nsession->get('captcha') === strtoupper($this->input->post('captcha'))) {
				$result = $this->supply->login($this->input->post('username'), $this->input->post('password'));
				if ($result) {
					$this->nsession->set_data($result);
					redirect('/supply/');
				} else{
					$error = array(array('text' => '账号密码有误'));
				}
			} else {
				$error = array(array('text' => '验证码有误'));
			}
		}

		$cap = create_captcha();
		$this->nsession->set('captcha', strtoupper($cap['word']));
		$this->parser->parse('supplyLogin.html', array('error' => $error, 'src' => $cap['image']));
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
		}
	}
}
