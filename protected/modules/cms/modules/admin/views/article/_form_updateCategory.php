<div class="form col-sm-9">
    <?php $form=$this->beginWidget(
        'booster.widgets.TbActiveForm',
        array(
            'id'=>'course-category-form',
            'enableAjaxValidation'=>false,
        )
    ); ?>

    <?php echo $form->errorSummary($model); ?>

        <div class="">
        <?php echo $form->textFieldGroup($model,'name',array('size'=>60,'maxlength'=>255)); ?>
        </div>

        <div class="buttons">
        <?php echo CHtml::submitButton($model->isNewRecord ? 'Create' : 'Save', array('class'=>'btn btn-default')); ?>
        </div>

    <?php $this->endWidget(); ?>
</div>
