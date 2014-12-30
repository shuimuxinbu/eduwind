<?php
/* @var $this CourseManageController */
/* @var $dataProvider CActiveDataProvider */
 $this->widget('booster.widgets.TbBreadcrumbs', array(
 	'homeLink'=>false,
    'links' =>  array(
        $course->name=>array('/course/index/view', 'id'=>$course->id),
        Yii::t('app','公告管理')
    ),
));
?>

<div class="row ">
    <!-- 左侧导航栏 -->
	<div class="col-sm-2 dxd-course-category">
        <?php $this->renderPartial('/index/_side_nav',array('course'=>$course));?>
	</div>

    <!-- Main 内容区域 -->
	<div class="col-sm-10">
        <h3 class="side-lined"><?php echo Yii::t('app','公告管理');?></h3>
        <?php echo CHtml::link('<i class="icon-plus icon-white"></i>'.Yii::t('app','添加公告'), array('create', 'courseId'=>$course->id), array('class'=>'btn btn-success mr10', 'onclick'=>'openFancyBox(this);return false;')); ?>
        <div class="dxd-lession-order-list">
            <!-- 公告列表 -->
            <ul id="orderList" class="ui-sortable">
                <?php
                $this->widget('booster.widgets.TbListView', array(
                    'dataProvider'  =>  $dataProvider,
                    'itemView'      =>  '_item',
                    'template'      =>  '{items}{pager}',
                ));
                ?>
            </ul>
        </div>
    </div>
</div>

<style type="text/css">
.dxd-lession-order-list{
margin-top:20px;
}
.dxd-lession-order-list li{
	 background: none repeat scroll 0 0 #FFFFFF;
    border: 1px solid #CCCCCC;
    line-height: 40px;
    padding:0 15px;
    margin-bottom: 15px;
}
.dxd-lession-order-list li:hover{
    background: none repeat scroll 0 0 #F3F3F3;
}
</style>
