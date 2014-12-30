<?php
/* @var $this CourseManageController */
/* @var $dataProvider CActiveDataProvider */
 $this->widget('booster.widgets.TbBreadcrumbs', array(
 	'homeLink'=>false,
    'links'=>array($course->name=>array('/course/index/view','id'=>$course->id), Yii::t('app',"课程管理")),
));
?>

<div class="row ">

	<div class="col-sm-2 dxd-course-category">
	<?php $this->renderPartial('/index/_side_nav',array('course'=>$course));?>
	</div>
	<div class="col-sm-10">
		<h3 class="side-lined"><?php echo Yii::t('app','课时管理');?></h3>
		<div style="position:static;top:auto">
		<?php
			echo CHtml::link('<i class="icon-plus icon-white"></i>'.Yii::t('app','添加章节'),array('chapter/create','courseId'=>$course->id),array('class'=>'btn btn-success   mr10','onclick'=>'openFancyBox(this);return false;'));
			echo CHtml::link('<i class="icon-plus icon-white"></i>'.Yii::t('app','添加课时'),array('create','courseId'=>$course->id),array('class'=>'btn btn-success   mr10','onclick'=>'openFancyBox(this);return false;'));
			echo CHtml::link('<i class="icon-plus icon-white"></i>'.Yii::t('app','批量导入视频链接'),array('createMany','courseId'=>$course->id),array('class'=>'btn btn-success dxd-fancy-elem mr10'));
		?>


    <?php $this->widget('booster.widgets.TbButtonGroup', array(
    //    'type'=>'primary', // '', 'primary', 'info', 'success', 'warning', 'danger' or 'inverse'
        'buttons'=>array(
            array('label'=>Yii::t('app','批量操作'), 'url'=>'#'),
            array('items'=>array(
                array('label'=>Yii::t('app','发布全部课时'), 'url'=>array('publishAll','courseId'=>$course->id)),
                array('label'=>Yii::t('app','隐藏全部课时'), 'url'=>array('hideAll','courseId'=>$course->id)),
            )),
        ),
    )); ?>
    <?php
		echo CHtml::link('? 如何添加视频','http://eduwind.com',array('class'=>'pull-right mt10'));
	?>
			<div class="clearfix"></div>
    </div>
<div class="dxd-lession-order-list">
<?php
//$lessons = $lessonDataProvider->getData();
$sortItems = array();
foreach($items as $item){
	if(get_class($item)=="Lesson"){
		$sortItems["lesson-$item->id"] =$this->renderPartial('_index_lesson_item',array('data'=>$item,'course'=>$course),true);
	}else{
		$sortItems["chapter-$item->id"] =$this->renderPartial('_index_chapter_item',array('data'=>$item,'course'=>$course),true);
	}
}
$this->widget('zii.widgets.jui.CJuiSortable',
				array('id'=>'orderList',
						'items'=>$sortItems,
						'options'=>array('delay'=>100,
								 'disableSelection'=>true,
                        		 'cursor'=>'move',
								//'placeholder'=>'sortable-placeholder',
								'stop'=>"js:function(){
                        $.post('".$this->createUrl('order',array('courseId'=>$course->id))."'
                                ,{'order':$('.ui-sortable').sortable('toArray').toString()}
                        );}"
				)));
?>
<script type="text/javascript">
$(document).ready(function(){
	$(".dxd-sortable-chapter-inner").parent('li').addClass('dxd-sortable-chapter');
	$(".dxd-sortable-lesson-inner").parent('li').addClass('dxd-sortable-lesson');
});
</script>

	</div>
</div>
</div>
<style type="text/css">
.dxd-sortable-lesson{
	margin-left:30px;
}
.dxd-lession-order-list li.dxd-sortable-chapter{
background-color:#f3f3f3;
}
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
.dxd-lession-order-list li.dxd-sortable-chapter:hover{
    background: none repeat scroll 0 0 #fff;
}

</style>
