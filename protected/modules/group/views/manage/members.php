<?php
/* @var $this GroupManageController */
/* @var $dataProvider CActiveDataProvider */
 $this->widget('booster.widgets.TbBreadcrumbs', array(
 	'homeLink'=>false,
    'links'=>array($group->name=>array('index/view','id'=>$group->id), Yii::t('app',"小组管理")),
));
?>

<div class="row ">

	<div class="col-sm-2 dxd-course-category">
	<?php $this->renderPartial('_side_nav',array('group'=>$group));?>
	</div>
	<div class="col-sm-10">
		<h3 class="side-lined"><?php echo Yii::t('app','成员管理');?></h3>
<h4><?php echo Yii::t('app','超级管理员');?></h4>
	<?php $this->widget('booster.widgets.TbListView', array(
			    'dataProvider'=>$superAdminDataProvider,
			    'template'=>"{items}\n{pager}",
				'separator'=>'<hr style="margin:10px 0;"/>',
				'viewData'=>array('group'=>$group),
				'itemView'=>'_member_item',   // refers to the partial view named '_post'
		)); ?>
		<br/>
<h4><?php echo Yii::t('app','管理员');?></h4>
	<?php $this->widget('booster.widgets.TbListView', array(
			    'dataProvider'=>$adminDataProvider,
			    'template'=>"{items}\n{pager}",
				'separator'=>'<hr style="margin:10px 0;"/>',
				'emptyText'=>Yii::t('app','暂时还没有'),
				'viewData'=>array('group'=>$group),
				'itemView'=>'_member_item',   // refers to the partial view named '_post'
		)); ?>
				<br/>


<h4><?php echo Yii::t('app','普通成员')?></h4>
	<?php
	//var_dump($memberDataProvider->getData());
	 $this->widget('booster.widgets.TbListView', array(
			    'dataProvider'=>$memberDataProvider,
			    'template'=>"{items}\n{pager}",
				'emptyText'=>Yii::t('app','暂时还没有'),
				'separator'=>'<hr style="margin:10px 0;"/>',
				'viewData'=>array('group'=>$group),
				'itemView'=>'_member_item',   // refers to the partial view named '_post'
		)); ?>

	</div>
</div>

