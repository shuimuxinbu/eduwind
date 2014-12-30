
<h3 class="side-lined">支付设置</h3>

<p><em>暂时只支持集成支付宝</em>&nbsp;&nbsp;
 	<?php echo CHtml::link("如何接入支付宝?","http://help.alipay.com/support/index_sh.htm",array('target'=>'_blank'));?>
</p>
<?php
/* @var $this AnswerController */
/* @var $model Answer */
/* @var $form CActiveForm */
?>
<div class="form col-sm-9">

<?php $form=$this->beginWidget('booster.widgets.TbActiveForm', array(
	'id'=>'ali-pay-form',
	    'type'=>'horizontal',

	// Please note: When you enable ajax validation, make sure the corresponding
	// controller action is handling ajax validation correctly.
	// There is a call to performAjaxValidation() commented in generated controller code.
	// See class documentation of CActiveForm for details on this.
	'enableAjaxValidation'=>false,
)); ?>

	<?php echo $form->errorSummary($model); ?>

 <?php echo $form->radioButtonListGroup($model, 'means', array(
        'none'=>'不使用支付工具',
        'aliDual'=>'支付宝双功能收款  (需要在'.CHtml::link('网站设置',array('site')).'中把url格式设为“路径式”)',
        'aliDirect'=>'支付宝即时到账  (需要在'.CHtml::link('网站设置',array('site')).'中把url格式设为“路径式”)',
        'stripe'=>'Stripe',

 )); ?>
    <hr/>
     <?php /*echo $form->radioButtonListGroup($model, 'aliEnabled', array(
        '1'=>'是',
        '0'=>'否',
    )); */?>
		<?php echo $form->textFieldGroup($model,'aliSellerAccount',array('value'=>$model->aliSellerAccount)); ?>

		<?php echo $form->textFieldGroup($model,'aliPartner',array('value'=>$model->aliPartner)); ?>

		<?php echo $form->textFieldGroup($model,'aliKey',array('value'=>$model->aliKey)); ?>

		<?php echo $form->textFieldGroup($model,'stripePublishableKey'); ?>

		<?php echo $form->textFieldGroup($model,'stripeSecretKey'); ?>

	<div class="row buttons">
		<?php echo CHtml::submitButton('保存',array('class'=>'btn btn-primary pull-right')); ?>
	</div>

<?php $this->endWidget(); ?>

</div><!-- form -->
