<?php
require_once(dirname(__FILE__).'/lib/Stripe.php');
class MStripePay implements Stripe{
	public $secretKey;
	public $publishableKey;
	public $stripe;
	function __construct__($secrectKey){
		$this->setApiKey($secrectKey);
		parent::__construct();
	}
	
	
}