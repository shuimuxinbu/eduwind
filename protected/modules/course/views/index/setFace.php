
<h3 class="dxd-fancybox-header"><?php echo Yii::t('app','修改课程封面图片');?></h3>
<div class="dxd-fancybox-body">
<ul>
<li><?php echo Yii::t('app','支持图片格式为*.png,*.gif,*.jpg,*.jpeg，大小不能超过3MB；')?></li>
<li><?php echo Yii::t('app','建议图片的长高比约为2：1；')?></li>
</ul>
<p></p>
<?php 

$model = new XUploadForm;
$this->widget('xupload.XUpload', array(
                    'url' => $this->createUrl('course/setFace',array('id'=>$course->id)),
                    'model' => $model,
                    'attribute' => 'file',
					'multiple'=>false, 
					'autoUpload'=>true,
		            'options' => array(
		                'maxFileSize' => 3*1024*1024,
		                'acceptFileTypes' => "js:/(\.|\/)(jpe?g|png|gif)$/i",
		            ),
));/*
$this->widget('ext.EFineUploader.EFineUploader',
 array(
       'id'=>'FineUploader',
       'config'=>array(
                       'autoUpload'=>true,
                       'request'=>array(
                          'endpoint'=> $this->createUrl('course/setFace'),
                          'params'=>array('YII_CSRF_TOKEN'=>Yii::app()->request->csrfToken),
                                       ),
                       'retry'=>array('enableAuto'=>true,'preventRetryResponseProperty'=>true),
                       'chunking'=>array('enable'=>true,'partSize'=>100),//bytes
                       'callbacks'=>array(
                                        'onComplete'=>"js:function(id, name, response){  }",
                                        'onError'=>"js:function(id, name, errorReason){ }",
                                         ),
                       'validation'=>array(
                                 'allowedExtensions'=>array('jpg','jpeg'),
                                 'sizeLimit'=>2 * 1024 * 1024,//maximum file size in bytes
                                 'minSizeLimit'=>2*1024,// minimum file size in bytes
                                          ),
                      )
      ));*/
?>
</div>

<div class="dxd-fancybox-footer">
</div>

