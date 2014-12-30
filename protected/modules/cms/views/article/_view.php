<?php
/* @var $this ArticleController */
/* @var $data Article */
?>

<div class="new-item">
    <div class="data">
        <div class="pull-left hidden-phone">
            <img src="<?php echo Yii::app()->baseUrl."/".$data->face ?>">
        </div>

        <div class="margin-left:200px">
            <div class="title"><?php echo CHtml::link($data->title, array('article/view', 'id'=>$data->id), array('class'=>'main-color')); ?></div>
            <div class="content"><?php echo mb_substr(strip_tags($data->content), 0, 140, 'utf-8'); ?> ...</div>
            <div class="info">
                <span><?php echo date('Y-m-d', $data->upTime); ?></span>
                <span><i class="icon-eye-open"></i>&nbsp;&nbsp;<?php echo $data->viewNum; ?></span>
                <span><?php echo CHtml::link(Yii::t('app','查看'), array('view', 'id'=>$data->id)); ?></span>
            </div>
        </div>
        <div class="clearfix"></div>
    </div>
</div>
