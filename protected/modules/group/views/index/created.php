<?php
/* @var $this GroupController */
/* @var $model Group */

?>
<h2><?php echo Yii::t('app','小组');?> <em>"<?php echo $group->name;?>" </em><?php echo Yii::t('app','正在审核中...');?></h2>


<div class="row">
	<div class="col-sm-9">
		<div>
			<?php echo Yii::t('app','为保证未来的小组成员符合您的要求，我们强烈建议你在你的小组问答区提一个或多个问题，并将之设置为测试问题。（设有测试问题的小组会更容易获得审核通过）');?>
			<br/><br/>
			<div class="pull-right">
			<?php echo CHtml::link(Yii::t('app','不，以后再说'),array('index/view','id'=>$group->id),array('class'=>'btn'));?>&nbsp;&nbsp;	
			<?php echo CHtml::link(Yii::t('app','好的，现在就去'),array('question/create','groupid'=>$group->id),array('class'=>'btn btn-success'));?>&nbsp;&nbsp;
			</div>
		</div>
	</div>
	<div class="col-sm-3">
		
	</div>
</div>
