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
			'service' => 'create_partner_trade_by_buyer',
			'partner' => $this->partnerID,
			'_input_charset' => 'utf-8',
			'notify_url' => site_url('alipay/budgetNotify'),
			'out_trade_no' => $info['ID'],
			'subject' => $info['model'] . ' - 实验预算',
			'payment_type'=> '1',
			'logistics_type' => 'EXPRESS',
			'logistics_fee' => '0',
			'logistics_payment' => 'SELLER_PAY',
			'price' => $info['budget'],
			'quantity' => 1,
			'seller_id' => $this->partnerID,
			'body' => "{$info['category']} - {$info['model']} - {$info['useDate']} - 实验预算",
			'show_url' => site_url("/#/device/{$info['deviceID']}"),
			'receive_name' => $info['name'],
		];

		$config['sign'] = $this->sign($config, $this->key);
		$config['sign_type'] = 'MD5';

		return $this->gateway . http_build_query($config);
	}

	public function fillCreate($orderID) {
		$info = $this->order_model->allInfo($orderID);
		$config = [
			'service' => 'create_partner_trade_by_buyer',
			'partner' => $this->partnerID,
			'_input_charset' => 'utf-8',
			'notify_url' => site_url('alipay/fillNotify'),
			'out_trade_no' => 'fill_' . $info['ID'],
			'subject' => $info['model'] . ' - 耗材费用',
			'payment_type'=> '1',
			'logistics_type' => 'EXPRESS',
			'logistics_fee' => '0',
			'logistics_payment' => 'SELLER_PAY',
			'price' => $info['fill'],
			'quantity' => 1,
			'seller_id' => $this->partnerID,
			'body' => "{$info['category']} - {$info['model']} - {$info['useDate']} - 耗材费用",
			'show_url' => site_url("/#/device/{$info['deviceID']}"),
			'receive_name' => $info['name'],
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
