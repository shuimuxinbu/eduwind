<div class="item-group">
    <div class="pic pull-left">
        <?php $face = CHtml::image($data->xFace); ?>
        <?php echo CHtml::link($face, array('//group/index/view', 'id'=>$data->id)); ?>
    </div>
    <div class="info">
        <?php echo CHtml::link($data->name, array('//group/index/view', 'id'=>$data->id), array('class'=>'name main-color')); ?>
        <div class="descript">
            <?php echo strip_tags($data->introduction); ?>
        </div>
    </div>
    <div class="clearfix"></div>
</div>
