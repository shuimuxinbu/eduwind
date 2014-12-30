<?php
/* @var $this CourseController */
/* @var $model Course */
/* @var $form CActiveForm */
?>

<div class="form">

<?php $form=$this->beginWidget('booster.widgets.TbActiveForm', array(
	'id'=>'course-form',
	'enableAjaxValidation'=>false,
)); ?>


	<?php echo $form->textFieldGroup($model,'name',array('maxlength'=>64,'class'=>'input-block-level')); ?>
<br/>
    <?php // echo $form->dropDownListGroup($model, 'id', $cateItems); ?>

    <?php
//    echo $form->dropDownListGroup($model, 'categoryId',CHtml::listData($categorys,'id','name'));
 //   echo CHtml::dropDownList('categoryId')
 $categories = Category::model()->findAllByAttributes(array('type'=>'course','parentId'=>0));
 $items = CHtml::listData($categories, 'id', 'name');
   if(isset($items)){
   	   echo $form->labelEx($model,'categoryId');
   	echo CHtml::dropDownList('parentId','', $items,
			array(
			'empty'=>Yii::t('app','选择分类'),
			'ajax' => array(
			'type'=>'GET', //request type
			'url'=>CController::createUrl('//category/children'), //url to call.
			//Style: CController::createUrl('currentController/methodToCall')
			'update'=>'#cateId', //selector to update
			//'data'=>'js:javascript statusment'
			//leave out the data key to pass all form values through
			),
			//'options'=>array('0'=>array('disabled'=>true))
			));

		echo  "&nbsp;&nbsp;&nbsp";

//empty since it will be filled by the other dropdown
echo $form->dropDownList($model,'categoryId',array(), array('id'=>'cateId'));
		  echo $form->error($model,'categoryId');
   }
?>

	<div class="row buttons">
<?php $this->widget('booster.widgets.TbButton',array('label'=>$model->isNewRecord ? Yii::t('app','创建') : Yii::t('app','保存'),'buttonType'=>'submit','context'=>'primary'));?>
	</div>

<?php $this->endWidget(); ?>

</div><!-- form -->
