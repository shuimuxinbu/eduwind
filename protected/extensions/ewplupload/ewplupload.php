<?php
class ewplupload extends CWidget{
    private $_basePath;
    public $sourceUrl = '';
    public $uploadToken = '';
    public $key = '';
    public $mediaUrl = '';
    public $modelId = '';
    public $chunk_size = '0';
    public $url = '';
    /**
     * register the required scripts and style
     */
    function init(){
        $cloudStorageForm = new CloudStorageForm();
        $cloudStorageForm->getSetting();
        $storage = $cloudStorageForm->storage;
        if ($storage == 'cloud') {
            Yii::app()->getClientScript()
                ->registerCoreScript('jquery')
                ->registerScriptFile($this->getBaseUrl().'/js/plupload/plupload.full.min.js')
                ->registerScriptFile($this->getBaseUrl().'/js/plupload/i18n/zh_CN.js')
                ->registerScriptFile($this->getBaseUrl().'/js/ui.js')
                ->registerScriptFile($this->getBaseUrl().'/js/ewcloud.js')
                ->registerScriptFile($this->getBaseUrl().'/js/cloudmain.js')
                ->registerCssFile($this->getBaseUrl().'/main.css');
        }else{
            Yii::app()->getClientScript()
                ->registerCoreScript('jquery')
                ->registerScriptFile($this->getBaseUrl().'/js/plupload/plupload.full.min.js')
                ->registerScriptFile($this->getBaseUrl().'/js/plupload/i18n/zh_CN.js')
                ->registerScriptFile($this->getBaseUrl().'/js/ui.js')
                ->registerScriptFile($this->getBaseUrl().'/js/localmain.js')
                ->registerCssFile($this->getBaseUrl().'/main.css');

        }


        return parent::init();
    }
    function run(){
        echo '<div class="container">
						<div class="text-left col-md-12 wrapper">
                        <input type="hidden" id="domain" value="'.$this->sourceUrl.'">
                        <input type="hidden" id="uptoken" value="'.$this->uploadToken.'">
                        <input type="hidden" id="key" value="'.$this->key.'">
                        <input type="hidden" id="setMediaUrl" value="'.$this->mediaUrl.'">
                        <input type="hidden" id="modelId" value="'.$this->modelId.'">
                        <input type="hidden" id="chunk_size" value="'.$this->chunk_size.'">
                        <input type="hidden" id="url" value="'.$this->url.'">
					    </div>
					    <div class="body">
					        <div class="col-md-12">
					            <div id="container">
					                <a class="btn btn-default btn-lg " id="pickfiles" href="#" >
					                    <i class="glyphicon glyphicon-plus"></i>
					                    <sapn>'.Yii::t('app',"选择文件").'</sapn>
					                </a>
					            </div>
					        </div>

					        <div class="col-md-12 ">
					            <table class="table table-striped table-hover text-left"   style="margin-top:40px;display:none">
					                <thead>
					                  <tr>
					                    <th class="col-md-filename">'.Yii::t('app',"名称").'</th>
					                    <th class="col-md-filesize">'.Yii::t('app',"大小").'</th>
					                    <th class="col-md-filedetail">'.Yii::t('app',"详情").'</th>
					                  </tr>
					                </thead>
					                <tbody id="fsUploadProgress">
					                </tbody>
					            </table>
					        </div>
					    </div>
					</div>';
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