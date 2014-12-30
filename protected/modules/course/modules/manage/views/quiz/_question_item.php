<div class="view">
<div class="muted lead"><?php echo Yii::t('app','问题');?> <?php echo $data->weight;?></div>
<?php echo $data->stem;?>
<?php $this->widget('booster.widgets.TbListView',array(
	'dataProvider'=>new CArrayDataProvider($data->choices),
	'itemView'=>'_choice_item',
	'summaryText'=>false,
)); ?>
<div><?php echo Yii::t('app','正确答案：');?>
<?php foreach($data->correctChoices as $item):?>
	<?php echo DxdUtil::num2Alpha($item->weight)."&nbsp;";?>
<?php endforeach;?>
</div>
<?php echo CHtml::link(Yii::t('app',"编辑"),array('question/update','id'=>$data->id),array('class'=>'pull-right'));?>
<div class="clearfix"></div>
</div>
