<div class="col-sm-9">
    <?php $form=$this->beginWidget(
        'booster.widgets.TbActiveForm',
        array(
            'type'  =>  'horizontal'
        )
    ); ?>
        <div class="form-group">
            <?php echo $form->labelEx($model, 'userName', array('class'=>'col-sm-3 control-label')); ?>
            <div class="col-sm-9">
                <?php $this->widget('zii.widgets.jui.CJuiAutoComplete',array(
                    'name'=>'People[userName]',
                    'sourceUrl'=>array('//u/fetchNames'),
                    'value' =>  $model->user['name'],
                    'htmlOptions'=>array(
                        'placeHolder'=>'请输入用户名，（只能添加已注册用户）',
                        'class'=>'form-control',
                    )
                )); ?>
            </div>
        </div>
        <?php echo $form->textFieldGroup($model, 'name'); ?>
        <?php echo $form->dropDownListGroup($model, 'categoryId', CHtml::listData($model->categorys, 'id', 'name')); ?>
        <?php echo $form->textAreaGroup($model, 'description', array('rows'=>6, 'class'=>'col-sm-5')); ?>
        <br>
        <?php echo TbHtml::submitButton('保存', array('class'=>'btn-primary col-sm-offset-3')); ?>
    <?php $this->endWidget(); ?>
</div>
