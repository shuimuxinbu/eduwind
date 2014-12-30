<div class="item">
    <!-- 小组头像 -->
    <?php
    $face = CHtml::image($data->group->xFace, '', array('class'=>'pull-left'));
    echo CHtml::link($face, array('//group/index/view', 'id'=>$data->group->id));
    ?>

    <!-- 帖子数据 -->
    <div class="data">
        <?php echo CHtml::link(mb_substr($data->title, 0, 24, 'utf-8'), array('//group/post/view', 'id'=>$data->id), array('class'=>'title main-color')); ?>
        <div class="content">
            <?php echo mb_substr(strip_tags($data->content), 0, 36, 'utf-8'); ?>
        </div>
        <div class="info">
            <?php echo CHtml::link($data->user->name, array('//u/index', 'id'=>$data->user->id), array('class'=>'dxd-username', 'data-userId'=>$data->user->id)); ?>
            &nbsp;<?php echo Yii::t('app','发表于');?>&nbsp;

            <?php echo CHtml::link($data->group->name, array('//group/index/view', 'id'=>$data->group->id)); ?>
           &nbsp;&nbsp;
           <?php echo DxdUtil::duration2Day(time() - $data->addTime);?>
            <?php if(isset($data->lastComment->user)):?>
            &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<?php echo Yii::t('app','最后回复:');?>
            <?php echo CHtml::link($data->lastComment->user->name,$data->lastComment->user->pageUrl); ?>
            <?php echo Yii::t('app','于')?><?php echo DxdUtil::duration2Day(time() - $data->upTime); ?>
            <?php endif;?>
            <div class="pull-right">
                <i class="icon-eye-open"></i> <?php echo $data->viewNum; ?>
                &nbsp;&nbsp;&nbsp;&nbsp;
                <i class="icon-comment"></i> <?php echo $data->commentNum; ?>
                &nbsp;&nbsp;&nbsp;&nbsp;
            </div>
        </div>
    </div>
</div>
