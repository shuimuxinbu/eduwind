<?php
/* @var $this GroupController */
/* @var $model Group */

?>

<h2><?php echo Yii::t('app',"申请创建小组");?></h2>
<div class="row">
	<div class="col-sm-9">
	<!--  
		<?php // if($user->answerCount>=0):?>-->
			<em> <?php echo Yii::t('app','欢迎申请创建小组。');?></em>
			<?php $this->renderPartial('_form', array('model'=>$model)); ?>
		<?php // endif?>
	</div>
	<div class="col-sm-3">
		
	</div>
</div>
