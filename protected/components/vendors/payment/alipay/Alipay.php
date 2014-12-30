<?php
class Alipay{
	/*	public $config = array('partner'=> '',
	 'key'=>'',
	 'sign_type'=>'MD5',
	 'input_charset'=>'utf-8',
	 'cacert'=>'cacert.pem',
	 'transport'=>'http');
	 */
	//安全检验码，以数字和字母组成的32位字符
	public $key			= '';
	public $partner = "";

	//签名方式 不需修改(大写）
	public $sign_type   = 'MD5';

	//字符编码格式 目前支持 gbk 或 utf-8(小写）
	public $input_charset= 'utf-8';

	//ca证书路径地址，用于curl中ssl校验
	//请保证cacert.pem文件在当前文件夹目录中
	//public $cacert    = getcwd().'\\cacert.pem';
	public $cacert    = 'cacert.pem';

	//访问模式,根据自己的服务器是否支持ssl访问，若支持请选择https；若不支持请选择http
	public $transport   = 'http';




	//支付类型
	public       $payment_type = "1";
	//必填，不能修改
	//服务器异步通知页面路径
	public        $notify_url = "http://www.xxx.com/create_partner_trade_by_buyer-PHP-UTF-8/notify_url.php";
	//需http://格式的完整路径，不能加?id=123这类自定义参数

	//页面跳转同步通知页面路径
	public        $return_url = "http://www.xxx.com/create_partner_trade_by_buyer-PHP-UTF-8/return_url.php";
	//需http://格式的完整路径，不能加?id=123这类自定义参数，不能写成http://localhost/

	//卖家支付宝帐户
	public        $seller_email ;
	//$_POST['WIDseller_email'];
	//必填

	//商户订单号
	public        $out_trade_no ;//= $_POST['WIDout_trade_no'];
	//商户网站订单系统中唯一订单号，必填

	//订单名称
	public         $subject;// = $_POST['WIDsubject'];
	//必填

	//付款金额
	public       $price ;//= $_POST['WIDprice'];
	//必填

	//商品数量
	public       $quantity =1;//= "1";
	//必填，建议默认为1，不改变值，把一次交易看成是一次下订单而非购买一件商品
	//物流费用
	public        $logistics_fee = "0.00";
	//必填，即运费
	//物流类型
	public      $logistics_type = "EXPRESS";
	//必填，三个值可选：EXPRESS（快递）、POST（平邮）、EMS（EMS）
	//物流支付方式
	public       $logistics_payment = "SELLER_PAY";
	//必填，两个值可选：SELLER_PAY（卖家承担运费）、BUYER_PAY（买家承担运费）
	//订单描述

	public        $body ;//=$_POST['WIDbody'];
	//商品展示地址
	public  $show_url;// = $_POST['WIDshow_url'];
	//需以http://开头的完整路径，如：http://www.xxx.com/myorder.html

	//收货人姓名
	public      $receive_name ;//= $_POST['WIDreceive_name'];
	//如：张三

	//收货人地址
	public       $receive_address; //= $_POST['WIDreceive_address'];
	//如：XX省XXX市XXX区XXX路XXX小区XXX栋XXX单元XXX号

	//收货人邮编
	public     $receive_zip ;//= $_POST['WIDreceive_zip'];
	//如：123456

	//收货人电话号码
	public      $receive_phone ;//= $_POST['WIDreceive_phone'];
	//如：0571-88158090

	//收货人手机号码
	public   $receive_mobile ;//= $_POST['WIDreceive_mobile'];
	//如：13312341234

	public $config;
	
	public $service = "trade_create_by_buyer";

	function __construct($partner,$key){
		$this->partner = $partner;
		$this->key = $key;
		$this->cacert = dirname(__FILE__)."/cacert.pem";
		
		$this->config = array('partner'=> $this->partner,
							'key'=>$this->key,
							'sign_type'=>strtoupper($this->sign_type),
							'input_charset'=>$this->input_charset,
							'cacert'=>$this->cacert,
							'transport'=>$this->transport);
	}
	public function submit(){
		require_once("lib/alipay_submit.class.php");



		$parameter = array(
		//"service" => "create_partner_trade_by_buyer",
		//"service" => "trade_create_by_buyer",		
		//"service" => "create_direct_pay_by_user",
		"service"=>trim($this->service),
		"partner" => trim($this->config['partner']),
		"payment_type"	=> $this->payment_type,
		"notify_url"	=> $this->notify_url,
		"return_url"	=> $this->return_url,
		"seller_email"	=> $this->seller_email,
		"out_trade_no"	=> $this->out_trade_no,
		"subject"	=> $this->subject,
		"price"	=> $this->price,
		"quantity"	=> $this->quantity,
		"logistics_fee"	=> $this->logistics_fee,
		"logistics_type"	=> $this->logistics_type,
		"logistics_payment"	=> $this->logistics_payment,
		"body"	=> $this->body,
		"show_url"	=> $this->show_url,
		"receive_name"	=> $this->receive_name,
		"receive_address"	=> $this->receive_address,
		"receive_zip"	=> $this->receive_zip,
		"receive_phone"	=> $this->receive_phone,
		"receive_mobile"	=> $this->receive_mobile,
		"_input_charset"	=> trim(strtolower($this->config['input_charset']))
		);

		//建立请求
		$alipaySubmit = new AlipaySubmit($this->config);
		$html_text = $alipaySubmit->buildRequestForm($parameter,"get", "ok");
		return '<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html>
<head>
	<meta http-equiv="Content-Type" content="text/html; charset=utf-8">
	<title>支付宝纯担保交易接口接口</title>
</head><body>'.$html_text."</body></html>";

	}

	public function verifyNotify(){
		require_once("lib/alipay_notify.class.php");
		//计算得出通知验证结果
		$alipayNotify = new AlipayNotify($this->config);
		return $alipayNotify->verifyNotify();
	}
	
	public function verifyReturn(){
		require_once("lib/alipay_notify.class.php");
		$alipayNotify = new AlipayNotify($this->config);
		return $alipayNotify->verifyReturn();
	}
	
}