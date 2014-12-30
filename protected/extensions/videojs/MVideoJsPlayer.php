<?php

class MVideoJsPlayer extends CWidget{

	private $_basePath;

	public $flashvars=array();
	public $params = array('allowFullScreen'=>true,
    						'allowScriptAccess'=>"always",
    						'bgcolor'=>"#000000");
	public $attrs = array('name'=>"player");
	public $flashVersion = "10.2";
	public $height = "480";
	public $width = "100%";
	public $id = "player";


	/**
	 * register the required scripts and style
	 */
	function init(){
		//		$this->flashvars['src'] = "js:escape('".$src."')";
		Yii::app()->clientScript->registerCssFile($this->baseUrl . "/video-js.min.css");
		Yii::app()->getClientScript()->registerScriptFile($this->baseUrl.'/video.js');
		Yii::app()->getClientScript()->registerScript(' videojs.options.flash.swf = "'.$this->baseUrl."/video-js.swf".'"',CClientScript::POS_HEAD);

		return parent::init();
	}
	function run(){
		$src = $this->flashvars['src'] ;
		$width = $this->width."px";
		$height = $this->height."px";
		if(DxdUtil::endWith($src, 'flv'))
			$type = 'video/x-flv';
		else 
			$type='video/mp4';
		echo "
		<video id='$this->id' class='video-js vjs-default-skin'
			  controls preload='auto' width='$this->width' height='$this->height'
			  data-setup='{}'>
			 <source src='$src' type='$type' />
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

	/**
	 * override defaults __get method to allow get options easier
	 *
	 * @param mixed $name
	 * @return mixed
	 */
/*	function __get($name){
		try{
			return parent::__get($name);
		}catch(exception $e){
			if(isset($this->_options[$name]))
			return $this->_options[$name];
			throw $e;
		}
	}

	function __set($name,$value){
		try{
			return parent::__set($name,$value);
		}catch(exception $e){
			return $this->_options[$name]=$value;
		}
	}*/
}