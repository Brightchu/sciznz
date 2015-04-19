<?php
defined('BASEPATH') OR exit('No direct script access allowed');

require_once(APPPATH . 'controllers/Account.php');

class Admin extends Account {

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

	public function frontHierarchy()
	{
		$this->load->model('config_model');

		switch ($this->input->method()) {
			case 'get':
				$this->output->set_json($this->config_model->hierarchy());
				break;

			case 'put':
				$result = $this->config_model->hierarchy($this->input->raw_input_stream);
				$this->output->set_status_header($result ? 200 : 403);
				break;
		}
	}

	public function frontCategory()
	{
		$this->handler('category_model');
	}

	public function frontModel()
	{
		$this->handler('model_model');
	}

	public function frontDevice()
	{
		$this->handler('device');
	}

	public function frontCache()
	{
		$this->handler('cache_model');
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

	public function supplyAdmin()
	{
		$this->handler('supply');
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
		$this->handler('admin_model');
	}

}
