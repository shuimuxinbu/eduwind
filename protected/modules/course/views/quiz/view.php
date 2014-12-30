<?php
/* @var $this LessonController */
/* @var $quiz Lesson */
$this->pageTitle = Yii::app()->name."-$lesson->title";

 $this->widget('booster.widgets.TbBreadcrumbs', array(
 	'homeLink'=>false,
    'links'=>array($lesson->course->name=>array('index/view','id'=>$lesson->course->id), $lesson->title),
));

?>
<h3><?php echo $lesson->title?></h3>

<div class="row">
<div class="col-sm-9 center">
<?php
$form = $this->beginWidget('booster.widgets.TbActiveForm', array(
    'id'=>'horizontalForm',
    'type'=>'horizontal',
));
?>
<div>
	<?php  if($report && $showAnalyse): ?>
	<div class="lead">
	<span class="text-success"><?php echo Yii::t('app','得分:');?>
	<?php echo $report->score;?>
	</span>
	&nbsp;&nbsp;&nbsp;
	<span class="text-success"><?php echo Yii::t('app','正确:');?>
	<?php echo $report->correctNum;?>
	</span>
	&nbsp;&nbsp;&nbsp;<span class="text-warning"><?php echo Yii::t('app','部分正确:');?>
	<?php echo $report->partialCorrectNum;?>
	</span>
	&nbsp;&nbsp;&nbsp;<span class="text-error"><?php echo Yii::t('app','错误:');?>
	<?php echo $report->wrongNum;?>
	</span>
	</div>
	<?php
	endif;
	?>

</div>
<br/>
<?php
$this->widget('booster.widgets.TbListView',
					array('dataProvider'=>$questionDataProvider,
							'itemView'=>'_question_item',
							'separator'=>'<hr style="margin:15px 0;"/>',
							'template'=>"{items}",
							'viewData'=>array('form'=>$form,'marked'=>($report?true:false),'showAnalyse'=>$showAnalyse),
							'summaryText'=>false));
?>
<?php if($showAnalyse):?>
<div>
<?php echo Yii::t('app','总题数:');?> <?php echo $questionDataProvider->totalItemCount;?>&nbsp;&nbsp;&nbsp;
<?php echo Yii::t('app','已作答:')?> <span id="responsed-count">0</span>
</div>
<?php endif;?>
<br/>
<script type="text/javascript">
$(document).ready(function(){
	$('input').change(function(){
		var name = $(this).attr('name');
		name =  name.replace(/\"/g, "").replace(/\'/g, "");
		var checked = false;
		$('input[name="'+name+'"]').each(function(index,elem){
			checked = $(elem).attr('checked') || checked;
		});
		if(checked)$(this).parents(".dxd-question-item").addClass('question-done');
		else $(this).parents(".dxd-question-item").removeClass('question-done');
	 	$("#responsed-count").text($(".question-done").size());
	});
 	$("#responsed-count").text($(".question-done").size());
});
</script>
<?php
if(!$report){
	$this->widget('booster.widgets.TbButton', array(
				'buttonType'=>'submit',
				'context'=>'primary',
				'label'=>Yii::t('app',"提交"),
	));
}else{
	echo CHtml::link('已完成','',array('class'=>'btn disabled mr10'));
	if(!$showAnalyse)echo CHtml::link(Yii::t('app','查看解析'),array('take','id'=>$lesson->quiz->id,'showAnalyse'=>1),array('class'=>'btn btn-primary'));
	else  echo CHtml::link(Yii::t('app','隐藏解析'),array('take','id'=>$lesson->quiz->id,'showAnalyse'=>0),array('class'=>'btn'));
}
?>

<?php

?>
<?php
$this->endWidget();
?>
</div>

</div>
<?php  Yii::app()->clientScript->registerScript("viewNum",
												'$.get("'.$this->createUrl('counter',array('id'=>$lesson->id)).'");'
												);?>


