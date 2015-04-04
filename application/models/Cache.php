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

		$hierarchy = $this->hierarchy->checkout();
		$device = $this->device->checkout();

		$result = [];
		$result['device'] = $device;

		// build contain relationshop
		$contain = [];
		foreach ($device as $d) {
			if (isset($contain[$d['category']])) {
				$contain[$d['category']][] = $d['ID'];
			} else {
				$contain[$d['category']] = [$d['ID']];
			}
		}

		// inject contain into hierarchy
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
		$result['hierarchy'] = $hierarchy;

		// build feature
		$feature = [];
		$allFeature = [];
		foreach ($hierarchy as $domain => $featureList) {
			$keys = array_keys($featureList);
			$allFeature = array_merge($allFeature, $keys);
			$rows = array_chunk($keys, 7);
			$pair = array(
				'self' => $rows[0],
				'more' => array_slice($rows, 1),
			);
			$feature[$domain] = $pair;
		}
		$rows = array_chunk($allFeature, 7);
		$pair = array(
			'self' => $rows[0],
			'more' => array_slice($rows, 1),
		);
		$feature['不限'] = $pair;
		$result['feature'] = $feature;

		// build category
		$category = [];
		$_category = [];
		$allCategory = [];
		foreach ($hierarchy as $domain => $featureList) {
			$_domain = [];
			foreach ($featureList as $feature => $categoryList) {
				$keys = array_keys($categoryList);
				$_category[$feature] = $keys;
				$_domain = array_merge($_domain, $keys);
			}
			$_category[$domain] = $_domain;
			$allCategory = array_merge($allCategory, $_domain);
		}
		$_category['不限'] = $allCategory;

		foreach ($_category as $name => $list) {
			$rows = array_chunk($list, 7);
			$pair = array(
				'self' => $rows[0],
				'more' => array_slice($rows, 1),
			);
			$category[$name] = $pair;
		}
		$result['category'] = $category;

		return $result;
	}
}
