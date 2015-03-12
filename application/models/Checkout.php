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

		$data = array(
			'hierarchy' => $this->hierarchy(),
			'content' => $this->content(),
		);

		return $data;
	}

	protected function hierarchy()
	{
		$sql = 'SELECT `value` FROM `config` WHERE `key` = "hierarchy"';
		$row = $this->db->query($sql)->row_array();

		return json_decode($row['value'], TRUE);
	}

	protected function content()
	{
		$sql = 'SELECT * FROM `content`';
		$content = $this->db->query($sql)->result_array();

		foreach ($content as $index => $row) {
			$content[$index]['field'] = json_decode($row['field'], TRUE);
			$content[$index]['subfield'] = json_decode($row['subfield'], TRUE);
			$content[$index]['field'] = array_merge($content[$index]['field'], $content[$index]['subfield']);
			unset($content[$index]['subfield']);
		}

		return $content;
	}

}
