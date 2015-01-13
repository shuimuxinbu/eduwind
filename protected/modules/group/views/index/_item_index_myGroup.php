<div class="item col-sm-4">
    <div class="pic">
        <?php
        $face = CHtml::image($data->xFace, $data->name);
        echo CHtml::link($face, array('//group/index/view', 'id'=>$data->id), array('class'=>'pic'));
        ?>
    </div>
    <div class="info">
        <?php echo CHtml::link(mb_substr($data->name, 0, 4, 'utf-8'), array('//group/index/view', 'id'=>$data->id), array('class'=>'name')); ?>
    </div>
    <div class="clearfix"></div>
</div>
