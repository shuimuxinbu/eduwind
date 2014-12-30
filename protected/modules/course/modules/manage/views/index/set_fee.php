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
	<h3 class="side-lined"><?php echo Yii::t('app','价格设置');?></h3>
<div class="form col-sm-9">

<?php $form=$this->beginWidget('booster.widgets.TbActiveForm', array(
    'type'  =>  'horizontal',
	'id'=>'post-form',
	'enableAjaxValidation'=>isset($ajax)?true:false,
	'enableClientValidation'=>false,
	'clientOptions'=>array('validateOnSubmit'=>true,),
)); ?>

	<?php echo $form->errorSummary($course); ?>

		<?php echo $form->textFieldGroup($course,'fee',array('class'=>'')); ?>

		<?php echo $form->textFieldGroup($course,'validDay',array('append'=>Yii::t('app', '天'))); ?>

		<?php echo $form->textFieldGroup($course,'renewFee',array('append'=>Yii::t('app', '元'))); ?>

	</div>
<br/>
	<div class="row buttons col-sm-9">
			<?php $this->widget('booster.widgets.TbButton', array(
    'context'=>'primary',
    'label'=>Yii::t('app','设置'),
    'buttonType'=>'submit',
	'htmlOptions'=>array('class'=>'pull-right')
    )); ?>
	</div>

<?php $this->endWidget(); ?>

</div><!-- form -->



	</div>
</div>





