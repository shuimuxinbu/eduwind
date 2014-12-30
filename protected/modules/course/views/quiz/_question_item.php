<?php
$response = $data->userResponse(Yii::app()->user->id);
if($response){
	$done = true;
}else{
	$done = false;
	$response or $response =  new QuestionResponse();
}

$response->questionId or $response->questionId = $data->id;

?>
<div class="dxd-question-item <?php echo $done ? "question-done":"";?>">
<div style="font-size: 1.3em;color:#666;margin-bottom:10px;"><?php echo Yii::t('app',"问题 ").($index+1);?></div>
<?php echo $data->stem;?>
<?php
$this->widget('booster.widgets.TbListView',
					array('dataProvider'=>new CArrayDataProvider($data->choices),
							'itemView'=>'_choice_item',
							'template'=>"{items}",
							'summaryText'=>false));
?>

<?php
$list = array();
foreach($data->choices as $i=>$item):
	$list[$item->id] = DxdUtil::num2Alpha($i+1);
endforeach;
?>
<br/>
<?php
if($data->type=="multiple-choice"):
	echo $form->checkBoxListGroup($response, "[$index]choices", $list);
else:
	echo $form->radioButtonListGroup($response, "[$index]content", $list);
endif;
?>
<?php echo $form->hiddenField($response, "[$index]questionId"); ?>
</div>

<?php if($marked && $showAnalyse):?>
<div>
<span>
<?php echo Yii::t('app','正确答案：');?>
<?php foreach($data->correctChoices as $item):?>
	<?php echo DxdUtil::num2Alpha($item->weight)."&nbsp;";?>
<?php endforeach;?>
</span>
&nbsp;&nbsp;&nbsp;&nbsp;
<?php echo Yii::t('app','您的回答');?>
<?php foreach($response->choices as $item):?>
	<?php $answer = Answer::model()->findByPk($item);?>
	<?php echo DxdUtil::num2Alpha($answer->weight)."&nbsp;";?>
<?php endforeach;?>
<span>

</span>
</div>
<?php endif;?>
