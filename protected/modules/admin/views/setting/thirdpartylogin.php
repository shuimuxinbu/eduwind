
<h3 class="side-lined">第三方登陆设置</h3>

<p><em>暂时只支持qq，人人登陆</em>&nbsp;&nbsp;
 	<?php echo CHtml::link("如何接入qq?","http://help.alipay.com/support/index_sh.htm",array('target'=>'_blank'));?>
 	<?php echo CHtml::link("如何接入人人网?","http://help.alipay.com/support/index_sh.htm",array('target'=>'_blank'));?>
</p>
<?php
/* @var $this AnswerController */
/* @var $model Answer */
/* @var $form CActiveForm */
?>
<div class="form">

<?php $form=$this->beginWidget('bootstrap.widgets.TbActiveForm', array(
	'id'=>'qq-login-form',
	    'type'=>'horizontal',

	// Please note: When you enable ajax validation, make sure the corresponding
	// controller action is handling ajax validation correctly.
	// There is a call to performAjaxValidation() commented in generated controller code.
	// See class documentation of CActiveForm for details on this.
	'enableAjaxValidation'=>false,
)); ?>

	<?php echo $form->errorSummary($model); ?>

 <?php echo $form->radioButtonListRow($model, 'means', array(
        'none'=>'不使用第三方登陆',
        'qq'=>'qq登陆设置  ',
        'renren'=>'人人网登陆设置 ',
 )); ?>
    <hr/>
     <?php echo $form->radioButtonListRow($model, 'qqEnable', array(
        '1'=>'是',
        '0'=>'否',
    )); ?>

		<?php echo $form->textFieldRow($model,'qqAppId',array('value'=>$model->qqAppId)); ?>

		<?php echo $form->textFieldRow($model,'qqKey',array('value'=>$model->qqKey)); ?>
	
		
	<div class="row buttons">
		<?php echo CHtml::submitButton('保存',array('class'=>'btn btn-primary pull-right')); ?>
	</div>

<?php $this->endWidget(); ?>

</div><!-- form -->