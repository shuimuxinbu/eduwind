<div class="announcement-item">
    <?php echo mb_substr($data->content, 0, 50, 'utf-8') . ' ...'; ?>
    <p>
        <?php isset($data->upTime) ? $time=$data->upTime : $time=$data->addTime; ?>
        <span class="pull-left"><?php echo date('Y-m-d', $time); ?></span>
        <span class="pull-right"> <?php echo CHtml::link(Yii::t('app','详细').' &gt; ', array('announcement/detail', 'id'=>$data->id), array('onclick'=>'openFancyBox(this);return false;')); ?> </span>
        <span class="clearfix"></span>
    </p>
</div>
