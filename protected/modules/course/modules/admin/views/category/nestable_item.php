<?php
?>
<div class="dxd-hover-show-container">
<?php echo $data->name;
?>
<div class="pull-right dxd-hover-show">
<?php echo CHtml::link(Yii::t('app', '编辑'),array('update','id'=>$data->id),array('class'=>'ml10'));
echo CHtml::link(Yii::t('app', '删除'),array('delete','id'=>$data->id),array('class'=>'ml10'));
?>
</div>
<div class="clearfix"></div>
</div>
