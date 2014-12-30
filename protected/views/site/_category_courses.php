<div class="row" style="margin-top:50px">
<div class="col-xs-12">
	<div  style="margin-bottom:26px;font-size:2em;" class="light-green"><?php echo $data->name;?>
	<?php //echo CHtml::link('<em>更多</em>',array('group/index'),array('style'=>'font-size:16px;font-weight:normal;'));?>
	<div class="pull-right" style="font-size:14px; line-height:40px;">
	<?php echo CHtml::link(Yii::t('app','查看全部 》'),array('course/index'),array('class'=>'theme-color'));?>
	</div>
	</div>
		<?php

		$this->widget('booster.widgets.TbThumbnails', array(
		  //  'dataProvider'=>new CActiveDataProvider('Course',array('criteria'=>array('order'=>'memberNum desc'),'pagination'=>array('pageSize'=>4))),
		    'dataProvider'=>Course::model()->getDataProviderByCategory($data->id,4),
			'template'=>"{items}",
		    'itemView'=>'_course_item_2',
		    'emptyText'=>Yii::t('app','暂时还没有该类课程')
		));
	?>
</div>
</div>
