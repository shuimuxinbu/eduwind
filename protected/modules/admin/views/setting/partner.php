
<h3 class="side-lined">外部应用</h3>

<p><em>暂时只支持集成UCenter（Dicuz）</em>&nbsp;&nbsp;
 	<?php echo CHtml::link("如何集成UCenter?","#",array('target'=>'_blank'));?>
</p>
<?php
/* @var $this AnswerController */
/* @var $model Answer */
/* @var $form CActiveForm */
?>
<div class="form col-sm-9">

<?php $form=$this->beginWidget('booster.widgets.TbActiveForm', array(
	'id'=>'partner-form',
	    'type'=>'horizontal',
	'enableAjaxValidation'=>false,
)); ?>

	<?php echo $form->errorSummary($model); ?>

 <?php echo $form->radioButtonListGroup($model, 'mode', array(
     'widgetOptions'    =>  array(
         'data' =>  array(
            'none'=>'无',
            'ucenter'=>'UCenter(Discuz)',
         )
     )
 )); ?>
    <hr/>
		<?php echo $form->textAreaGroup($model,'config',array('class'=>'col-sm-5', 'rows'=>10, 'placeholder'=>'在此粘贴配置内容')); ?>

	<div class="row buttons">
		<?php echo CHtml::submitButton('保存',array('class'=>'btn btn-primary pull-right')); ?>
	</div>

<?php $this->endWidget(); ?>

</div><!-- form -->
