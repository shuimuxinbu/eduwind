<div class="item" onClick="location.assign('<?php echo CHtml::normalizeUrl(array('post/view', 'id'=>$data->id)); ?>')">
    <div class="title">
        <?php
        echo CHtml::link($data->title, array('post/view', 'id'=>$data->id), array('class'=>'link'));
        if($data->isTop) echo '<span class="label">'.Yii::t('app','置顶').'</span>';
        if($data->isDigest) echo '<span class="label">'.Yii::t('app','精华').'</span>';
        ?>
    </div>

    <div class="info hidden-phone">
        <span class="name">
            <?php
            echo Yii::t('app','作者: ');
            echo CHtml::link($data->user->name,$data->user->pageUrl, array('class'=>'dxd-username main-color', 'data-userId'=>$data->user->id));
            ?>
        </span>
        <span class="date"> <?php echo Yii::t('app','最后回复:');?> <?php echo DxdUtil::duration2Day(time() - $data->upTime) ?> </span>
        <span class="reply"> <?php echo $data->commentNum ?> <?php echo Yii::t('app','回应');?></span>
    </div>
    <div class="info visible-phone">
        <span class="name0">
            <?php
            echo Yii::t('app','作者: ');
            echo CHtml::link($data->user->name,$data->user->pageUrl, array('class'=>'dxd-username main-color', 'data-userId'=>$data->user->id));
            ?>
        </span>
        <span class="date0"> <?php echo DxdUtil::duration2Day(time() - $data->upTime) ?> </span>
        <span class="reply0"> <?php echo $data->commentNum ?> <?php echo Yii::t('app','回应')?></span>
    </div>
    <div class="clearfix"></div>
</div>
