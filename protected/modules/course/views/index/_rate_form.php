<?php
/* @var $this CourseRateController */
/* @var $model CourseRate */
/* @var $form CActiveForm */
?>

<div class="form">

<?php $form=$this->beginWidget('booster.widgets.TbActiveForm', array(
	'id'=>'course-rate-form',
	'enableAjaxValidation'=>false,
	'action'=>$action,
)); ?>
		<div class="">

		<?php echo $form->labelEx($model,'score');?>
		        <?php
		                $this->widget('CStarRating',array(
		                          'model'=>$model,
		                          'attribute'=>'score',
		                          'minRating'=>2,
		                          'maxRating'=>10,
		                		  'ratingStepSize'=>2,
		                          'starCount'=>5,
		                		  'allowEmpty'=>false,
		                		 'titles'=>array(2=>Yii::t('app','很差'),4=>Yii::t('app','较差'),6=>Yii::t('app','还行'),8=>Yii::t('app','推荐'),10=>Yii::t('app','力荐')),
		                          'readOnly'=>false,
		                        ));
		                 ?>

		</div>
<br/>
		<div class="">
			<?php echo $form->textAreaGroup($model, 'content', array('class'=>'dxd-elastic-form','style'=>'width:96%','rows'=>3, 'placeHolder'=>"写下评价内容")); ?>
		</div>

	<div class="buttons">
<?php $this->widget('booster.widgets.TbButton', array(
    'label'=>$model->isNewRecord ? Yii::t('app','创建') : Yii::t('app','保存'),
    'context'=>'primary', // null, 'primary', 'info', 'success', 'warning', 'danger' or 'inverse'
	'buttonType'=>'submit',
	'htmlOptions'=>array('class'=>'pull-right'),
)); ?>
	</div>

<?php $this->endWidget(); ?>
<div class="clearfix"></div>
</div><!-- form -->
