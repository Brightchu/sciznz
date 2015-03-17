<?php
/**
 * CodeIgniter for SAE
 * Kvdb Class
 *
 * @package	CodeIgniter
 * @author Yuzo
 */
defined('BASEPATH') OR exit('No direct script access allowed');

if (defined('SAE_APPNAME')) {
	class Kvdb extends SaeKV {
		public function __construct()
		{
			parent::__construct();
			$this->init();
		}
	}
} else{
	class Kvdb extends Redis {

		const EMPTY_PREFIXKEY  = '';
		const MAX_MGET_SIZE  = 32;
		const MAX_PKRGET_SIZE  = 100;
		const MAX_KEY_LENGTH   = 200;
		const MAX_VALUE_LENGTH = 4194304;

		public function __construct()
		{
			parent::__construct();
			$this->connect('localhost');
		}

		public function add($key, $value)
		{
			return $this->setnx($key, $value);
		}

		public function replace($key, $value)
		{
			return (bool) $this->getSet($key, $value);
		}

		public function mget($ary)
		{
			return array_combine($ary, parent::mGet($ary));
		}

		/**
		 * $start_key hasn't implemented
		 */
		public function pkrget($prefix_key, $count, $start_key = '')
		{
			$it = NULL;
			return $this->mget($this->scan($it, $prefix_key . '*', $count));
		}
	}
}
