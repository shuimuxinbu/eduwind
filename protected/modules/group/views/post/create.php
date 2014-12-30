<?php
/* @var $this GroupController */
/* @var $model Post */
?>

<h3><?php echo Yii::t('app','在');?> <em><?php echo $group->name?></em> <?php echo Yii::t('app','发布新帖');?></h3>
<div class="row dxd-group-body">
	<div class="col-xs-9 dxd-left-col">
<?php echo $this->renderPartial('_form', array('model'=>$post,'group'=>$group)); ?>
	</div>
	<div class="col-xs-3">
		<?php echo CHtml::link('< &nbsp;'.Yii::t('app','返回').$group->name,array('index/view','id'=>$group->id));?>
	</div>
</div>
