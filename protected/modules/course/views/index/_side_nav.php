<?php 
$items = array(array('label'=>Yii::t('app','最新&最热门'),'url'=>array('course/index')),
				array('label'=>Yii::t('app','课程分类')));
$items = array_merge_recursive($items,Course::model()->getCategoryItems());
$this->widget('booster.widgets.TbMenu', array(
    'type'=>'list',
    'items'=>$items,
)); ?>
	<?php if(Yii::app()->user->checkAccess('teacher'))
			 echo CHtml::link(Yii::t('app','+创建课程'),array('create'));?>
