<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Nativesession {

	public function __construct()
	{
		session_start();
	}

	public function __set($key, $value)
	{
		$_SESSION[$key] = $value;
	}

	public function __get($key)
	{
		return isset($_SESSION[$key]) ? $_SESSION[$key] : NULL;
	}

	public function __isset($key)
	{
		return isset($_SESSION[$key]);
	}

	public function __unset($key)
	{
		unset($_SESSION[$key]);
	}

	public function set($key, $value)
	{
		$_SESSION[$key] = $value;
	}

	public function set_data($data)
	{
		foreach ($data as $key => $value) {
			$_SESSION[$key] = $value;
		}
	}

	public function get($key)
	{
		return isset($_SESSION[$key]) ? $_SESSION[$key] : NULL;
	}

	public function exists($key)
	{
		return isset($_SESSION[$key]);
	}

	public function delete($key)
	{
		unset($_SESSION[$key]);
	}

	public function regenerateId($delOld = FALSE)
	{
		session_regenerate_id($delOld);
	}
}
