<?php
/* @var $this GroupController */
/* @var $model Group */
/* @var $form CActiveForm */
?>
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
//	'action'=>array('question/create'),
	'clientOptions'=>array('validateOnSubmit'=>true,),
)); ?>

		<?php //echo $form->hiddenField($model,'groupid',array('value'=>$group->id));?>

	<?php echo $form->errorSummary($model); ?>


		<?php echo $form->textFieldGroup($model,'name',array('size'=>128,'maxlength'=>128,'class'=>'input-block-level')); ?>
<?php
		$categorys = Category::model()->findAll(array('condition'=>'type="group"','order'=>'weight asc'));
echo $form->dropDownListGroup($model, 'categoryId',array(
    'widgetOptions' =>  array(
        'data'  =>  CHtml::listData($categorys,'id','name')
    )
));

?>
	<div class="row">
        <?php echo $form->textAreaGroup($model,'introduction',array(
            'widgetOptions' =>  array(
                'htmlOptions'   =>  array(
                    'rows'=>7, 'style'=>"width:100%;",'class'=>'dxd-kind-editor'
                )
            )
        )); ?>

	</div>
		<div class="row dxd-radio" style="margin-top:10px" >
		<?php //echo $form->labelEx($model,'joinType'); ?>

		    <?php //echo $form->radioButtonListGroup($model, 'joinType', array('free'=>'自由加入','apply'=>'审核加入')); ?>
		<style type="text/css">
		.dxd-radio label.radio{
		display:inline-block;
		margin-right:20px;
		}
		</style>
	</div>

<br/>
	<div class="row buttons">
			<?php $this->widget('booster.widgets.TbButton', array(
    'label'=>$model->isNewRecord ? Yii::t('app','下一步') : Yii::t('app','保存'),
    'buttonType'=>'submit',
	'htmlOptions'=>array('class'=>'pull-right')
    )); ?>
	</div>

<?php $this->endWidget(); ?>

</div><!-- form -->
