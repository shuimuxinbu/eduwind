<div class="row">
	<div class="col-sm-2 ">
		<?php $this->renderPartial("_side_nav");?>
	</div>
	<div class="col-sm-10">
		<h3 class="side-lined"><?php echo Yii::t('app','账号设置')?></h3>
		<?php $this->widget('booster.widgets.TbMenu', array(
		    'type'=>'pills', // '', 'tabs', 'pills' (or 'list')
		    'items'=>array(
		        array('label'=>Yii::t('app','基本信息'), 'url'=>array("me/setBasic")),
		        array('label'=>Yii::t('app','个人头像'), 'url'=>array("me/uploadFace")),
		        array('label'=>Yii::t('app','邮件通知'), 'url'=>array("me/receiveMail")),
		        ),
		    "htmlOptions"=>array('class'=>"")
		)); ?>
        <div class="col-sm-4 center">

            <div class="form">
                <?php $form=$this->beginWidget(
                    'booster.widgets.TbActiveForm',
                    array(
                        'clientOptions'=>array(
                            'validateOnSubmit'=>true,
                        )
                    )
                ); ?>

                    <?php echo $form->checkBoxGroup($model, 'receiveMailNotify'); ?>
                    <?php echo TbHtml::submitButton('保存', array('class'=>'btn-success')); ?>
                <?php $this->endWidget(); ?>
            </div>

		</div>
	</div>
</div>

