<?php
defined('BASEPATH') OR exit('No direct script access allowed');

require_once(APPPATH . 'models/Account_model.php');

class User_model extends Account_model {

	protected $role = 'user';

}
