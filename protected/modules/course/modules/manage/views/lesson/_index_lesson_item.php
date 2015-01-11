<?php
/* @var $this CourseRateController */
/* @var $model CourseRate */
/* @var $form CActiveForm */
?>
<div class="dxd-hover-show-container dxd-sortable-lesson-inner">
<span class="muted"><?php echo Yii::t('app','课时');?><?php echo $data->number;?>：</span>
<?php 
echo $data->title;
?>
		<?php 
			if($data->mediaType=="quiz"):
			?><span class="text-warning ml10" style="font-size:0.9em"><?php echo Yii::t('app','测验');?></span>
			<?php endif;?>
		<?php 
			if($data->mediaType=="text"):
			?><span class="text-warning ml10" style="font-size:0.9em"><?php echo Yii::t('app','图文');?></span>
			<?php endif;?>
		<?php if($data->isFree):?>
			<span class="text-warning ml10" style="font-size:0.9em"><?php echo Yii::t('app','免费')?></span>
			<?php endif;?>
			
<div class="pull-right dxd-hover-show">
<?php 
 if(($data->mediaType=="lecture" || $data->mediaType=="video") && !$data->file){
 //	$label = ($data->file) ? '更新内容':'添加内容';
 	echo CHtml::link('<i class="icon-plus"></i>'.Yii::t('app','添加内容'),'#lesson-upload-'.$data->id,array('class'=>'ml10','data-toggle'=>'collapse')); 
 }elseif($data->mediaType=="quiz"){
 	echo CHtml::link('<i class="icon-pencil"></i>'.Yii::t('app','编辑测验'),array('quiz/view','id'=>$data->mediaId),array('class'=>'ml10')); 
 }elseif($data->mediaType=="text"){
 	echo CHtml::link('<i class="icon-pencil"></i>'.Yii::t('app','编辑图文'),array('text/update','id'=>$data->mediaId),array('class'=>'ml10')); 
 }

echo CHtml::link('<i class="icon-pencil"></i>'.Yii::t('app','编辑'),array('update','id'=>$data->id),
														array('onclick'=>'openFancyBox(this);return false;',
															  'data-fancyWidth'=>700,
															  'data-fancyHeight'=>350,
															  'class'=>'ml10'));
														echo CHtml::link('<i class="icon-plus"></i>'.Yii::t('app','附加资料'),array('lessonDoc/create','lessonId'=>$data->id),array('class'=>'dxd-fancy-elem ml10')); 
														
														
echo CHtml::link('<i class="icon-eye-open"></i>'.Yii::t('app','查看'),array('/course/lesson/view','id'=>$data->id),
														array('class'=>'ml10',
															  ));
echo CHtml::link($data->status==Lesson::STATUS_PUBLIC ?'<i class="icon-pause"></i><span class="text-warning">'.Yii::t('app','隐藏').'</span>':'<i class="icon-play"></i>发布',
				array('togglePublished','id'=>$data->id),
				array('class'=>'ml10'));
echo CHtml::link('<i class="icon-trash"></i>'.Yii::t('app','删除'),array('delete','id'=>$data->id),
														array('class'=>'ml10',
															  ));
?>
</div>
<div class="clearfix"></div>
	<div class="collapse" id="lesson-upload-<?php echo $data->id;?>" style="margin-bottom:5px">
	<?php 
	echo CHtml::link('<i class="icon-plus icon-white"></i>'.Yii::t('app','上传文件'),array('upload','lessonId'=>$data->id),array('class'=>'btn btn-success dxd-fancy-elem ml10'));
	echo CHtml::link('<i class="icon-plus icon-white"></i>'.Yii::t('app','导入外部视频'),array('link','lessonId'=>$data->id),array('class'=>'btn btn-success ml10 dxd-fancy-elem'));
	
	?>
	</div>
	<div>
	<?php if($data->mediaType=="link"):
		echo Yii::t('app',"当前内容：").$data->mediaLink->url;	
	 elseif($data->mediaType=="video" && $data->file):
		echo Yii::t('app',"当前内容：").$data->file->name;
	 endif;
	 if($data->mediaLink || $data->file) 
	  	echo CHtml::link('<i class="icon-pencil"></i>'.Yii::t('app','修改内容'),'#lesson-upload-'.$data->id,array('class'=>'ml10','data-toggle'=>'collapse')); 
	 
	 ?>
	</div>
	<?php if(!empty($data->docs)):?>
	<div id="dxd-lesson-file-<?php echo $data->id;?>">
	<?php //echo "附加资料：";?>
	<?php $this->widget('booster.widgets.TbListView',array(
		'dataProvider'=>new CArrayDataProvider($data->docs),
		'itemView'=>'_file_item',
		'template'=>'{items}{pager}',
		'htmlOptions'=>array('style'=>'margin-top:0px;'),
		'emptyText'=>false,
	)); ?>
	</div>
	<?php endif;?>
</div>
