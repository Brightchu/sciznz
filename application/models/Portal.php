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
	 * @return  array
	 */
	public function query()
	{
		$data = array();

		$category = array();
		$sql = 'SELECT `category`.`ID`, `category`.`name`, `category`.`info`, `category_field`.`name` AS `field` FROM `category` LEFT JOIN `category_field` ON `category`.`ID` = `category_field`.`categoryID` ORDER BY `category_field`.`rank` ASC';
		foreach ($this->db->query($sql)->result_array() as $row) {
			if (isset($category[$row['ID']])) {
				$category[$row['ID']]['field'][] = $row['field'];
			} else {
				$ID = $row['ID'];
				unset($row['ID']);

				if (isset($row['field'])) {
					$row['field'] = array($row['field']);
				} else {
					$row['field'] = array();
				}

				$category[$ID] = $row;
			}
		}
		$data['category'] = $category;

		$group = array();
		$sql = 'SELECT `categoryID`, `name`, `rank` FROM `category_keyword`';
		foreach ($this->db->query($sql)->result_array() as $row) {
			if(!isset($group[$row['rank']])) {
				$group[$row['rank']] = array();
			}

			if(!isset($group[$row['rank']][$row['name']])) {
				$group[$row['rank']][$row['name']] = array();
			}

			$group[$row['rank']][$row['name']][] = $row['categoryID'];
		}

		$data['group'] = $group;
		return $data;
	}

}
