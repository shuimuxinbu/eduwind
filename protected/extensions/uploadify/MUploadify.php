<?php
/**
 * widget that integrates uploadify uploader in your application

##Requirements

Yii 1.1 or above

##Usage

Usage with model:

~~~
[php]
//view
$this->widget('MUploadify',array(
  'model'=>$model,
  'attribute'=>'myAttribute',
  //'script'=>$this->createUrl('upload'),
  //'auto'=>true,
  //'someOption'=>'someValue',
));

//controller
function init(){
  if(isset($_POST['SESSION_ID']){
    $session=Yii::app()->getSession();
    $session->close();
    $session->sessionID = $_POST['SESSION_ID'];
    $session->open();
  }
}
function actionUpload(){
  $model=new myModel;
  if(isset($_POST['myModel'])){
    $model->myAttribute=CUploadedFile::getInstance($model,'myAttribute');
    if(!$model->save())
      throw new CHttpException(500);
    $model->myAttribute->saveAs('someFile.php');
    Yii::app()->end();
  }
}
~~~

using without model:

~~~
[php]
//view
$this->widget('MUploadify',array(
  'name'=>'myPicture',
  //'buttonText'=>Yii::t('application','Upload a picture'),
  //'script'=>array('myController/upload','id'=>$model->id),
  //'checkScript'=>array('myController/checkUpload','id'=>$model->id),
  //fileExt=>'*.jpg;*.png;',
  //fileDesc=>Yii::t('application','Image files'),
  //'uploadButton'=>true,
  //'uploadButtonText'=>'Upload new',
  //'uploadButtonTagname'=>'button',
  //'uploadButtonOptions'=>array('class'=>'myButton'),
));

//controller
function init(){
  if(isset($_POST['SESSION_ID']){
    $session=Yii::app()->getSession();
    $session->close();
    $session->sessionID = $_POST['SESSION_ID'];
    $session->open();
  }
}
function actionUpload(){
  if(isset($_POST['myPicture'])){
    $myPicture=CUploadedFile::getInstanceByName('myPicture');
    if(!$myPicture->saveAs('someFile.ext'))
      throw new CHttpException(500);
    Yii::app()->end();
  }
}
~~~



##Options

#### string $sessionKey='SESSION_ID'
The key that will contain the session id so you can retrieve later by $_POST['SESSION_ID']
#### boolean $uploadButton=null
wheter to generate a button to trigger the upload.
If null, it will generate the button if uploadify 'auto' option is not set or is false
#### array $uploadButtonOptions=array()
html options of the upload button
#### string $uploadButtonTagname='a'
the name of the html tag to generate the upload button
#### string $uploadButtonText='Upload files'
the text to be used in the upload button

#### mixed $script
The path to the back-end script that checks for pre-existing files on the server.
The path can be either an array or a string. See [CHml::normalizeUrl](http://www.yiiframework.com/doc/api/1.1/CHtml#normalizeUrl-detail "CHtml::normalizeUrl").

See also the [uploadify documentation](http://www.uploadify.com/documentation/options/script/ "script")

Defaults to the active url.

#### mixed $checkScript

The path to the back-end script that checks for pre-existing files on the server.
The path can be either an array or a string. See [CHml::normalizeUrl](http://www.yiiframework.com/doc/api/1.1/CHtml#normalizeUrl-detail "CHtml::normalizeUrl").

See also the [uploadify documentation](http://www.uploadify.com/documentation/options/checkscript/ "checkScript")

Defaults to null, disabling this option.

#### mixed $scriptData
An object containing name/value pairs with additional information that should be sent to the back-end script when processing a file upload.

The data is json encoded and can be later retrieved by json decoding $_POST['attribute'] or $_POST['model']['attribute']

[any other uploadify option](http://www.uploadify.com/documentation/ "options")

##Version

- Version 0.1 (20/08/2011):
Initial release. 
It uses uploadify lastest stable version 2.1.4

##Resources

 * [Forum support](http://www.yiiframework.com/forum/index.php?/topic/22815-muploadify/ "forum support")
 * [Uploadify homepage](http://www.uploadify.com/ "Uploadify homepage")
 * [Uploadify documentation](http://www.uploadify.com/documentation/ "Uploadify documentation")
 * [Demo](http://www.uploadify.com/demos/ "uploadify demo")

**/
class MUploadify extends CInputWidget{
    private $_options=array();
    private $_name;
    private $_id;
    public $sessionKey='SESSION_ID';
    public $uploadButton;
    public $uploadButtonOptions=array();
    public $uploadButtonTagname='a';
    public $uploadButtonText='Upload Files';
    private $_basePath;
    /**
     * register the required scripts and style
     */
    function init(){
        Yii::app()->getClientScript()
            ->registerCoreScript('jquery')
            //->registerScriptFile($this->getBaseUrl().'/swfobject.js',CClientScript::POS_END)
            //->registerScriptFile($this->getBaseUrl().'/jquery.uploadify.v2.1.4.min.js',CClientScript::POS_END)
            ->registerScriptFile($this->getBaseUrl().'/jquery.uploadify.min.js?v='.rand(0, 999),CClientScript::POS_END)
            ->registerCssFile($this->getBaseUrl().'/uploadify.css');
        
        return parent::init();
    }
    function run(){
		
        $this->defineNameId();        
        $this->setBaseOptions();
        
		if($this->hasModel())
			echo CHtml::activeFileField($this->model,$this->attribute,$this->htmlOptions);
		else
			echo CHtml::fileField($this->_name,$this->value,$this->htmlOptions);
        
        if($this->uploadButton===true || ($this->uploadButton===null && (!isset($this->_options['auto']) || $this->_options['auto']==false)))
            echo $this->createUploadButton();
        
        Yii::app()->getClientScript()->registerScript(get_class($this).'-'.$this->getInputId(),
            "$('#{$this->inputId}').uploadify(".CJavaScript::encode($this->_options).");"
        ,CClientScript::POS_END);
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
     * define the default options of uploadify
     * be sure that user can override these options
     * 
     * @return void
     */
    protected function setBaseOptions(){
        $this->_options=array_merge(array(
            //'script'=>Yii::app()->getController()->createUrl(''),
            'uploader'=>Yii::app()->getController()->createUrl(''),
            //'uploader'=>$this->getBaseUrl().'/uploadify.swf',
            'swf'=>$this->getBaseUrl().'/uploadify.swf',
            //'expressInstall'=>$this->getBaseUrl().'/expressInstall.swf',
            //'cancelImg'=>$this->getBaseUrl().'/cancel.png',
            
            //'fileDataName'=>$this->hasModel() ? get_class($this->model)."[{$this->attribute}]" : $this->getInputName(),
            'fileObjName'=>$this->hasModel() ? get_class($this->model)."[{$this->attribute}]" : $this->getInputName(),
            'buttonText'=>Yii::t('application','Select a file'),
            //'scriptData'=>array($this->getInputName()=>' '),
            'formData'=>array($this->getInputName()=>' '),
            //'folder'=>$this->getBaseUrl()
        ),$this->_options);
        
        $this->_options['formData'][$this->sessionKey]=session_id();
    }
    
    /**
     * creates the button to trigger the upload
     * 
     * @return string
     */
    protected function createUploadButton(){
        if(!isset($this->uploadButtonOptions['onclick']))
            $this->uploadButtonOptions['onclick']="javascript:$('#{$this->inputId}').uploadifyUpload()";
        if(!isset($this->uploadButtonOptions['href']))
            $this->uploadButtonOptions['href']='#';
        return CHtml::tag(
            $this->uploadButtonTagname,
            $this->uploadButtonOptions,
            $this->uploadButtonText
        );
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
    /**
     * the id of the input
     * 
     * @return string
     */
    protected function getInputId(){
        if($this->_id===null)
            $this->defineNameId();
        return $this->_id;
    }
    /**
     * the name of the input
     * 
     * @return string
     */
    protected function getInputName(){
        if($this->_name===null)
            $this->defineNameId();
        return $this->_name;
    }
    /**
     * set the name and id of the input
     * 
     * @return void
     */
    protected function defineNameId(){
        list($name,$id)=$this->resolveNameID();
        $this->_id=$this->htmlOptions['id']=$id;
		$this->_name=$this->htmlOptions['name']=$name;
    }
    /**
     * An object containing name/value pairs with additional information that should be sent to the back-end script when processing a file upload.
     * The data is json encoded and can be later retrieved by json decoding $_POST['attribute'] or $_POST['model']['attribute'] 
     * 
     * @param mixed $value
     * @return void
     */
    function setScriptData($value){
        $this->_options['scriptData'][$this->getInputName()]=CJSON::encode($value);
    }
    /**
     * An object containing name/value pairs with additional information that should be sent to the back-end script when processing a file upload.
     * The data is json encoded and can be later retrieved by json decoding $_POST['attribute'] or $_POST['model']['attribute']
     * 
     * @return string the option scriptData 
     */
    function getScriptData(){
        return CJSON::decode($this->_options['scriptData'][$this->getInputName()]);
    }
    /**
     * The path to the back-end script that will process the file uploads.
     * The path can be either an array or a string. see CHtml::normalizeUrl
     * 
     * @param mixed $value
     * @return void
     */
    function setScript($value){
        $this->_options['script']=CHtml::normalizeUrl($value);
    }
    /**
     * The path to the back-end script that checks for pre-existing files on the server.
     * The path can be either an array or a string. see CHtml::normalizeUrl
     * 
     * @param mixed $value
     * @return void
     */
    function setCheckScript($value){
        $this->_options['checkScript']=CHtml::normalizeUrl($value);
    }
}