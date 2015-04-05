<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Api extends CI_Controller {

	public function __construct()
	{
		parent::__construct();
	}

	public function query()
	{
		$this->load->model('cache');
		$cache_date = $this->cache->query_date();

		if ($cache_date === $this->input->get_request_header('If-Modified-Since')) {
			$this->output->set_status_header(304);
		} else {
			$this->output->set_header('Cache-Control: public');
			$this->output->set_header('Last-Modified: ' . $cache_date);
			$this->output->set_content_type('application/json');
			$this->output->set_output($this->cache->query());
		}
	}

	public function user()
	{
		$this->load->model('user');
		$this->load->library('kvdb');
		$this->load->helper('cookie');

		switch ($this->input->method()) {
			case 'put':
				$result = $this->user->login($this->input->json('email'), $this->input->json('password'));
				if ($result) {
					$result['timestamp'] = time();

					$value = json_encode($result, JSON_NUMERIC_CHECK);
					$key = sha1($value);
					$this->kvdb->set('session_' . $key, $value);

					set_cookie('session', $key, 31536000);
					set_cookie('name', $result['name'], 31536000);
					$this->output->set_status_header(200);
				} else {
					$this->output->set_status_header(403);
				}
				break;

			case 'post':
				$row = $this->input->json();
				$row['name'] = $row['email'];
				$row['credit'] = 0;
				$row['phone'] = '';

				$result = $this->user->save($row);
				if ($result) {
					$result = array(
						'ID' => $this->user->db->insert_id(),
						'name' => $row['name'],
						'credit' => $row['credit'],
						'timestamp' => time(),
					);

					$value = json_encode($result, JSON_NUMERIC_CHECK);
					$key = sha1($value);
					$this->kvdb->set('session_' . $key, $value);

					set_cookie('session', $key, 31536000);
					set_cookie('name', $result['name'], 31536000);
					$this->output->set_status_header(200);
				} else {
					$this->output->set_status_header(403);
				}
				break;
		}
	}

	public function order()
	{
		$this->load->model('order');
		$this->load->library('kvdb');

		switch ($this->input->method()) {
			case 'get':
				$deviceID = $this->input->get('deviceID');
				$useDate = $this->input->get('useDate');
				$this->output->set_json($this->order->count($deviceID, $useDate));
				break;

			case 'post':
				$session = json_decode($this->kvdb->get('session_' . $this->input->cookie('session')), TRUE);
				$req = $this->input->json();
				$req['userID'] = $session['ID'];
				$result = $this->order->book($req);
				$this->output->set_status_header($result ? 200 : 403);
				break;
		}
	}
}
