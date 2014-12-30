<?php $form=$this->beginWidget('booster.widgets.TbActiveForm', array()); ?>
        <?php echo $form->textAreaGroup($model, 'content', array(
            'widgetOptions' =>  array(
                'htmlOptions'   =>  array(
                    'placeholder'=>Yii::t('app','请输入公告内容'), 'class'=>'input-block-level', 'rows'=>'4'
                )
            )
        )); ?>

    <?php echo CHtml::submitButton($model->isNewRecord ? Yii::t('app','发布公告') : Yii::t('app','更新公告'), array('class'=>'btn btn-primary pull-right', 'style'=>'margin-top:8px')); ?>
<?php $this->endWidget(); ?>
