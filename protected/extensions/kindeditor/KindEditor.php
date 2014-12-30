<?php

class KindEditor extends CInputWidget{
	private $language = 'zh_CN';

	public function getAssetsPath()
	{
		$baseDir = dirname(__FILE__);
		return Yii::app()->getAssetManager()->publish($baseDir.DIRECTORY_SEPARATOR.'assets');
	}

	public function makeOptions()
	{
	//	list($name, $id) = $this->resolveNameID();

		$assets = $this->getAssetsPath();
		$cssPath = $assets . '/plugins/code/prettify.css';
		$uploadJson = Yii::app()->createUrl('kindEditor/upload'); 
		$fileManagerJson = Yii::app()->createUrl('kindEditor/findManager'); 

		$script = <<<EOP

$(function() {
	var editor = KindEditor.create('.dxd-kind-editor', {
		cssPath : '{$cssPath}',
		uploadJson : '{$uploadJson}',
		fileManagerJson : '{$fileManagerJson}',
		allowFileManager : true,
		items:['fontsize', '|', 'forecolor', 'hilitecolor', 'bold', 'italic', 'underline',
           'removeformat', '|', 'justifyleft', 'justifycenter', 'justifyright', 'insertorderedlist',
            'insertunorderedlist', '|','insertfile', 'image', 'link','unlink','|','about'],
		afterCreate : function() {
			var self = this;
			KindEditor.ctrl(document, 13, function() {
				self.sync();
				KindEditor('form')[0].submit();
			});
			KindEditor.ctrl(self.edit.doc, 13, function() {
				self.sync();
				KindEditor('form')[0].submit();
			});
		}
	});
	prettyPrint();
	});

EOP;
		return $script;
	}

    public function run(){
        parent::run();
        $assets = $this->getAssetsPath();
        $cs = Yii::app()->getClientScript();
        $cs->registerCssFile($assets.'/themes/default/default.css');
        $cs->registerCssFile($assets.'/plugins/code/prettify.css');
        $cs->registerScriptFile($assets.'/kindeditor.js',CClientScript::POS_HEAD);
        $cs->registerScriptFile($assets.'/lang/zh_CN.js',CClientScript::POS_HEAD);
        $cs->registerScriptFile($assets.'/plugins/code/prettify.js',CClientScript::POS_HEAD);
        $cs->registerScript('content',$this->makeOptions(),CClientScript::POS_HEAD);
    }
}
?>