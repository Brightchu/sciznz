<?php
defined('BASEPATH') OR exit('No direct script access allowed');

// ------------------------------------------------------------------------

/**
 * CodeIgniter Email Class for SAE
 * 
 * Build on the top of SAE native mail service.
 * TODO: support attachment
 *
 * @package		CodeIgniter
 * @subpackage	Libraries
 * @category	Libraries
 * @author		Yuzo
 * @link		http://apidoc.sinaapp.com/class-SaeMail.html
 */
  
class SAE_Email extends CI_Email {

	/**
	 * Instance of SaeMail
	 *
	 * @var	object
	 */
	protected $_sae_mail = NULL;

	public function __construct($config = array())
	{
		parent::__construct($config);
		$this->_sae_mail = new SaeMail();

		log_message('info', 'SAE Email Class Initialized');
	}

	public function clear($clear_attachments = FALSE)
	{
		parent::clear($clear_attachments);
		$this->_sae_mail->clean();

		return TRUE;
	}

	public function send($auto_clear = TRUE)
	{
		$this->_sae_mail->setOpt(array(
			'from' => $this->smtp_user,
			'to' => $this->_headers['To'],
			'cc' => $this->_headers['Cc'],
			'smtp_host' => $this->smtp_host,
			'smtp_port' => $this->smtp_port,
			'smtp_username' => $this->smtp_user,
			'smtp_password' => $this->smtp_pass,
			'subject' => $this->_headers['Subject'],
			'content' => $this->_body,
			'content_type' => $this->mailtype,
			'charset' => $this->charset,
			'tls' => !empty($this->smtp_crypto),
			'nickname' => substr($this->_headers['From'], substr($from, 0, strpos($from, ' ')))
		));

		if ($this->_sae_mail->send()) {
			if ($auto_clear) {
				$this->clear();
			}
			return TRUE;
		} else {
			$this->_set_error_message($this->_sae_mail->errmsg());
			log_message('error', 'Mail service error: ' . $this->_sae_mail->errno() . ' ' . $this->_sae_mail->errmsg());
			return FALSE;
		}
	}
}
