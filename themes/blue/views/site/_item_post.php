<div class="item-post">
    <div class="pic pull-left">
        <?php $face = CHtml::image($data->group->xFace); ?>
        <?php echo CHtml::link($face, array('//group/index/view', 'id'=>$data->group->id)); ?>
    </div>
    <div class="text">
        <?php echo CHtml::link(mb_substr($data->title, 0, 60, 'utf-8'), array('//group/post/view', 'id'=>$data->id), array('class'=>'title main-color')); ?>
        <div class="content"><?php echo mb_substr(strip_tags($data->content), 0, 100, 'utf-8'); ?></div>
        <div class="info hidden-phone">
            <?php echo CHtml::link($data->user->name, array('//u/index', 'id'=>$data->user->id)); ?>
            &nbsp;发表于&nbsp;
            <?php echo CHtml::link($data->group->name, array('//group/index/view', 'id'=>$data->group->id)); ?>
        </div>
    </div>
    <div class="clearfix"></div>
</div>
