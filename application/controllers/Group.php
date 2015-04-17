<?php
defined('BASEPATH') OR exit('No direct script access allowed');

require_once(APPPATH . 'controllers/Account.php');

class Group extends Account {

	public function __construct() {
		parent::__construct();
		$this->load->model('group_model');
	}

	public function member()
	{
		switch ($this->input->method()) {
			case 'get':
				$this->output->set_json($this->group_model->getMember($this->roleID));
				break;

			case 'post':
				$result = $this->group_model->addMember($this->roleID, $this->input->json('email'));
				$this->output->set_status_header($result ? 200 : 403);
				break;

			case 'delete':
				$result = $this->group_model->deleteMember($this->roleID, $this->input->get('userID'));
				$this->output->set_status_header($result ? 200 : 403);
				break;
		}
	}

	public function bill() {
		$this->output->set_json($this->group_model->bill($this->roleID));
	}

}
