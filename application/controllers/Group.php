<?php
defined('BASEPATH') OR exit('No direct script access allowed');

require_once(APPPATH . 'controllers/Account.php');

class Group extends Account {

	public function __construct() {
		parent::__construct();
		$this->load->model('group_model');
	}

	public function info()
	{
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

	public function bill()
	{
		$this->load->model('group_model');

		switch ($this->input->method()) {
			case 'get':
				$this->output->set_json($this->group_model->bill($this->nsession->get('ID')));
				break;
		}
	}
}
