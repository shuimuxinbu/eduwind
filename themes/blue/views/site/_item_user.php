<li>
    <div class="item-user">
        <div class="pic pull-left">
            <?php $face = CHtml::image($data->xFace); ?>
            <?php echo CHtml::link($face, array('//u/index', 'id'=>$data->id)); ?>
        </div>
        <div class="info">
            <?php echo CHtml::link($data->name, array('//u/index', 'id'=>$data->id), array('class'=>'name main-color')); ?>
            <div class="bio">
                <?php echo $data->bio; ?>
            </div>
        </div>
        <div class="clearfix"></div>
    </div>
</li>
