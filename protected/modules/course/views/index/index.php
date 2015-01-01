<div id="edu-course" class="page-index">
<?php
$this->pageTitle = Yii::app()->name."-".Yii::t('app',"课程");
?>
<!-- 创建课程 -->
<div class="row visible-xs">
<?php if (Yii::app()->user->checkAccess('teacher')) {
    echo CHtml::link(Yii::t('app','+ 申请创建课程'), array('create'), array('class'=>'btn btn-primary clo-xs-12'));
} ?>
</div>
<div class="row" style="margin-top:30px; position:relative">
    <!-- 创建课程 -->
    <div class="add-course hidden-phone pull-right hidden-xs">
        <?php if (Yii::app()->user->checkAccess('teacher')) {
            echo CHtml::link(Yii::t('app','+ 申请创建课程'), array('create'), array('class'=>'btn-primary btn', ''));
        } ?>
    </div>
<div class="col-sm-12">
<div class="pull-left mr15 main-color" style="font-size:1.2em;line-height:32px;"><?php echo Yii::t('app','大类')?></div>
    <div class="course-category-tabs">

<?php
    $firstCategoryItems = array();
$firstCategoryItems[] = array('label'=>Yii::t('app','全部'),'url'=>array('index','categoryId'=>0,'order'=>$order),'active'=>($firstCategoryId==0));
foreach($firstCategories as $item){
    $firstCategoryItems[] = array('label'=>$item->name,'url'=>array('index','categoryId'=>$item->id,'order'=>$order),'active'=>($firstCategoryId==$item->id));
}
$this->widget('booster.widgets.TbMenu', array(
    'type'=>'pills', // '', 'tabs', 'pills' (or 'list')
    'stacked'=>false, // whether this is a stacked menu
    'items'=>$firstCategoryItems,
)); ?>
</div>
</div>
<div class="col-sm-12">
<div class="pull-left mr15 main-color"  style="font-size:1.2em;line-height:32px;"><?php echo Yii::t('app','小类');?></div>
    <div class="course-category-tabs">
<?php
$secondCategoryItems = array();
$secondCategoryItems[] = array('label'=>Yii::t('app','全部'),'url'=>array('index','categoryId'=>$firstCategoryId,'order'=>$order),'active'=>($secondCategoryId==0));
if(!$secondCategories) $secondCategories=array();
foreach($secondCategories as $item){
    $secondCategoryItems[] = array('label'=>$item->name,'url'=>array('index','categoryId'=>$item->id,'order'=>$order),'active'=>($item->id==$secondCategoryId));
}
$this->widget('booster.widgets.TbMenu', array(
    'type'=>'pills', // '', 'tabs', 'pills' (or 'list')
    'stacked'=>false, // whether this is a stacked menu
    'items'=>$secondCategoryItems
)); ?>
    </div>
</div>
</div>
<div class="row">
<div class="col-sm-12">
    <div class="course-category-tabs course-category-order">
<?php
$this->widget('booster.widgets.TbMenu', array(
    'type'=>'pills', // '', 'tabs', 'pills' (or 'list')
    'stacked'=>false, // whether this is a stacked menu
    'items'=>array(
        array('label'=>Yii::t('app','人气').'&nbsp;<i class=" icon-arrow-down"></i>','url'=>array('index','categoryId'=>$category->id,'order'=>"student"),'active'=>($order=='student')),
        array('label'=>Yii::t('app','价格').'&nbsp;<i class=" icon-arrow-up"></i>','url'=>array('index','categoryId'=>$category->id,'order'=>"fee"),'active'=>($order=='fee')),
        array('label'=>Yii::t('app','最新').'&nbsp;<i class=" icon-arrow-down"></i>','url'=>array('index','categoryId'=>$category->id,'order'=>"time"),'active'=>($order=='time')),
    ),
    'encodeLabel'=>false,
));
?>
</div>
</div>
</div>
<div class="row">
<div class="col-sm-12 section-course-list">
<?php

$this->widget('booster.widgets.TbThumbnails', array(
    //  'dataProvider'=>new CActiveDataProvider('Course',array('criteria'=>array('order'=>'memberNum desc'),'pagination'=>array('pageSize'=>4))),
    'dataProvider'=>$dataProvider,
    'template'=>"{items}",
    'itemView'=>'_course_item',
    'emptyText'=>Yii::t('app','暂时还没有该类课程')
));
?>
</div>
</div>
</div>
