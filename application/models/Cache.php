<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Cache extends CI_Model {

	public function __construct()
	{
		parent::__construct();
		$this->load->library('kvdb');
	}

	/**
	 * Retrive all info from cache
	 *
	 * @return  encoded string json
	 */
	public function query()
	{
		return $this->kvdb->get('cache_query');
	}

	/**
	 * Retrive cache date
	 *
	 * @return  string
	 */
	public function query_date()
	{
		return $this->kvdb->get('cache_query_date');
	}

	/**
	 * Update cache
	 *
	 * @return  bool
	 */
	public function update()
	{
		$this->kvdb->set('cache_query', json_encode($this->build(), JSON_NUMERIC_CHECK));
		$this->kvdb->set('cache_query_date', gmdate('D, d M Y H:i:s T'));
		return TRUE;
	}

	/**
	 * Build all info
	 *
	 * This method is quite costly, need cache
	 * @return  mixed
	 */
	protected function build()
	{
		$this->load->model('hierarchy');
		$this->load->model('device');

		$result = array(
			'hierarchy' => $this->hierarchy->checkout(),
			'device' => $this->device->checkout(),
		);

		return $result;
	}
}
