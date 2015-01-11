<div class="item-lesson">
    <i class="icon-facetime-video"></i> &nbsp;
    <span class="order"><?php echo Yii::t('app', '第'); ?><?php echo $index + 1; ?><?php echo Yii::t('app', '课时'); ?></span>
    <?php echo CHtml::link($data->title, array('lesson/view', 'id'=>$data->id)); ?>
    <span class="pull-right duration hidden-xs">
        <?php if ($data->duration) {
            echo floor($data->duration / (60 * 60)); ?><?php echo Yii::t('app', '小时');
            echo round(($data->duration % (60 * 60)) / 60);
            echo Yii::t('app', '分钟');
        } else {
            echo $data->viewNum;
            echo ' 次学习';
        }?>
    </span>
    <div class="clearfix"></div>
</div>
