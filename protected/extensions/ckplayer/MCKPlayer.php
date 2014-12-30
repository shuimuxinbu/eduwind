<?php

class MCKPlayer extends CWidget{

    private $_basePath;

    public $flashvars=array('c'=>0,'loaded'=>'loadedHandler');
    public $params = array('allowFullScreen'=>true,
    						'allowScriptAccess'=>"always",
    						'bgcolor'=>"#fff");
    public $flashVersion = "10.2";
    public $video=array();
    public $support = array('iPad','iPhone','ios','android+false','msie10+false');

    public $height = "480";
    public $width = "100%";


    /**
     * register the required scripts and style
     */
    function init(){

    //	$this->flashvars['f'] = "js:escape('".$this->flashvars['f']."')";


        Yii::app()->getClientScript()
            ->registerScriptFile($this->baseUrl.'/offlights.js')
         	->registerScriptFile($this->baseUrl.'/ckplayer.js');
         echo '<div id="video" style="position:relative;z-index: 100;width:100%;float: left;"><div id="a1"></div></div>';
        return parent::init();
    }
    function run(){

    	   //      Yii::app()->getClientScript()->registerScript('player',
        //     "CKobject.embedSWF('".$this->baseUrl."/ckplayer.swf','a1','ckplayer_a1','$this->width','$this->height',".CJavaScript::encode($this->flashvars).",".CJavaScript::encode($this->params).");

      		//  CKobject.embedHTML5('video','ckplayer_a1','$this->width','$this->height',".CJavaScript::encode($this->video).",".CJavaScript::encode($this->flashvars).",".CJavaScript::encode($this->support).");"
        // ,CClientScript::POS_READY);

      // Yii::app()->getClientScript()->registerScript('player',
      //      "CKobject.embed('".$this->baseUrl."/ckplayer.swf','a1','ckplayer_a1','$this->width','$this->height',".CJavaScript::encode($this->flashvars).",".CJavaScript::encode($this->params).");",
      //      CClientScript::POS_READY);
      //  ,CClientScript::POS_READY);
        Yii::app()->getClientScript()->registerScript('ck_player',
            "CKobject.embed('".$this->baseUrl."/ckplayer.swf','a1','ckplayer_a1','$this->width','$this->height',false,".CJavaScript::encode($this->flashvars).",".CJavaScript::encode($this->video).");"
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

// CKobject.embed('/eduwind150os/assets/3329f220/ckplayer.swf',
//     'a1','ckplayer_a1','100%','480',false,
//     {'f':'/eduwind150os/uploads/uploadFile/Lesson/mediaId/65.mp4'},
//     ['/eduwind150os/uploads/uploadFile/Lesson/mediaId/65.mp4']);

