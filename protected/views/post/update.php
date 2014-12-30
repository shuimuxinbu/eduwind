<?php
/* @var $this PostController */
/* @var $model Post */
?>

<h3><?php echo Yii::t('app','编辑帖子')?></h3>
<div class="row dxd-course-body">
	<div class="col-sm-9 dxd-left-col">
	<?php echo $this->renderPartial('_form', array('model'=>$model)); ?>
	</div>
	<div class="col-sm-3">
	</div>
</div>

