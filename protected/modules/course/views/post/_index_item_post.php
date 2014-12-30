<div class="item-post">
    <div>
        <?php echo CHtml::link($data->user->name, array('//u', 'id'=>$data->user->id), array('class'=>'user')); ?>
        <div class="pull-right">
            <i class="icon-comment"></i>
            <?php echo CHtml::link("回复({$data->commentCount})", array('post/view', 'id'=>$data->id)); ?>
        </div>
    </div>

    <div>
        <span class="content"><?php echo $data->content; ?></span>
        <div class="pull-right">
            <?php if (isset($data->lesson->title)) : ?>
                <span>源自 <?php echo CHtml::link($data->lesson->title, array('lesson/view', 'id'=>$data->lessonId)); ?></span>
            <?php endif; ?>
            <span class="date"><?php echo date('Y-m-d H:i', $data->addTime); ?></span>
        </div>
    </div>
</div>
