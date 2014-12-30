<div class="form col-sm-9">

<?php $form=$this->beginWidget('booster.widgets.TbActiveForm', array(
	'id'=>'casus-form',
    'type'=>'horizontal',
	'enableAjaxValidation'=>false,
)); ?>


	<div class="row">
		<?php echo $form->textFieldGroup($model,'title',array('class'=>'col-sm-4')); ?>
	</div>

    <div class="row">
        <?php echo $form->dropDownListGroup($model, 'categoryId', array(
            'widgetOptions' =>  array(
                'data'  =>  CHtml::listData($model->getAllCategories(), 'id', 'name'),
            )
        )); ?>
    </div>

	<div class="row">
        <?php $this->widget('ext.kindeditor.KindEditor', array(
            'model'     =>  $model,
            'attribute' =>  'content',
        )); ?>
        <?php echo $form->textAreaGroup($model,'content',array(
            'widgetOptions' =>  array(
                'htmlOptions'   =>  array(
                    'rows'=>16, 'cols'=>50, 'class'=>'dxd-kind-editor'
                )
            )
        )); ?>
	</div>

    <div class="row">
        <?php echo $form->textFieldGroup($model, 'keyWord', array('class'=>'col-sm-6', 'placeholder'=>'使用半角英文逗号分隔')); ?>
    </div>

	<div class="row buttons" style="margin-left:13em">
		<?php echo CHtml::submitButton($model->isNewRecord ? '添加' : '保存', array('class'=>'btn btn-primary')); ?>
	</div>

<?php $this->endWidget(); ?>

</div><!-- form -->
