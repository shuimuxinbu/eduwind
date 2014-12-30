
<h3 class="side-lined">网站设置</h3>


<?php
/* @var $this AnswerController */
/* @var $model Answer */
/* @var $form CActiveForm */
?>
<div class="form">

<?php $form=$this->beginWidget('booster.widgets.TbActiveForm', array(
	'id'=>'site-form',
	    'type'=>'horizontal',
	// Please note: When you enable ajax validation, make sure the corresponding
	// controller action is handling ajax validation correctly.
	// There is a call to performAjaxValidation() commented in generated controller code.
	// See class documentation of CActiveForm for details on this.
	'enableAjaxValidation'=>false,
	'htmlOptions'=>array('enctype'=>"multipart/form-data", 'class'=>'col-sm-9'),
)); ?>

	<?php echo $form->errorSummary($model); ?>


		<?php echo $form->textFieldGroup($model,'name',array('value'=>$model->name)); ?>


		<?php echo $form->textFieldGroup($model,'subTitle',array('value'=>$model->subTitle)); ?>

		<?php echo $form->fileFieldGroup($model,'logo'); ?>
		<div class="control-group">
			<div class="controls">
			<?php
			if($model->logo)
				echo CHtml::image(Yii::app()->baseUrl."/".$model->logo,"",array('style'=>'width:100px;background-color:#f5f5f5;padding:10px;',));
			?>
			</div>
		</div>
		<?php echo $form->textFieldGroup($model,'icp',array('value'=>$model->icp)); ?>
		<?php echo $form->textFieldGroup($model,'poweredBy',array('value'=>$model->poweredBy)); ?>
		<?php echo $form->textFieldGroup($model,'poweredByUrl',array('value'=>$model->poweredByUrl)); ?>

        <?php echo $form->radioButtonListGroup(
            $model,
            'urlFormat',
            array(
                'widgetOptions' =>  array(
                    'data'  =>  array(
                        'query'=>'查询式，形如：http://eduwind.com/index.php?r=course/view&id=12',
                        'path'=>'路径式，形如：http://eduwind.com/course/12.(注意，需要开启伪静态！)'
                    )
                )
            )
        ); ?>


		<?php echo $form->textAreaGroup($model,'analytic',array('value'=>$model->analytic,'class'=>'col-sm-5', 'rows'=>10, 'placeholder'=>'在此粘贴google analytics 统计代码 或 百度统计代码')); ?>

	<div class="row buttons">
		<?php echo CHtml::submitButton('保存',array('class'=>'btn btn-primary pull-right')); ?>
	</div>

<?php $this->endWidget(); ?>

</div><!-- form -->
