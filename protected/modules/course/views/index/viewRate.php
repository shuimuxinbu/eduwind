<?php
/* @var $this CourseController */
/* @var $model Course */
$lesson = new Lesson;
$this->pageTitle = "$model->name";
?>

<div id="edu-course" class="course-home">
    <!-- 课程主页头部区域 -->
    <?php
    $this->renderPartial(
        $this->viewHeaderName,
        array(
            'model' =>  $model,
			'courseMember' => $courseMember
        )
    );
    ?>


    <!-- 主要内容区域 -->
    <div class="row mainbody-course">
        <div class="col-sm-9">
            <!-- 课程内容 - 评价 -->
            <div class="section-course-data section-course-rate">
                <div class="caption">
                    <?php $this->renderPartial(
                        $this->viewMenuName,
                        array(
                            'model' =>  $model,
                        )
                    ); ?>
                </div>
                <!-- 发布评价 -->
                <?php if (Yii::app()->user->isGuest) : ?>
                    <div class="panel-login text-center">
                        <span><?php echo Yii::t('app', '请先'); ?> <?php echo CHtml::link(Yii::t('app', '登录'), array('//u/login')); ?> <?php echo Yii::t('app', '后再发表评价'); ?></span>
                    </div>
                <?php else : ?>
                    <?php $this->renderPartial(
                        '_view_form_rate',
                        array(
                            'model' =>  new Rate,
                            'courseId'  =>  $model->id,
                        )
                    ); ?>
                <?php endif; ?>
                <!-- 评价列表 -->
                <?php $this->renderPartial('_viewRate_panel_rate', array('rateDataProvider'=>$rateDataProvider)); ?>
            </div>

        </div>


        <!-- 侧边栏 -->
        <div class="col-sm-3">
            <!-- 授课教师 -->
            <div class="section-course-teacher">
                <span class="caption"><?php echo Yii::t('app', '授课教师'); ?></span>
                <?php $this->widget(
                    'booster.widgets.TbListView',
                    array(
                        'dataProvider'  =>  $teacherDataProvider,
                        'template'      =>  '{items}',
                        'itemView'      =>  '_view_item_teacher',
                    )
                ); ?>
            </div>

            <!-- 回复光荣榜 -->
            <div class="section-course-replayBoard">
                <span class="caption"><?php echo Yii::t('app', '回复光荣榜'); ?></span>
                <?php $this->widget(
                    'booster.widgets.TbListView',
                    array(
                        'dataProvider'  =>  $memberDataProvider,
                        'template'      =>  '{items} {pager}',
                        'itemView'      =>  '_view_item_replayWiner',
                        'separator'     =>  '<div class="separator"></div>',
                    )
                ); ?>
            </div>
        </div>
    </div>
</div>
