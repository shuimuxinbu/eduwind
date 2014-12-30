
            <h3 class="side-lined">文章管理</h3>
            <div class="col-sm-6 center">
            <h4>上传文章封面</h4>
            <p>当前封面</p>
            <?php echo CHtml::image(Yii::app()->baseUrl."/".$model->face, '', array('style'=>'max-height:250px;'));?>
            <br/><br/>

            <div class="form">
            <?php $form=$this->beginWidget('booster.widgets.TbActiveForm', array(
                'id'=>'set-basic-form',
                'clientOptions'=>array(
                    'validateOnSubmit'=>false,
                ),
                'htmlOptions' => array(
                    'enctype' => 'multipart/form-data'
                )
            )); ?>

                <?php echo $form->errorSummary($model); ?>
                <div class="row">
                    <p>更换头像</p>
                    <?php echo $form->fileField($model,'face',array('class'=>'btn')); ?>
                    <?php echo $form->error($model,'face'); ?>
                </div>
                <div class="row buttons" style="margin-top:15px">
                <?php echo CHtml::link('跳过', array('index'), array('class'=>'btn btn-default pull-right', 'style'=>'margin-left:1em')); ?>
                <?php $this->widget('booster.widgets.TbButton', array(
                        'context'=>'success',
                        'label'=>'下一步',
                        'buttonType'=>'submit',
                        'htmlOptions'=>array('class'=>'pull-right')
                )); ?>
                </div>

            <?php $this->endWidget(); ?>

            </div>
        </div>
