<?php

class MGrindPlayer extends CWidget{

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
    	if(strstr($this->flashvars['src'],".m3u8")!==false){
    		$this->flashvars['plugin_m3u8'] = $this->baseUrl."/HLSDynamicPlugin.swf";
    	}
    	$src = $this->flashvars['src'] ;
    	$this->flashvars['src'] = "js:escape('".$src."')";

        Yii::app()->getClientScript()
            ->registerScriptFile($this->baseUrl.'/swfobject.min.js');    
        //	->registerScriptFile("http://yandex.st/swfobject/2.2/swfobject.min.js");
        echo '<div id="'.$this->id.'">
        <!-- this paragraph will be shown if FlashPlayer unavailable -->
 		 <video controls width="100%" >
 		 	<source src="'.$src.'"  type="video/mp4">
 		    <source src="'.$src. '"  type="video/x-flv"> 
 		    <source src="'.$src. '"  type="application/x-mpegURL">	 
 		 </video>
        </div>      
        ';
        return parent::init();
    }
    function run(){
        Yii::app()->getClientScript()->registerScript('s-'.$this->id,
            "swfobject.embedSWF('".$this->baseUrl."/GrindPlayer.swf','$this->id','$this->width','$this->height','$this->flashVersion',null,".
        						CJavaScript::encode($this->flashvars).",".CJavaScript::encode($this->params).",".CJavaScript::encode($this->attrs).");"
        ,CClientScript::POS_READY);
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
    function __get($name){
        try{
            return parent::__get($name);
        }catch(exception $e){
            if(isset($this->_options[$name]))
                return $this->_options[$name];
            throw $e;
        }
    }
    /**
     * override defaults __set method to allow set options easier
     * 
     * @param mixed $name
     * @param mixed $value
     * @return mixed
     */
    function __set($name,$value){
        try{
            return parent::__set($name,$value);
        }catch(exception $e){
            return $this->_options[$name]=$value;
        }
    }
}