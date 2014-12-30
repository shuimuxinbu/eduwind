<?php
/* @var $this NewsController */
/* @var $model News */
/* @var $form CActiveForm */
		$maxFileSize = floor(min(DxdUtil::return_bytes(ini_get('post_max_size')),
					   DxdUtil::return_bytes(ini_get('upload_max_filesize')),
					   DxdUtil::return_bytes(ini_get('memory_limit')))/1024/1024);
		$cloudStorageForm = new CloudStorageForm();
		$cloudStorageForm->getSetting();
		$storage = $cloudStorageForm->storage;
?>

<div class="form">

<?php $form=$this->beginWidget('booster.widgets.TbActiveForm', array(
	'id'=>'news-form',
	'enableAjaxValidation'=>false,
 //   'type'=>'horizontal',
    'htmlOptions' => array(
        'enctype' => 'multipart/form-data'
    )
)); ?>

	<?php echo $form->errorSummary($model); ?>
 	<?php echo $form->textFieldGroup($model,'title',array('class'=>'input-block-level'));?>
 <?php echo $form->radioButtonListInlineGroup($model, 'isFree', array(
		'1'=>Yii::t('app','是'),
		'0'=>Yii::t('app','否')
    )); ?>
 	<?php echo $form->textAreaGroup($model,'introduction',array('class'=>'input-block-level','style'=>'min-height:90px;'));?>

 <?php
 		echo $form->radioButtonListInlineGroup($model, 'mediaSource', array(
		'self'=>($storage == 'cloud')?Yii::t('app','上传视频文件(*.mp4,*.flv)到云端'):Yii::t('app','上传视频文件(*.mp4,*.flv)到服务器'),
		'link'=>Yii::t('app','导入外部视频链接')
    ));
    //echo CloudService::getInstance()->test();
    ?>

    <div id="dxd-for-self" class="dxd-media-source <?php if($model->mediaSource!="self") echo 'dxd-hidden';?>">
    	<!--
    	<?php echo $form->fileFieldGroup($model,'mediaId',array('class'=>'btn'));?>
     	&nbsp;&nbsp;<?php if($model->file) echo Yii::t('app',"已上传文件:").$model->file->name;?>
     	<br/><?php echo Yii::t('app',"最大允许上传文件").$maxFileSize."M";?>
     	&nbsp;&nbsp;<?php echo CHtml::link('如何修改?',"http://eduwind.com/index.php?r=group/post&id=33",array('target'=>'_blank'));?>
     	-->

    <?php
    if ($storage == 'cloud') {
    	$this->widget('ext.uploadify.MUploadify',CloudService::getInstance("uploads/uploadFile/lesson/mediaId/".DxdUtil::randCode(32))->getUploadifySetting());
    }
    else {
    	$this->widget('ext.uploadify.MUploadify',
	    	array(
			  'name'=>'file',
	    	  'buttonText'=>Yii::t('app','选择文件'),
	    	  'uploader'=>$this->createUrl('lesson/uploadVideo',array('courseId'=>$model->courseId)),
			  'auto'=>true,
			    //根据回调的结果更新表单的MediaId字段
			  'onUploadSuccess' =>"js:function(file, data, response) {
			   					dataObj = JSON.parse(data);
			   					$('input#mediaId').val(dataObj.id);
			   					$('p#uploadFileName').html('".Yii::t('app','文件')."“' + file.name + '”".Yii::t('app','已经上传成功。')."<a id=\"reUpload\" href=\"javaScript:void(0)\">".Yii::t('app','重新上传')."</a>');
			   					$('.uploadify').uploadify('settings','buttonText',".Yii::t('app','再次上传').");
					        }",
			    'onQueueComplete'=>"js:function(queueData) {
			            $('div#file').addClass('dxd-hidden');
			        }"

		));
    }
    	echo $form->hiddenField($model,'mediaId',array('id'=>'mediaId'));
    ?>

    <div><pre><p id="uploadFileName" class="text-center text-info"><?php echo Yii::t('app','还没有选择文件');?></p></pre></div>

    </div>
    <div id="dxd-for-link" class="dxd-media-source <?php if($model->mediaSource=="self") echo 'dxd-hidden';?>">
  		 <?php echo $form->textFieldGroup($model,'mediaUri',array('class'=>'input-block-level'));?>
    </div>
	<?php /*$this->widget('booster.widgets.TbTabs', array(
	    'tabs'=>$this->getTabularFormTabs($form, $model),
	)); */?>
	<?php // echo $form->textFieldGroup($model,'homePage');?>
	<?php echo CHtml::submitButton($model->isNewRecord ? Yii::t('app','保存') : Yii::t('app','保存'),array('class'=>'pull-right btn btn-primary ml10')); ?>

<?php $this->endWidget(); ?>
<div class="clearfix"></div>
</div><!-- form -->
<script>
$(document).ready(function(){

	$("input[name='Lesson[mediaSource]']").change(function() {
		$value = $("input[name='Lesson[mediaSource]']:checked").val() ;
		if ($value== 'self'){
			$('.dxd-media-source').hide();
			$('#dxd-for-self').show();
		}
	     //   $("output").text("a changed");
	    else if ($value == 'link'){
			$('.dxd-media-source').hide();
			$('#dxd-for-link').show();
	    }
	       // $("output").text("b changed");
	});
	$("a#reUpload").live("click",function(){
		  $("div#file").removeClass('dxd-hidden');
	});


});
</script>
<style>
.dxd-hidden{
display:none;
}
</style>
