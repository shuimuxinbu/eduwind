<div class="col-xs-4 item-student">
    <div class="pic text-center">
        <?php
        $face = CHtml::image($data->user->xFace, $data->user->name, array('style'=>'width:100%'));
        echo CHtml::link($face, array('//u', 'id'=>$data->userId));
        ?>
    </div>
    <span class="name"><?php echo $data->user->name; ?></span>
</div>
