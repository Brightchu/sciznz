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
	 * This method is quite costly, need cache
	 * @return  mixed
	 */
	public function query()
	{
		$data = array();

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
		$data['category'] = $category;

		$sql = 'SELECT `value` FROM `config` WHERE `key` = "group"';
		$group = $this->db->query($sql)->row_array();

		$data['group'] = json_decode($group['value'], TRUE);
		return $data;
	}

}
