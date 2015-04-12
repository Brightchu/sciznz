<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Device extends CI_Controller {

	public function schedule()
	{
		$deviceID = $this->input->get('deviceID');
		$date = $this->input->get('date');

		$this->load->model('usage_model');
		$this->load->model('device_model');

		$schedule = $this->device_model->resource($deviceID);
		$usage = $this->usage_model->resource($deviceID, $date);

		$week = getdate(strtotime($date))['wday'];
		if (in_array($week, $schedule['workday'])) {
			$type = array_column($usage, 'type');
			if (in_array('RESERVE', $type)) {
				$schedule = [
					'method' => [],
					'reason' => 'RESERVE',
				];
			} else {
				foreach ($usage as $row) {
					if ($row['type'] == 'ORDER') {
						$schedule['resource'][$row['resource']][3] = $row['count'];
					}
				}
			}
		} else {
			$schedule = [
				'method' => [],
				'reason' => 'WEEKEND',
			];
		}

		$this->output->set_json($schedule);
	}

}
