<?php
/* @var $this GroupManageController */
/* @var $dataProvider CActiveDataProvider */
 $this->widget('booster.widgets.TbBreadcrumbs', array(
 	'homeLink'=>false,
    'links'=>array($group->name=>array('index/view','id'=>$group->id), Yii::t('app',"小组管理")),
));
?>

<div class="row ">

	<div class="col-xs-2 dxd-course-category">
	<?php $this->renderPartial('_side_nav',array('group'=>$group));?>
	</div>
	<div class="col-xs-10">
	<h3 class="side-lined"><?php echo Yii::t('app','基本信息');?></h3>
		<h4><?php echo Yii::t('app','小组名称与分类');?></h4>
		<?php $this->renderPartial('/index/_form',array('model'=>$group));?>
	</div>
</div>


