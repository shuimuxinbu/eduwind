<?php
/* @var $this UserController */
/* @var $model UserInfo */
/* @var $form CActiveForm */
?>

<div class="row">
	<div class="col-sm-2 ">
		<?php $this->renderPartial("_side_nav");?>
	</div>
	<div class="col-sm-10">
		<h3 class="side-lined"><?php echo Yii::t('app','账号设置')?></h3>
		<?php $this->widget('booster.widgets.TbMenu', array(
		    'type'=>'pills', // '', 'tabs', 'pills' (or 'list')
		    'items'=>array(
		        array('label'=>Yii::t('app','基本信息'), 'url'=>array("me/setBasic")),
		        array('label'=>Yii::t('app','个人头像'), 'url'=>array("me/uploadFace")),
		        array('label'=>Yii::t('app','邮件通知'), 'url'=>array("me/receiveMail")),
		        ),
		    "htmlOptions"=>array('class'=>"")
		)); ?>
		<div class="col-sm-6 center">

		<div class="form">

		<?php $form=$this->beginWidget('booster.widgets.TbActiveForm', array(
			'id'=>'set-basic-form',
			'clientOptions'=>array(
				'validateOnSubmit'=>true,
			)
		)); ?>

			<?php echo $form->errorSummary($model); ?>

			<div class="row">
				<?php echo $form->labelEx($model,'name'); ?>
				<?php echo $form->textField($model,'name',array('size'=>60,'maxlength'=>20,'class'=>'input-block-level','placeHolder'=>Yii::t('app','强烈推荐使用真实姓名'))); ?>
				<?php echo $form->error($model,'name'); ?>
			</div>


			<div class="row">
				<?php echo $form->labelEx($model,'bio'); ?>
				<?php echo $form->textField($model,'bio',array('size'=>60,'maxlength'=>200,'class'=>'input-block-level')); ?>
				<?php echo $form->error($model,'bio'); ?>
			</div>

			<div class="row">
				<?php echo $form->labelEx($model,'introduction'); ?>
				<?php echo $form->textArea($model,'introduction',array('class'=>'input-block-level','rows'=>6)); ?>
				<?php echo $form->error($model,'introduction'); ?>
			</div>
			<div class="row buttons" style="margin-top:15px">
			<?php $this->widget('booster.widgets.TbButton', array(
    'label'=>Yii::t('app','保存'),
    'buttonType'=>'submit',
	'htmlOptions'=>array('class'=>'btn-block')
    )); ?>
    			</div>

		<?php $this->endWidget(); ?>

		</div><!-- form -->
		</div>
	</div>
</div>

