<div class="">
 
    <?php $form=$this->beginWidget('booster.widgets.TbActiveForm', array(
            'id'=>'question-form',
            'enableAjaxValidation'=>false,
    )); ?>
 
 
    <?php
        //show errorsummary at the top for all models
        //build an array of all models to check
        echo $form->errorSummary(array_merge(array($model),$validatedChoices));
    ?>
	<?php echo $form->textAreaGroup($model,'stem',array('class'=>'dxd-kind-editor')); ?>
		<?php echo $form->hiddenField($model,'quizId'); ?>
		<?php echo $form->hiddenField($model,'type'); ?>
		<br/>
<?php echo $form->textFieldGroup($model,'score');?>
<br/> 
<?php

    // see http://www.yiiframework.com/doc/guide/1.1/en/form.table
    // Note: Can be a route to a config file too,
    //       or create a method 'getMultiModelForm()' in the choice model
 
if($model->type=="multiple-choice" || $model->type=="single-choice"){
$choiceFormConfig = array(
          'elements'=>array(
            'content'=>array(
                'type'=>'text',
            ),
            'isCorrect'=>array(
                'type'=>$model->type=="multiple-choice"?'checkbox' : "radio",
            )
        ));

}
 
    $this->widget('ext.multimodelform.MultiModelForm',array(
            'id' => 'id_choice', //the unique widget id
            'formConfig' => $choiceFormConfig, //the form configuration array
            'model' => $choice, //instance of the form model
 			'bootstrapLayout'=>true,
    		'addItemText'=>Yii::t('app','+ 添加答案'),
        	'removeText'=>Yii::t('app','删除'),
    		'removeHtmlOptions'=>array('style'=>'text-align:right'),
    		'removeConfirm'=>Yii::t('app','删除该答案？'),
    		'tableView'=>true,	  
    		'sortAttribute'=>'weight',
    	//	'addItemAsButton'=>true,
    	//	'addItemHtmlOptions'=>array('class'=>'btn btn-success'),
    		
    
            //if submitted not empty from the controller,
            //the form will be rendered with validation errors
            'validatedItems' => $validatedChoices,
 
            //array of choice instances loaded from db
            'data' => $choice->findAll(array('condition'=>'questionId=:questionId', 
    										  'params'=>array(':questionId'=>$model->id),
    										'order'=>'weight')),
        ));
    ?>
 
    <div class="row buttons">
        <?php echo CHtml::submitButton($model->isNewRecord ? Yii::t('app','创建') : Yii::t('app','保存'),array('class'=>'btn btn-primary pull-right')); ?>
    </div>
 
    <?php $this->endWidget(); ?>
 
    </div><!-- form -->
<script type="text/javascript">
$(document).ready(function(){
	$('input[type="radio"]').change(function(){
		var name = $(this).attr('name');
		var dis = this;
		$('input[type="radio"]').each(function(index,elem){
			$(elem).attr('checked',false);
		});
		$('input[type="radio"][name="'+name+'"]').each(function(index,elem){
			$(elem).prev('input[type="hidden"]').attr('name',name);
		});
		$(this).attr('checked',true);
		$(this).attr('value',1);
		$(this).prev('input[type="hidden"]').attr('name','');
	});

	$('input[type="checkbox"]').change(function(){
		var name = $(this).attr('name');
		sName = name.replace(/\"/g, "");
		sName = sName.replace(/\'/g, "");
		if($(this).attr('checked')){
			$(this).prev('input[type="hidden"][name="'+sName+'"]').attr('name','');
			$(this).attr('value',1);
		}else{
			$(this).attr('checked',false);
			$(this).prev('input[type="hidden"]').attr('name',name).val(0);
		}
	});
});
</script>
