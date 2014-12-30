<?php
/* @var $this PostController */
/* @var $model Post */
/* @var $form CActiveForm */
?>

<div class="form">

<?php $form=$this->beginWidget('booster.widgets.TbActiveForm', array(
	'id'=>'post-form',
	'enableAjaxValidation'=>isset($ajax)?true:false,
	'enableClientValidation'=>false,
	'clientOptions'=>array('validateOnSubmit'=>true,),
)); ?>

	<?php echo $form->errorSummary($model); ?>

    <?php echo $form->hiddenField($model,'groupId',array('value'=>$group->id)); ?>

    <?php echo $form->textFieldGroup($model,'title',array('class'=>'input-block-level')); ?>

	<?php $this->widget('ext.kindeditor.KindEditor',
        array(
            'model'=>$model,
            'attribute'=>'content',
        )
    ); ?>
    <?php echo $form->textAreaGroup($model, 'content', array(
        'widgetOptions'  =>  array(
            'htmlOptions'   => array('style'=>'height:200px;width:100%;','class'=>'dxd-kind-editor')
        )
    )); ?>

    <br/>

	<div class="row buttons">
			<?php $this->widget('booster.widgets.TbButton', array(
    'label'=>$model->isNewRecord ? Yii::t('app','发布') : Yii::t('app','保存'),
    'buttonType'=>'submit',
	'htmlOptions'=>array('class'=>'pull-right')
    )); ?>
	</div>

<?php $this->endWidget(); ?>

</div><!-- form -->
