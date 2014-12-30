<script type="text/javascript">
<!--

//-->

</script>
<div class="row">
	<div class="col-sm-2 ">
		<?php $this->renderPartial("_side_nav",array('user'=>$user));?>
	</div>
	<div class="col-sm-10">
		<h3 class="side-lined"><?php echo Yii::t('app','我的课表')?></h3>
		<?php $this->widget('booster.widgets.TbMenu', array(
		    'type'=>'pills', // '', 'tabs', 'pills' (or 'list')
		    'items'=>array(
		        array('label'=>Yii::t('app','参加'), 'url'=>array("me/courseJoin")),
		        array('label'=>Yii::t('app','收藏'), 'url'=>array("me/courseCollect")),
		 //       array('label'=>'完成', 'url'=>array("me/courseLearned")),
		        array('label'=>Yii::t('app','我管理的'), 'url'=>array("me/courseAdmin") ),
		    ),
		    "htmlOptions"=>array('class'=>"dxd-course-status")
		)); ?>
		<div class="dxd-course-status-content">
		<?php 
			$link = CHtml::link('<em>'.Yii::t('app','点击这里找到课程')).'</em>',array('course/index'));
			$this->widget('booster.widgets.TbThumbnails', array(
				    'dataProvider'=>$courseDataProvider,
				    'template'=>"{items}\n{pager}",
				    'itemView'=>'/course/_card',
					'emptyText'=>Yii::t('app','课程列表为空 ').$link,
				));
	?>
	</div>
	</div>
</div>
