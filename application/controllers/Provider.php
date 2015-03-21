<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Provider extends CI_Controller {

	public function __construct()
	{
		parent::__construct();
		$this->load->library('nsession');
		$this->load->helper('url');

		if (uri_string() !== 'provider/login') {
			if (!$this->nsession->exists('name')) {
				redirect('/provider/login/');
			}
		}
	}

	public function index()
	{
		$this->load->view('provider.html');
	}

	public function login()
	{
		$this->load->model('institute');
		$this->load->library('parser');
		$this->load->helper('captcha');

		$error = array();

		if ($this->input->method() === 'post') {
			if ($this->nsession->get('captcha') === strtoupper($this->input->post('captcha'))) {
				$result = $this->institute->login($this->input->post('username'), $this->input->post('password'));
				if ($result) {
					$this->nsession->set_data($result);
					redirect('/provider/');
				} else{
					$error = array(array('text' => '账号密码有误'));
				}
			} else {
				$error = array(array('text' => '验证码有误'));
			}
		}

		$cap = create_captcha();
		$this->nsession->set('captcha', strtoupper($cap['word']));
		$this->parser->parse('providerLogin.html', array('error' => $error, 'src' => $cap['image']));
	}

}
