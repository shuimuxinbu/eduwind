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
            <!-- 课程内容 - 讨论 -->
            <div class="section-course-data section-course-post">
                <div class="caption">
                    <?php $this->renderPartial(
                        $this->viewMenuName,
                        array(
                            'model' =>  $model,
                        )
                    ); ?>
                </div>
                <!-- 发布讨论 -->
                <?php $this->renderPartial(
                    '_index_form_post',
                    array(
                        'model' =>  new CoursePost,
                        'courseId'  =>  $model->id,
                    )
                ); ?>
                <!-- 讨论列表 -->
                <?php $this->renderPartial('_index_panel_post', array('dataProvider'=>$postDataProvider)); ?>
            </div>

        </div>


        <!-- 侧边栏 -->
        <div class="col-sm-3">
            <!-- 授课教师 -->
            <div class="section-course-teacher">
                <span class="caption">授课教师</span>
                <?php $this->widget(
                    'booster.widgets.TbListView',
                    array(
                        'dataProvider'  =>  $teacherDataProvider,
                        'template'      =>  '{items}',
                        'itemView'      =>  '/index/_view_item_teacher',
                    )
                ); ?>
            </div>

            <!-- 回复光荣榜 -->
            <div class="section-course-replayBoard">
                <span class="caption">回复光荣榜</span>
                <?php $this->widget(
                    'booster.widgets.TbListView',
                    array(
                        'dataProvider'  =>  $memberDataProvider,
                        'template'      =>  '{items} {pager}',
                        'itemView'      =>  '/index/_view_item_replayWiner',
                        'separator'     =>  '<div class="separator"></div>',
                    )
                ); ?>
            </div>
        </div>
    </div>
</div>
