<div class="container">
<div class="row">
<div class="col-sm-2">
<?php $this->renderPartial("_side_nav");?>
</div>
<div class="col-sm-10">
<h3 class="side-lined">网站设置</h3>


<?php
/* @var $this AnswerController */
/* @var $model Answer */
/* @var $form CActiveForm */
?>
<div class="form">

<?php $form=$this->beginWidget('booster.widgets.TbActiveForm', array(
	'id'=>'open-auth-form',
	// Please note: When you enable ajax validation, make sure the corresponding
	// controller action is handling ajax validation correctly.
	// There is a call to performAjaxValidation() commented in generated controller code.
	// See class documentation of CActiveForm for details on this.
	    'type'=>'horizontal',
	'enableAjaxValidation'=>false,
)); ?>

	<?php echo $form->errorSummary($model); ?>

    <?php echo $form->radioButtonListGroup($model, 'chatEnabled', array(
        'widgetOptions' =>  array(
            'data'  =>  array(
                '1'=>'是',
                '0'=>'否',
            )
        )
    )); ?>



	<div class="row buttons">
		<?php echo CHtml::submitButton('保存',array('class'=>'btn btn-primary pull-right')); ?>
	</div>

<?php $this->endWidget(); ?>

</div><!-- form -->
</div>
</div>
</div>
