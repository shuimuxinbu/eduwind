<?php
/* @var $this GroupMemberController */
/* @var $model GroupMember */
 $this->widget('booster.widgets.TbBreadcrumbs', array(
    'links'=>array($group->name=>array('group/view','id'=>$group->id),
 					Yii::t('app','申请加入小组')),
 	'homeLink'=>false));
?>
<div class="row">
	<div class="col-sm-9">
		<h2><?php echo Yii::t('app','申请加入')?> <em><?php echo $group->name;?></em></h2>
		<div>
			<?php echo Yii::t('app','您必须回答至少回答以下问题中的一个，申请才会被提交.')?>
			<br/>
			<?php echo Yii::t('app','您已回答其中')?> <em style="font-weight:bold;font-size:1.5em;"><?php echo $answerCount;?> </em><?php echo Yii::t('app','个问题。'); ?>
			<?php if($answerCount>0) echo "申请已经被提交，请耐心等候小组组长的审核";?>
		</div>
		<br/>

		<?php
			$this->widget('booster.widgets.TbListView', array(
		    'dataProvider'=>$questionDataProvider,
		    'itemView'=>'/group/_question_item',   // refers to the partial view named '_post'
			'summaryText'=>false,
		//	'emptyText'=>'还没有人提问',
			'separator' => '<hr style="margin:15px 0;"/>',
		));
		?>
	</div>
	<div class="col-sm-3">
			<?php //echo CHtml::link("返回".$group->name."小组",array('group/view'));?>
	</div>
</div>
