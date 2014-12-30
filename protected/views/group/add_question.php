<?php
/* @var $medel Group */
/* @var $question Question */
?>

<h3><?php echo Yii::t('app','在 {name} 提问', array('name'=>$model->name))</h3>
<div class="row dxd-group-body">
	<div class="col-sm-9 dxd-left-col">
<?php echo $this->renderPartial('/question/_form', array('model'=>$question)); ?>
	</div>
	<div class="col-sm-3">
		<?php echo CHtml::link('< &nbsp;'.Yii::t('返回 {name}',array('name'=>$model->name)),array('group/view','id'=>$model->id));?>
	</div>
</div>
