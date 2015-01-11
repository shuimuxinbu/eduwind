<!-- 课程主页头部区域 -->
<div class="panel-course-header nopay">
    <div class="pic hidden-xs">
        <?php
        $face = CHtml::image($model->xFace, $model->name);
        echo $face;
        ?>
    </div>
    <div class="text">
        <div class="course-manage">
        <span class="fee">￥<?php echo $model->fee; ?></span>
            <?php echo CHtml::link(Yii::t('app', '选修课程'), array('buy', 'id'=>$model->id), array('class'=>'elective-course-btn')); ?>
        </div>
        <div class="name"><?php echo $model->name; ?></div>
        <div class="info hidden-xs">
            <span><?php echo Yii::t('app', '学习人数'); ?> &nbsp; <?php echo $model->studentNum; ?><?php echo Yii::t('app', '人'); ?></span>
            <span><?php echo Yii::t('app', '课时数量'); ?> &nbsp; <?php echo $model->LessonNum; ?><?php echo Yii::t('app', '课时'); ?></span>
            <span>
                <?php echo Yii::t('app', '课程时长'); ?> &nbsp;
                <?php $courseDuration = $model->countDuration; ?>
                <?php echo floor($courseDuration / (60 * 60)); ?><?php echo Yii::t('app', '小时'); ?>
                <?php echo round(($courseDuration % (60 * 60) / 60)); ?><?php echo Yii::t('app', '分钟'); ?>
            </span>
        </div>
    </div>
    <div class="clearfix"></div>
</div>
