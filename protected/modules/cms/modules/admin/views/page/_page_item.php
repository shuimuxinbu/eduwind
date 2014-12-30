<div style="padding:5px;" class="dxd-hover-show-container">
    <?php echo $data->title; ?>

    <?php //echo Yii::app()->createUrl('/cms/page/view',array('id'=>$data->id)); ?>
    <div class="pull-right dxd-hover-show">
    	<?php echo CHtml::link('查看', array('/cms/page/view', 'id'=>$data->id),array('target'=>'_blank')); ?>&nbsp;&nbsp;
        <?php echo CHtml::link('编辑', array('update', 'id'=>$data->id)); ?>&nbsp;&nbsp;
        <?php echo CHtml::link('删除', array('delete', 'id'=>$data->id)); ?>&nbsp;&nbsp;
    </div>
    <div class="clearfix"></div>
</div>
