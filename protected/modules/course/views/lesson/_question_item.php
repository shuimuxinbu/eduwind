<div>
<?php echo $data->stem;?>
<?php $this->widget('booster.widgets.TbListView',array(
	'dataProvider'=>new CArrayDataProvider($data->choices),
	'itemView'=>'_choice_item',
	'summaryText'=>false,
)); ?>
<?php // echo CHtml::link("编辑",array('question/update','id'=>$data->id),array('class'=>'pull-right'));?>
<div class="clearfix"></div>
</div>
