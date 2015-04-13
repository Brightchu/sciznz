<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Device extends CI_Controller {

	public function schedule($ID) {
		$this->load->model('device_model');
		$this->output->set_json($this->device_model->schedule($ID));
	}

	public function resource($ID, $date) {
		$this->load->model('usage_model');
		$this->load->model('device_model');

		$schedule = $this->device_model->schedule($ID);
		$usage = $this->usage_model->usage($ID, $date);

		$resource = $schedule['resource'];
		$week = getdate(strtotime($date))['wday'];

		if (in_array($week, $schedule['workday'])) {
			// rely on ASC order between ORDER and RESERVE
			foreach ($usage as $row) {
				if ($row['type'] === 'RESERVE') {
					$resource[$row['resource']]['count'] = $resource[$row['resource']]['capacity'];
				} else {
					$resource[$row['resource']]['count'] = $row['count'];
				}
			}
			$this->output->set_json($resource);
		}
	}

}
