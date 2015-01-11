<div class="item-article">
    <div class="pic pull-left">
        <?php $face = CHtml::image($data->xFace); ?>
        <?php echo CHtml::link($face, array('//cms/article/view', 'id'=>$data->id)); ?>
    </div>
    <div class="text">
        <span class="title"><?php echo CHtml::link($data->title, array('//cms/article/view', 'id'=>$data->id), array('class'=>'main-color')); ?></span>
        <div class="content"><?php echo mb_substr(strip_tags($data->content), 0, 190, 'utf-8'); ?></div>
        <div class="info hidden-xs">
            <span><?php echo date('Y-m-d', $data->addTime); ?></span>
            <span><i class="icon-eye-open"></i> <?php echo $data->viewNum; ?></span>
        </div>
    </div>
    <div class="clearfix"></div>
</div>
