<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Portal extends CI_Model {

	public function __construct()
	{
		parent::__construct();
		$this->load->database('slave');
	}

	/**
	 * Retrive all info
	 *
	 * This method is quite costy, need cache
	 * @return  mixed
	 */
	public function query()
	{
		$data = array();
		$keyword = array();

		$category = array();
		$sql = 'SELECT `category`.`ID`, `category`.`name`, `category`.`info`, `category_field`.`name` AS `field` FROM `category` LEFT JOIN `category_field` ON `category`.`ID` = `category_field`.`categoryID` ORDER BY `category_field`.`rank` ASC';
		foreach ($this->db->query($sql)->result_array() as $row) {
			if (isset($category[$row['name']])) {
				$category[$row['name']]['field'][] = $row['field'];
			} else {
				$name = $row['name'];
				unset($row['name']);

				if (isset($row['field'])) {
					// Push field(may be duplicate) to keyword
					if (!isset($keyword[$row['field']])) {
						$keyword[$row['field']] = array(
							'type' => 'field'
						);
					}
					// End keyword

					$row['field'] = array($row['field']);
				} else {
					$row['field'] = array();
				}

				$category[$name] = $row;

				// Push category(never duplicate) to keyword
				$keyword[$name] = array(
					'type' => 'category',
					'ID' => $row['ID']
				);
				// End keyword
			}
		}
		$data['category'] = $category;

		$group = array();
		$sql = 'SELECT `category_keyword`.`name`, `category_keyword`.`rank`, `category`.`name` AS `category`, `category`.`ID` FROM `category_keyword` JOIN `category` ON `category_keyword`.`categoryID` = `category`.`ID`';
		foreach ($this->db->query($sql)->result_array() as $row) {
			if(!isset($group[$row['rank']])) {
				$group[$row['rank']] = array();
			}

			if(!isset($group[$row['rank']][$row['name']])) {
				$group[$row['rank']][$row['name']] = array();

				// Push group(never duplicate) to keyword
				$keyword[$row['name']] = array(
					'type' => 'group',
					'ID' => $row['ID']
				);
				// End keyword
			}

			$group[$row['rank']][$row['name']][] = $row['category'];
		}

		$data['group'] = $group;

		$data['keyword'] = $keyword;
		return $data;
	}

}
