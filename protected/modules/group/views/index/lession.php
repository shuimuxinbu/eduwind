<?php
/* @var $this LessonController */
/* @var $model Lesson */

 $this->widget('booster.widgets.TbBreadcrumbs', array(
    'links'=>array($course->name=>array('course/view','id'=>$course->courseId), $lesson->title),
)); 
foreach ($course->lessons as $key=>$item){
	$menuItems[] = array('label'=>$item->title,
						 'url'=>array('lesson/view','id'=>$item->lessonid),
						);
}
?>
<div class="row">
	<div class="col-sm-7">
		<div class="dxd-lesson-content" style="margin-left:15px;">
			<?php $this->renderPartial('/lesson/view',array('lesson'=>$lesson))?>
		</div>
	</div>
	<div class="col-sm-5">
		<div class="dxd-lesson-playlist">
			<?php $this->widget('booster.widgets.TbMenu', array(
    'type'=>'tabs', // '', 'tabs', 'pills' (or 'list')
    'stacked'=>true, // whether this is a stacked menu
    'items'=>$menuItems
)); ?>
		</div>
	</div>
</div>

<<script type="text/javascript">
	$('.dxd-lesson-playlist a').click(function(evt){
		//切换内容区
		$('.dxd-lesson-content').load( $(this).attr('href'));
		//加active类
		$('.dxd-lesson-playlist li').removeClass('active');
		$(this).parents('li').addClass('active');
		//更换面包屑
		$('.breadcrumb li.active').text($(this).text());
		evt.preventDefault();
	});
</script>
