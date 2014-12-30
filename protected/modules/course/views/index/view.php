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
            'courseMember'=>$courseMember,
        )
    );
    ?>


    <!-- 主要内容区域 -->
    <div class="row mainbody-course">
        <div class="col-sm-9">
            <!-- 课程介绍 -->
            <div class="section-course-introduction">
                <span class="caption"><?php echo Yii::t('app', '课程介绍'); ?></span>
                <?php echo strip_tags($model->introduction); ?>
            </div>

            <!-- 课时列表 -->
            <div class="section-course-data">
                <div class="caption">
                    <?php $this->renderPartial(
                        $this->viewMenuName,
                        array(
                            'model' =>  $model,
                        )
                    ); ?>
                </div>
                <?php $this->widget(
                    'booster.widgets.TbListView',
                    array(
                        'dataProvider'  =>  $lessonDataProvider,
                        'template'      =>  '{items} {pager}',
                        'itemView'      =>  '_view_item_lesson',
                    )
                ); ?>
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

            <!-- 同学列表 -->
            <div class="section-course-student">
                <span class="caption"><?php echo $studentDataProvider->totalItemCount; ?><?php echo Yii::t('app', '位共同奋斗的同学'); ?></span>
                <?php $this->widget(
                    'booster.widgets.TbThumbnails',
                    array(
                        'dataProvider'  =>  $studentDataProvider,
                        'template'      =>  '{items} {pager}',
                        'itemView'      =>  '_view_item_student',
                    )
                ); ?>
            </div>
        </div>
    </div>
</div>
