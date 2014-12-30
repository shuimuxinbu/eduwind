<?php
/* @var $this UserController */
/* @var $model UserInfo */
/* @var $form CActiveForm */
?>

<div class="form">
    <?php $form=$this->beginWidget('booster.widgets.TbActiveForm', array(
        'id'=>'register-form',
        'enableAjaxValidation'=>TRUE,
        'clientOptions'=>array(
            'validateOnSubmit'=>true,
        )
    )); ?>

    <?php echo $form->errorSummary($model); ?>

        <?php echo $form->textFieldGroup($model,'email',array('size'=>60,'maxlength'=>64,'class'=>'input-block-level')); ?>

        <?php echo $form->textFieldGroup($model,'name',array('size'=>60,'maxlength'=>20,'class'=>'input-block-level','placeHolder'=>'')); ?>

        <?php echo $form->passwordFieldGroup($model,'password',array('size'=>60,'maxlength'=>20,'class'=>'input-block-level')); ?>

        <?php echo $form->passwordFieldGroup($model,'password2',array('size'=>60,'maxlength'=>20,'class'=>'input-block-level')); ?>

        <?php echo $form->textFieldGroup($model,'bio',array('size'=>60,'maxlength'=>200,'class'=>'input-block-level')); ?>

    <div class="row buttons">
        <?php echo CHtml::submitButton('确定',array('class'=>'btn btn-button btn-success btn-block')); ?>
    </div>

    <?php $this->endWidget(); ?>

</div><!-- form -->
