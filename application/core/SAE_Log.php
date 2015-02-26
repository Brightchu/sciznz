<?php
/**
 * CodeIgniter for SAE
 * Logging Class
 *
 * @package	CodeIgniter
 * @author Yuzo
 */
defined('BASEPATH') OR exit('No direct script access allowed');

/**
 * Logging Class on SAE
 *
 * @package		CodeIgniter
 * @subpackage	Libraries
 * @category	Logging
 * @author		Yuzo
 */

class SAE_Log extends CI_Log {
	/**
	 * Class constructor
	 *
	 * @return	void
	 */
	public function __construct()
	{
		$config =& get_config();

		if (is_numeric($config['log_threshold']))
		{
			$this->_threshold = (int) $config['log_threshold'];
		}
		elseif (is_array($config['log_threshold']))
		{
			$this->_threshold = $this->_threshold_max;
			$this->_threshold_array = array_flip($config['log_threshold']);
		}
	}

	// --------------------------------------------------------------------

	/**
	 * Write Log File
	 *
	 * Generally this function will be called using the global log_message() function
	 *
	 * @param	string	the error level: 'error', 'debug' or 'info'
	 * @param	string	the error message
	 * @return	bool
	 */
	public function write_log($level, $msg)
	{
		if ($this->_enabled === FALSE)
		{
			return FALSE;
		}

		$level = strtoupper($level);

		if (( ! isset($this->_levels[$level]) OR ($this->_levels[$level] > $this->_threshold))
			&& ! isset($this->_threshold_array[$this->_levels[$level]]))
		{
			return FALSE;
		}

		sae_set_display_errors(FALSE);
		sae_debug($level .': '. $msg);
		sae_set_display_errors(TRUE);
		return TRUE;
	}

}
