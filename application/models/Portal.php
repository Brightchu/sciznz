<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Portal extends CI_Model {

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
		$this->kvdb->set('cache_query', json_encode($this->build(), TRUE));
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
		$this->load->database('slave');

		$data = array(
			'group' => $this->group(),
			'category' => $this->category(),
			'model' => $this->model(),
		);

		return $data;
	}

	protected function group()
	{
		$sql = 'SELECT `value` FROM `config` WHERE `key` = "group"';
		$group = $this->db->query($sql)->row_array();

		return json_decode($group['value'], TRUE);
	}

	protected function category()
	{
		$sql = 'SELECT `ID`, `name`, `field`, `info` FROM `category`';
		$category = $this->db->query($sql)->result_array();

		foreach ($category as $index => $row) {
			if (empty($row['field'])) {
				$category[$index]['field'] = array();
			} else {
				$category[$index]['field'] = json_decode($row['field'], TRUE);
			}
		}

		return $category;
	}

	protected function model()
	{
		$model = array();
		return $model;
	}
}
