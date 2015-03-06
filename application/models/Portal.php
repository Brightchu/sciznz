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
		$category = array();

		$sql = 'SELECT `category`.`ID`, `category`.`name`, `category`.`info`, `category_field`.`name` AS `field` FROM `category` LEFT JOIN `category_field` ON `category`.`ID` = `category_field`.`categoryID` ORDER BY `category_field`.`rank` ASC';
		foreach ($this->db->query($sql)->result_array() as $row) {
			if (isset($category[$row['name']])) {
				$category[$row['name']]['field'][] = $row['field'];
			} else {
				if (isset($row['field'])) {
					$row['field'] = array($row['field']);
				} else {
					$row['field'] = array();
				}

				$name = $row['name'];
				unset($row['name']);
				$category[$name] = $row;
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
