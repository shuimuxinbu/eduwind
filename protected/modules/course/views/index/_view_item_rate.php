<div class="item-rate">
    <div>
        <?php echo CHtml::link($data->user->name, array('//u', 'id'=>$data->user->id), array('class'=>'user')); ?>
        <div class="pull-right">
            <div class="star dxd-star-rating-<?php echo intval(round($data->score)); ?>"></div>
        </div>
    </div>

    <div>
        <span class="content"><?php echo $data->content; ?></span>
        <div class="pull-right">
            <span class="date"><?php echo date('Y-m-d H:i', $data->addTime); ?></span>
        </div>
    </div>
</div>
