<?php
 $this->widget('booster.widgets.TbBreadcrumbs', array(
 	'homeLink'=>false,
    'links'=>array($model->name=>array('index/view','id'=>$model->id), Yii::t('app',"小组管理")),
));
?>
<div class="row">
	<div class="col-sm-2 dxd-course-category">
        <?php $this->renderPartial('_side_nav',array('group'=>$model));?>
	</div>

	<div class="col-sm-10 form">
		<h3 class="side-lined"><?php echo Yii::t('app','小组称号');?></h3>

        <?php $form=$this->beginWidget('booster.widgets.TbActiveForm', array(
            'enableClientValidation'    =>  true,
            'clientOptions' =>  array(
                'validateOnSubmit'  =>  true,
            ),
        ));?>

            <?php echo $form->textFieldGroup($model, 'leaderTitle'); ?>

            <?php echo $form->textFieldGroup($model, 'memberTitle'); ?>

            <?php echo $form->textFieldGroup($model, 'adminTitle'); ?>

        <?php $this->widget('booster.widgets.TbButton', array(
            'label'         =>  Yii::t('app','保存'),
            'buttonType'    =>  'submit',
        )); ?>
        <?php $this->endWidget(); ?>
    </div>
</div>

