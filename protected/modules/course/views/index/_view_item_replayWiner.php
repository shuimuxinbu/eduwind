<div class="item-replayWiner">
    <div class="pic">
        <?php
        $face = Chtml::image($data->user->xFace, $data->user->name);
        echo Chtml::link($face, array('//u/view', 'id'=>$data->userId));
        ?>
    </div>
    <?php echo CHtml::link($data->user->name, array('//u/view', 'id'=>$data->userId), array('class'=>'user')); ?>
    <span class="replayNum"><?php echo $data->commentNum; ?><?php echo Yii::t('app', '回复'); ?></span>

</div>
