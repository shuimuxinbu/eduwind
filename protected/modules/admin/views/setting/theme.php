<?php
$themes = $this->getThemes();
?>
<h3 class="side-lined">主题设置</h3>

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

	<?php echo $form->errorSummary($model);
	$items = array();
	foreach($themes as $theme){
		$items[$theme['name']] = $theme['name'];
	}
	?>

<?php echo $form->radioButtonListGroup($model,'name', array(
    'widgetOptions' =>  array(
        'data'  =>  $items,
    )
)); ?>
    <hr/>
     <?php /*echo $form->radioButtonListGroup($model, 'aliEnabled', array(
        '1'=>'是',
        '0'=>'否',
    )); */?>

	<div class="row buttons">
		<?php echo CHtml::submitButton('保存',array('class'=>'btn btn-primary pull-right')); ?>
	</div>

<?php $this->endWidget(); ?>

</div><!-- form -->
