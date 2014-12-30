<?php
/* @var $this PostController */
/* @var $model Post */

$this->breadcrumbs=array(
	'Posts'=>array('index'),
	'Create',
);

?>

<h3><?php echo Yii::t('app','在')?> <em><?php echo $group->name?></em><?php echo Yii::t('app', '发布新帖')?></h3>
<div class="row dxd-group-body">
	<div class="col-sm-9 dxd-left-col">
<?php echo $this->renderPartial('_form', array('model'=>$post)); ?>
	</div>
	<div class="col-sm-3">
		<?php echo CHtml::link('< &nbsp;'.Yii::t('app','返回').$group->name,array('group/view','id'=>$group->id));?>
	</div>
</div>
