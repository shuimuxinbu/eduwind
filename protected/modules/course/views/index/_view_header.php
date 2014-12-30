<?php
$countDuration = $model->countDuration;
$learnDuration = $model->learnDuration;
?>
<div class="panel-course-header">
    <div class="pic hidden-xs">
        <?php
        $face = CHtml::image($model->xFace, $model->name);
        echo $face;
        ?>
    </div>
    <div class="text">
        <div class="name">
            <?php echo $model->name; ?>
            <div class="study-line pull-right hidden-xs">
                <span><?php echo Yii::t('app', '课程进度'); ?></span>
                <div class="progress">
                <?php if ($model->learnLessonNum) : ?>
                    <div class="bar" style="width:<?php echo ceil($model->learnLessonNum / $model->lessonNum * 100); ?>%"></div>
                <?php else : ?>
                    <div class="bar" style="width:0%"></div>
                <?php endif; ?>
                </div>
            </div>
        </div>
        <div class="info-course">
            <div>
                <?php echo CHtml::link(
                    '<span><i class="icon-plus-sign"></i> '. Yii::t('app', '收藏此课程') . '</span>',
                    array(),
                    array('class'=>'dropdown-toggle', 'data-toggle'=>'dropdown')
                );  ?>
                <ul class="dropdown-menu">
                    <?php if ($model->isCollector(Yii::app()->user->id)) : ?>
                        <li><?php echo CHtml::link(Yii::t('app', '取消个人收藏'), array('index/toggleCollect', 'id'=>$model->id)); ?></li>
                    <?php else : ?>
                        <li><?php echo CHtml::link(Yii::t('app', '个人收藏'), array('index/toggleCollect', 'id'=>$model->id)); ?></li>
                    <?php endif; ?>
                    <li><?php echo CHtml::link(Yii::t('app', '小组收藏'), array('//group/course/myGroup', 'courseId'=>$model->id), array('class'=>'dxd-fancy-elem')); ?></li>
                </ul>
                <?php
                if (
                    Yii::app()->user->checkAccess('courseOwner', array('course'=>$model))
                    ||
                    ($courseMember && $courseMember->inRoles(array('superAdmin','admin','member','teacher','student')))
                ) {
                    echo TbHtml::link(Yii::t('app', '课程管理'), array('manage/index/setBasic', 'id'=>$model->id), array('class'=>'btn-course-manage'));
                }
                ?>
                <span class="student-number"><?php echo Yii::t('app', '学习人数'); ?> &nbsp;&nbsp;<?php echo $model->memberNum; ?><?php echo Yii::t('app', '人'); ?></span>
            </div>
            <div>
                <?php echo Yii::t('app', '课程时长'); ?> &nbsp;&nbsp;
                <span><?php echo ceil($countDuration / 60 / 60); ?><?php echo Yii::t('app', '小时'); ?></span>
                <span><?php echo round(($countDuration % (60 * 60)) / 60); ?><?php echo Yii::t('app', '分钟'); ?></span>
            </div>
            <div>
                <?php echo Yii::t('app', '已学时长'); ?> &nbsp;&nbsp;
                <span><?php echo ceil($learnDuration / 60 /60); ?><?php echo Yii::t('app', '小时'); ?></span>
                <span><?php echo round(($learnDuration % (60 * 60)) / 60); ?><?php echo Yii::t('app', '分钟'); ?></span>
            </div>
        </div>
    </div>
    <div class="clearfix"></div>
</div>
