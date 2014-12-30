<div class="form col-sm-8">
    <?php $form = $this->beginWidget(
        'booster.widgets.TbActiveForm',
        array(
            'enableClientValidation'=>true,
        )
    ); ?>

        <?php echo $form->textAreaGroup($model, 'html', array(
            'widgetOptions' =>  array(
                'htmlOptions' =>  array('rows'=>9)
            )
        )); ?>

        <br>
        <?php echo CHtml::submitButton('保存', array('class'=>'btn btn-success pull-right')); ?>
        <?php echo CHtml::button(
            '恢复默认',
            array(
                'class'     =>  'btn btn-default pull-right',
                'style'     =>  'margin-right:1em',
                'onclick'   =>  'location.href="' . CHtml::normalizeUrl(array('recover')) . '"',
            )
        ); ?>
    <?php $this->endWidget(); ?>
</div>
