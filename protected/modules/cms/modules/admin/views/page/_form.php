<?php
/* @var $this PageController */
/* @var $model Page */
/* @var $form CActiveForm */
?>


<div class="form">

<?php $form=$this->beginWidget('booster.widgets.TbActiveForm', array(
    'type'  =>  'horizontal',
	'id'=>'page-form',
	// Please note: When you enable ajax validation, make sure the corresponding
	// controller action is handling ajax validation correctly.
	// There is a call to performAjaxValidation() commented in generated controller code.
	// See class documentation of CActiveForm for details on this.
	'enableAjaxValidation'=>false,
)); ?>

	<?php echo $form->errorSummary($model); ?>

	<div class="row">
        <?php echo $form->textFieldGroup($model,'title',array(
            'labelOptions'  =>  array(
                'class' =>  'col-sm-1',
            ),
        )); ?>
	</div>

    <div class="row">
        <?php echo $form->dropDownListGroup($model, 'categoryId', array(
            'labelOptions'  =>  array(
                'class' =>  'col-sm-1',
            ),
            'wrapperHtmlOptions' => array(
                'class' =>  'col-sm-5',
            ),
            'widgetOptions' =>  array(
                'data'  =>  CHtml::listData($model->getAllCategories(), 'id', 'name'),
            ),
        )); ?>
    </div>

	<div class="row">
        <?php $this->widget('ext.kindeditor.KindEditor', array(
            'model'     =>  $model,
            'attribute' =>  'content',
        )); ?>
        <?php echo $form->textAreaGroup($model, 'content', array(
            'labelOptions'  =>  array(
                'class' =>  'col-sm-1',
            ),
            'widgetOptions' =>  array(
                'htmlOptions'   =>  array('rows'=>16,'style'=>'width:100%','class'=>'dxd-kind-editor')
            )
        )); ?>
	</div>

	<div class="row buttons" style="margin-left:6em;">
		<?php echo CHtml::submitButton(($model->isNewRecord ? '创建' : '保存'),array('class'=>'btn btn-primary')); ?>
	</div>

<?php $this->endWidget(); ?>

</div><!-- form -->
