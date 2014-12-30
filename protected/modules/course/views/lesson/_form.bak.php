<?php
/* @var $this LessonController */
/* @var $model Lesson */
/* @var $form CActiveForm */
?>


<div class="form dxd-lessons-form">

	<?php $form=$this->beginWidget('CActiveForm', array(
	        'id'=>'lessons-form',
	        'enableAjaxValidation'=>false,
	)); ?>

	<?php
	    //show errorsummary at the top for all models
	    //build an array of all models to check
	    echo $form->errorSummary($validatedLessons);
	?>

	<?php

	// see http://www.yiiframework.com/doc/guide/1.1/en/form.table
	// Note: Can be a route to a config file too,
	//       or create a method 'getMultiModelForm()' in the member model

	$lessonFormConfig = array(
	      'elements'=>array(
	        'title'=>array(
	            'type'=>'text',
	            'maxlength'=>255,
	        	'class'=>'col-sm-5',
	        ),
	        'url'=>array(
	            'type'=>'text',
	            'maxlength'=>255,
	        	'class'=>'col-sm-5',
	        )
	    ));

	$this->widget('ext.multimodelform.MultiModelForm',array(
	        'id' => 'id_lessons', //the unique widget id
	        'formConfig' => $lessonFormConfig, //the form configuration array
	        'model' => $lesson, //instance of the form model

	        //if submitted not empty from the controller,
	        //the form will be rendered with validation errors
	        'validatedItems' => $validatedLessons,
	    	'bootstrapLayout'=>true,
	 		'addItemText'=>Yii::t('app','+添加课时'),
			'removeText'=>Yii::t('app','删除'),
			'removeConfirm'=>Yii::t('app','确定删除课时？'),
			'sortAttribute' => 'weight',
			'fieldsetWrapper'=>array('tag'=>'li','htmlOptions'=>array('class'=>'dxd-lesson-edit-item')),
			'orderListWrapper'=>true,
	//		'rowWrapper'=>array('tag'=>'li','htmlOptions'=>array('class'=>'')),
			'removeLinkWrapper'=>array('tag'=>'p','htmlOptions'=>array('class'=>'dxd-lesson-delete-link')),
	        //array of member instances loaded from db
	        'data' => $lesson->findAll( array('condition'=>'courseId='.$course->courseId,'order'=>'weight asc,addTime asc')),
	    ));
	?>

	<div class="row">
	<?php $this->widget('booster.widgets.TbButton', array(
	    'label'=>Yii::t('app','保存'),
			'buttonType'=>'submit',
	    'context'=>'primary', // null, 'primary', 'info', 'success', 'warning', 'danger' or 'inverse'
		'htmlOptions'=>array('class'=>'pull-right'),
	)); ?>
	</div>

<?php $this->endWidget(); ?>

</div><!-- form -->

<style type="text/css">
.dxd-lessons-form label{
float: left;
margin-right: 15px;
margin-top:8px;
position: relative;
text-align: right;
width: 70px;
}
.mmf_additem{
text-align:center;
}
</style>
