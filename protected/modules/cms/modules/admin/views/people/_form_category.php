<div class="form">
    <?php $form=$this->beginWidget(
        'booster.widgets.TbActiveForm',
        array(
            'id'=>'course-category-form',
            'enableAjaxValidation'=>false,
            'type'  =>  'inline',
        )
    ); ?>

    <?php echo $form->errorSummary($model); ?>

        <div class="">
        <?php echo $form->textFieldGroup($model,'name',array('size'=>60,'maxlength'=>255)); ?>
        <?php echo CHtml::submitButton($model->isNewRecord ? '创建' : '更新', array('class'=>'btn btn-default')); ?>
        </div>

    <?php $this->endWidget(); ?>
</div>
