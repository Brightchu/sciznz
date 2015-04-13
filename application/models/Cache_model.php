<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Cache_model extends CI_Model {

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
		$this->load->model('config_model');
		$this->load->model('device_model');
		$this->load->model('category_model');
		$this->load->model('supply_model');

		// build contain relationshop from device
		$device = $this->device_model->checkout();
		$contain = [];
		foreach ($device as $d) {
			if (isset($contain[$d['category']])) {
				$contain[$d['category']][] = $d['ID'];
			} else {
				$contain[$d['category']] = [$d['ID']];
			}
		}

		// inject contain into hierarchy
		$hierarchy = $this->config_model->hierarchy();
		foreach ($hierarchy as $domain => $featureList) {
			foreach ($featureList as $feature => $categoryList) {
				$map = [];
				foreach ($categoryList as $category) {
					if (isset($contain[$category])) {
						$map[$category] = $contain[$category];
					} else {
						$map[$category] = [];
					}
				}
				$hierarchy[$domain][$feature] = $map;
			}
		}

		// inject unlimit contains into contain
		foreach ($hierarchy as $domain => $featureList) {
			$domainUnlimit = [];
			foreach ($featureList as $feature => $categoryList) {
				$featureUnlimit = [];
				foreach ($categoryList as $category) {
					$featureUnlimit = array_merge($featureUnlimit, $category);
				}
				$contain[$feature] = $featureUnlimit;
				$domainUnlimit = array_merge($domainUnlimit, $featureUnlimit);
			}
			$contain[$domain] = $domainUnlimit;
		}

		// build initial result
		$result = array(
			'hierarchy' => $hierarchy,
			'device' => $device,
			'field' => $this->category_model->field(),
			'index' => array(
				'contain' => $contain,
				'locale' => $this->supply_model->locale(),
			),
		);

		// build feature
		$feature = [];
		$unlimit = [];
		foreach ($hierarchy as $domain => $featureList) {
			$keys = array_keys($featureList);
			$unlimit = array_merge($unlimit, $keys);

			$rows = array_chunk($keys, 7);
			$pair = array(
				'self' => $rows[0],
				'more' => array_slice($rows, 1),
			);
			$feature[$domain] = $pair;
		}
		{
			$rows = array_chunk($unlimit, 7);
			$pair = array(
				'self' => $rows[0],
				'more' => array_slice($rows, 1),
			);
			$feature['不限'] = $pair;
		}
		$result['index']['feature'] = $feature;

		// build category
		$category = [];
		$unlimit = [];
		foreach ($hierarchy as $domain => $featureList) {
			$domainUnlimit = [];
			foreach ($featureList as $feature => $categoryList) {
				$keys = array_keys($categoryList);
				$domainUnlimit = array_merge($domainUnlimit, $keys);

				$rows = array_chunk($keys, 7);

				if (!$rows) {
					$rows = [];
				}

				$category[$feature] = $pair;
			}
			$unlimit = array_merge($unlimit, $domainUnlimit);

			$rows = array_chunk($domainUnlimit, 7);
			$pair = array(
				'self' => $rows[0],
				'more' => array_slice($rows, 1),
			);
			$category[$domain] = $pair;
		}
		{
			$rows = array_chunk($unlimit, 7);
			$pair = array(
				'self' => $rows[0],
				'more' => array_slice($rows, 1),
			);
			$category['不限'] = $pair;
		}
		$result['index']['category'] = $category;

		return $result;
	}
}
