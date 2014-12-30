<div class="item-teacher">
    <div class="profile">
        <?php
        $face = CHtml::image($data->user->xFace);
        echo Chtml::link($face, array('//u/', 'id'=>$data->user->id), array('class'=>'pic'));
        echo CHtml::link($data->user->name, array('//u/', 'id'=>$data->user->id), array('class'=>'name'));
        ?>
    </div>
    <div class="introduction">
        <?php echo $data->user->bio; ?>
    </div>
</div>
