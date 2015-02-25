<?php
defined('BASEPATH') OR exit('No direct script access allowed');

if (defined('SAE_APPNAME')){
	class Kvdb extends SaeKV {
		function __construct()
		{
			parent::__construct();
			$this->init();
		}
	}
} else{
	class Kvdb extends Redis {
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
			if($this->exists($key)){
				return $this->set($key, $value);
			} else{
				return False;
			}
		}

		public function mget($ary)
		{
			return $this->mGet($ary);
		}
	}
}
