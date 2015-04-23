<?php
defined('BASEPATH') OR exit('No direct script access allowed');

function md5Sign($prestr, $key) {
	$prestr = $prestr . $key;
	return md5($prestr);
}

function argSort($para) {
	ksort($para);
	reset($para);
	return $para;
}

class Alipay_service extends CI_Model {

	protected $gateway = 'https://mapi.alipay.com/gateway.do?';
	protected $key = 't3qbppwaa837b094x0udbputmpsrrh3t';
	protected $partnerID = '2088911197458926';

	public function __construct() {
		parent::__construct();
		$this->load->helper('url');
		$this->load->model('order_model');
	}

	public function create($orderID) {
		$info = $this->order_model->allInfo($orderID);
		$config = [
			'service' => 'create_partner_trade_by_buyer',
			'partner' => $this->partnerID,
			'_input_charset' => 'utf-8',
			'notify_url' => site_url('alipay/notify'),
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
			'show_url' => site_url("/#/device/{$info['ID']}"),
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
