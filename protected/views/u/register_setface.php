<?php
/* @var $this UserController */
/* @var $model UserInfo */

?>
<h2><?php echo Yii::t('app','上传个人头像')?></h2>
<hr/>
<div class="col-sm-6 center dxd-set-face">
<p><?php echo Yii::t('app','验证成功！请上传个人头像')?></p>
<ul>
<li><?php echo Yii::t('app','支持图片格式为*.png,*.gif,*.jpg,*.jpeg，大小不能超过2MB；')?></li>
<li><?php echo Yii::t('app','建议图片的长高比约为1：1；')?></li>
</ul>
<p></p>
<?php 
$model = new XUploadForm;
$this->widget('xupload.XUpload', array(
                    'url' => $this->createUrl('me/setFace',array('id'=>$id)),
                    'model' => $model,
                    'attribute' => 'file',
					'multiple'=>true, 
					'autoUpload'=>true,
		            'options' => array(
		                'maxFileSize' => 3*1024*1024,
		                'acceptFileTypes' => "js:/(\.|\/)(jpe?g|png|gif)$/i",
		            ),
));
?>
<div class="pull-right">
<?php echo CHtml::link(Yii::t('app','跳过'),Yii::app()->baseUrl."/");?>&nbsp;
<?php echo CHtml::link(Yii::t('app','完成'),Yii::app()->baseUrl."/",array('class'=>'btn btn-success ml10'));?>
</div>
</div>
<<style>
<!--

-->
.dxd-set-face img{
width:120px;
height:120px;
}
</style>

