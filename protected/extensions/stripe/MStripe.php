<?php
require_once(dirname(__FILE__).'/lib/Stripe.php');

class MStripe extends CWidget{

	private $_basePath;

	public $checkoutJsUrl = "https://checkout.stripe.com/checkout.js";
	public $publishableKey = "";
	public $amount = 0;
	public $chargeUrl;
	public  $secretKey;
//	public $chargeUrl;


	/**
	 * register the required scripts and style
	 */
	function init(){
		//		$this->flashvars['src'] = "js:escape('".$src."')";
		$stripe = array(
			  "secret_key"      => $this->secretKey,
			  "publishable_key" => $this->publishableKey,
		);
		Stripe::setApiKey($stripe['secret_key']);
		//$this->checkoutJsUrl = $this->baseUrl."/checkout.js";
		return parent::init();
	}
	function run(){
		echo "
<form action='$this->chargeUrl' method='post'>
  <script src='$this->checkoutJsUrl' class='stripe-button'
          data-key='$this->publishableKey' 
          data-amount='$this->amount'></script>
</form>
";
	}
	/**
	 * @return string the url to the uploadify assets folder
	 */
	function getBaseUrl(){
		if($this->_basePath===null)
		$this->_basePath=Yii::app()->getAssetManager()->publish(dirname(__FILE__).DIRECTORY_SEPARATOR.'assets');
		return $this->_basePath;
	}
}