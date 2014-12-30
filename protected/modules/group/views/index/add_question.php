<?php
/* @var $medel Group */
/* @var $question Question */
?>

<h3><?php echo Yii::t('app','在');?><em><?php echo $model->name?></em> <?php echo Yii::t('app','提问');?></h3>
<div class="row dxd-group-body">
	<div class="col-sm-9 dxd-left-col">
<?php echo $this->renderPartial('/question/_form', array('model'=>$question)); ?>
	</div>
	<div class="col-sm-3">
		<?php echo CHtml::link('< &nbsp;'.Yii::t('app','返回').$model->name,array('index/view','id'=>$model->id));?>
	</div>
</div>
