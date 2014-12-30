<?php
/* @var $this CourseRateController */
/* @var $model CourseRate */
/* @var $form CActiveForm */
?>

<?php if($data->file):?>
<div>
<?php echo $data->file->name;?>
<span class="muted ml10"><?php echo $data->downloadNum;?><?php echo Yii::t('app','次下载');?></span>&nbsp;
<?php echo CHtml::link('<i class="icon-pencil"></i>'.Yii::t('app','编辑'),array('lessonDoc/update','id'=>$data->id),array('class'=>'dxd-fancy-elem ml10'));?>
<?php echo CHtml::ajaxLink('<i class="icon-trash"></i>'.Yii::t('app','删除'),
						array('lessonDoc/delete','id'=>$data->id,'ajax'=>true),
						array('type'=>'post','success'=>'js:function(data){window.location.reload();}'),
						array('confirm'=>Yii::t('app','确定删除文件？'),
								'class'=>'ml10'));?>

</div>
<?php endif;?>