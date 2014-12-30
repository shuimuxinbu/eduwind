<?php
/* @var $this UserController */
/* @var $model UserInfo */
/* @var $form CActiveForm */
?>
<?php
/* @var $this CourseManageController */
/* @var $dataProvider CActiveDataProvider */
 $this->widget('booster.widgets.TbBreadcrumbs', array(
 	'homeLink'=>false,
    'links'=>array($model->name=>array('/group/index/view','id'=>$model->id), Yii::t('app',"课程管理")),
));
?>

<div class="row ">

	<div class="col-sm-2 dxd-course-category">
	<?php $this->renderPartial('_side_nav',array('group'=>$model));?>
	</div>
	<div class="col-sm-10">
	<h3 class="side-lined"><?php echo Yii::t('app','小组头像');?></h3>

			<p><?php echo Yii::t('app','当前头像');?></p>
		<?php echo CHtml::image(Yii::app()->baseUrl."/".$model->face);?>
		<br/><br/>

		<div class="form">

		<?php $form=$this->beginWidget('booster.widgets.TbActiveForm', array(
			'id'=>'set-basic-form',
		//	'enableAjaxValidation'=>TRUE,
			'clientOptions'=>array(
				'validateOnSubmit'=>false,
			),
			'htmlOptions' => array(
        		'enctype' => 'multipart/form-data'
    		)
		)); ?>

			<?php echo $form->errorSummary($model); ?>
			<div class="row">
				<p><?php echo Yii::t('app','更换封面');?></p>
				<?php echo $form->fileField($model,'face',array('class'=>'btn')); ?>
				<?php echo $form->error($model,'face'); ?>
			</div>
			<div class="row buttons" style="margin-top:15px">
			<?php $this->widget('booster.widgets.TbButton', array(
    'label'=>Yii::t('app','保存'),
    'buttonType'=>'submit',
	'htmlOptions'=>array('class'=>'pull-right')
    )); ?>
    			</div>

		<?php $this->endWidget(); ?>

		</div><!-- form -->

	</div>
</div>
