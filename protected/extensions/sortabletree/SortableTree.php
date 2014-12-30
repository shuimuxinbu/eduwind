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
class SortableTree extends CWidget{
    private $_options=array();
    private $_name;
    private $_id;

    private $_basePath;
    public $model;
    public $criteria;
    public $itemViewFile;
    public $maxDepth=0;
    public $group;
    public $updateUrl="";
    public $withChildren=false;
    /**
     * register the required scripts and style
     */
    function init(){
        Yii::app()->getClientScript()
            ->registerCoreScript('jquery')
            //->registerScriptFile($this->getBaseUrl().'/swfobject.js',CClientScript::POS_END)
            //->registerScriptFile($this->getBaseUrl().'/jquery.uploadify.v2.1.4.min.js',CClientScript::POS_END)
            ->registerScriptFile($this->getBaseUrl().'/jquery.nestable.js',CClientScript::POS_END)
         //   ->registerScriptFile($this->getBaseUrl().'/init.js',CClientScript::POS_END)
            ->registerCssFile($this->getBaseUrl().'/nestable.css')
            ;
        if($this->maxDepth>0)
	        $this->_options = array("maxDepth"=>$this->maxDepth);
	    if($this->group)
	    	$this->_options = array_merge_recursive(array('group'=>$this->group),$this->_options);
	    
        return parent::init();
    }
    function run(){
    	$this->generateHtml();	
        Yii::app()->getClientScript()->registerScript('nestable-init',"
$('.dd').nestable(".CJavaScript::encode($this->_options).");  

$('.dd').on('change', function(){
	var data=$(this).nestable('serialize');
	$.post('".$this->updateUrl."',{'data':data});
});
");
    }
    
    function generateHtml($parentId=0){
    	$criteria = new CDbCriteria();
		if($this->withChildren && $this->model->hasAttribute('parentId')){
    		$criteria->condition = "parentId = $parentId";
		}
		if($this->criteria) $criteria->mergeWith($this->criteria);
    	$models = $this->model->findAll($criteria);
    	if($models && !empty($models)){
    		//echo ($parentId==0 ? '<ol class="sortable-tree">' :"<ol>" );
    		if($parentId==0) echo "<div class='dd'>";
    		echo "<ol class='dd-list'>";
    		foreach($models as $item){
    			echo "<li class='dd-item' data-id='".$item->id."'>";
    			echo "<div class='dd-handle'>";
    			if($this->itemViewFile) Yii::app()->controller->renderPartial($this->itemViewFile,array('data'=>$item));
    			else echo "$item->name";
    			echo "</div>";
    			if($this->withChildren && $this->model->hasAttribute('parentId')) 
    				$this->generateHtml($item->id);
    			echo "</li>";
    		}
    		echo "</ol>";
    		if($parentId==0) echo "</div>";
    	}
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