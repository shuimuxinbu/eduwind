<?php
/* @var $this GroupController */
/* @var $model Post */
?>

<h3><?php echo Yii::t('app','在{name}发布新帖',array('name'=>$group->name))</h3>
<div class="row dxd-group-body">
	<div class="col-sm-9 dxd-left-col">
<?php echo $this->renderPartial('/post/_form', array('model'=>$post)); ?>
	</div>
	<div class="col-sm-3">
		<?php echo CHtml::link(Yii::t('app','< &nbsp;返回{name}',array('name'=>$group->name)),array('group/view','id'=>$group->id));?>
	</div>
</div>
