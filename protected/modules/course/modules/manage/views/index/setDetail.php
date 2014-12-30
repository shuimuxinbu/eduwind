<?php
/* @var $this CourseManageController */
/* @var $dataProvider CActiveDataProvider */
 $this->widget('booster.widgets.TbBreadcrumbs', array(
 	'homeLink'=>false,
    'links'=>array($course->name=>array('/course/index/view','id'=>$course->id), Yii::t('app',"课程管理")),
 ));
?>

<div class="row ">

	<div class="col-sm-2 dxd-course-category">
	<?php $this->renderPartial('_side_nav',array('course'=>$course));?>
	</div>
	<div class="col-sm-10">
	<h3 class="side-lined"><?php echo Yii::t('app','详细信息');?></h3>
<div class="form">

<?php $form=$this->beginWidget('booster.widgets.TbActiveForm', array(
	'id'=>'post-form',
	'enableAjaxValidation'=>isset($ajax)?true:false,
	'enableClientValidation'=>false,
	'clientOptions'=>array('validateOnSubmit'=>true,),
)); ?>

	<?php echo $form->errorSummary($course); ?>

	<div class="row">
		<?php echo $form->textFieldGroup($course,'subTitle',array('class'=>'input-block-level')); ?>
	</div>
	<div class="row">
        <?php echo $form->textAreaGroup($course,'introduction',array(
            'widgetOptions'    =>  array(
                'htmlOptions'   => array('rows'=>7, 'class'=>"input-block-level dxd-kind-editor"),
            )
        )); ?>


			<div class="row">
		<?php echo $form->textFieldGroup($course,'targetStudent',array('class'=>'input-block-level')); ?>
	</div>

	</div>
<br/>
	<div class="row buttons">
			<?php $this->widget('booster.widgets.TbButton', array(
    'context'=>'primary',
    'label'=>$course->isNewRecord ? Yii::t('app','发布') : Yii::t('app','保存'),
    'buttonType'=>'submit',
	'htmlOptions'=>array('class'=>'pull-right')
    )); ?>
	</div>

<?php $this->endWidget(); ?>

</div><!-- form -->



	</div>
</div>





