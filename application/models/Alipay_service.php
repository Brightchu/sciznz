<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Alipay_service extends CI_Model {

	protected $gateway = 'https://mapi.alipay.com/gateway.do?';
	protected $key = 't3qbppwaa837b094x0udbputmpsrrh3t';
	protected $partnerID = '2088911197458926';

	public function __construct() {
		parent::__construct();
		$this->load->helper('url');
		$this->load->model('order_model');
	}

	public function budgetCreate($orderID) {
		$info = $this->order_model->allInfo($orderID);
		$config = [
			'service' => 'create_direct_pay_by_user',
			'partner' => $this->partnerID,
			'_input_charset' => 'utf-8',
			'notify_url' => site_url('alipay/budgetNotify'),
			'out_trade_no' => $info['ID'],
			'subject' => $info['model'] . ' - 实验预算',
			'payment_type'=> '1',
			'total_fee' => $info['budget'],
			'seller_id' => $this->partnerID,
			'body' => "{$info['category']} - {$info['model']} - {$info['useDate']} - 实验预算",
			'show_url' => site_url("/#/device/{$info['deviceID']}"),
		];

		$config['sign'] = $this->sign($config, $this->key);
		$config['sign_type'] = 'MD5';

		return $this->gateway . http_build_query($config);
	}

	public function fillCreate($orderID) {
		$info = $this->order_model->allInfo($orderID);
		$config = [
			'service' => 'create_direct_pay_by_user',
			'partner' => $this->partnerID,
			'_input_charset' => 'utf-8',
			'notify_url' => site_url('alipay/fillNotify'),
			'out_trade_no' => 'fill_' . $info['ID'],
			'subject' => $info['model'] . ' - 耗材费用',
			'payment_type'=> '1',
			'total_fee' => $info['fill'],
			'seller_id' => $this->partnerID,
			'body' => "{$info['category']} - {$info['model']} - {$info['useDate']} - 耗材费用",
			'show_url' => site_url("/#/device/{$info['deviceID']}"),
		];

		$config['sign'] = $this->sign($config, $this->key);
		$config['sign_type'] = 'MD5';

		return $this->gateway . http_build_query($config);
	}

	protected function sign($array, $key) {
		ksort($array);
		return md5(urldecode(http_build_query($array)) . $key);
	}
}
