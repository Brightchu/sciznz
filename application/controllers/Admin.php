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
		$this->handler('device_model');
	}

	public function frontCache()
	{
		$this->handler('cache_model');
	}

	public function cacheAdmin()
	{
		$this->load->model('kvdb_model');
		switch ($this->input->method()) {
			case 'get':
				$this->output->set_json($this->kvdb_model->query());
				break;

			case 'put':
				$result = $this->kvdb_model->update($this->input->json());
				$this->output->set_status_header($result ? 200 : 403);
				break;

			case 'delete':
				$result = $this->kvdb_model->delete($this->input->get('key'));
				$this->output->set_status_header($result ? 200 : 403);
				break;
		}
	}


	public function peopleUser()
	{
		$this->handler('user_model');
	}

	public function peopleSupply()
	{
		$this->handler('supply_model');
	}

	public function peopleGroup()
	{
		$this->handler('group_model');
	}

	public function peopleHelper()
	{
		$this->handler('helper_model');
	}

	public function peopleAdmin()
	{
		$this->handler('admin_model');
	}

}
