<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Checkout extends CI_Model {

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
		$result = array();

		// hierarchy
		$sql = 'SELECT `value` FROM `config` WHERE `key` = "hierarchy"';
		$row = $this->db->query($sql)->row_array();
		$result['hierarchy'] = json_decode($row['value'], TRUE);

		// filter
		$filter = array();
		foreach ($result['hierarchy'] as $group) {
			$ingroup = array();
			foreach ($group['child'] as $subgroup) {
				$filter[$subgroup['name']] = $subgroup['child'];
				$ingroup = array_merge($ingroup, $subgroup['child']);
			}
			$filter[$group['name']] = $ingroup;
		}
		$result['filter'] = $filter;

		// data
		$sql = 'SELECT * FROM `data`';
		$data = $this->db->query($sql)->result_array();
		foreach ($data as $index => $row) {
			$data[$index]['field'] = array_merge(json_decode($row['field'], TRUE), json_decode($row['subfield'], TRUE));
			unset($data[$index]['subfield']);
		}
		$result['data'] = $data;

		// address
		$sql = 'SELECT DISTINCT `address` FROM `device`';
		$address = array_column($this->db->query($sql)->result_array(), 'address');
		$result['address'] = $address;

		return $result;
	}
}
