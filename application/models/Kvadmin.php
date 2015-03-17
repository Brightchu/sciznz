<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Kvadmin extends CI_Model {

	public function __construct()
	{
		parent::__construct();
		$this->load->library('kvdb');
	}

	/**
	 * Retrive all key-value from kvdb
	 *
	 * @return  array
	 */
	public function query()
	{
		$collection = array();
		foreach ($this->kvdb->pkrget('') as $key => $value) {
			$collection[] = array(
				'key' => $key,
				'value' => $value,
			);
		}
		return $collection;
	}

	public function update($pair)
	{
		return $this->kvdb->set($pair['key'], $pair['value']);
	}

	public function delete($key)
	{
		return $this->kvdb->delete($key);
	}

}
