<?php
/* @var $this CourseController */
/* @var $course Course */
$lesson = new Lesson;
?>

	<?php echo $this->renderPartial('_nopaying_user_header', array('course'=>$course)); ?>
	
<div class="row dxd-course-body">
	<div class="col-sm-8 dxd-left-col">

		<div class="dxd-dashboard-panel">
			<div class="dxd-panel-content">
				<!--  
				<div class="text-warning" style="font-size:1.1em">授课教师：
				<?php foreach($teacherDataProvider->getData() as $teacher):
					echo $teacher->user->name ."   ";
				endforeach;
				?>
				
				</div>
				-->
				<?php if($course->targetStudent):?>
				<div class="text-warning" style="font-size:1.1em"><?php echo Yii::t('app','适用人群：');?>
				<?php 
					echo $course->targetStudent;
				?>
				</div>
				<?php endif;?>
				<div class="dxd-course-introduction"><?php echo $course->introduction ? $course->introduction : Yii::t('app',"还没有介绍")."<br/><br/>" ;?></div>

			</div>

		</div>

		<?php  $this->renderPartial('_lessons_and_chapters',array('lessonsAndChapters'=>$lessonsAndChapters,'member'=>new CourseMember()));?>	

		<?php //$this->renderPartial('_lessons',array('lessonDataProvider'=>$lessonDataProvider,'member'=>null));?>

	</div>

	<div class="col-sm-4 dex-right-col pull-right">

	<?php //$this->renderPartial('_group',array('course'=>$course,'groupDataProvider'=>$groupDataProvider) );?>
	<?php  $this->renderPartial('_teachers',array('course'=>$course,'teacherDataProvider'=>$teacherDataProvider) );?>

	<?php  $this->renderPartial('_rates',array('course'=>$course,'rateDataProvider'=>$rateDataProvider) );?>

	<?php 
		//$this->renderPartial('/member/_items',array('title'=>'学员','memberDataProvider'=>$memberDataProvider) );
		$this->renderPartial('_students',array('studentDataProvider'=>$studentDataProvider) );
	
	?>
	
	</div>

</div>

<script type="text/javascript">
$(document).ready(function(){
//	$('a.dxd-create-lesson').fancybox();
	var l = window.location;
	var base_url = l.protocol + "//" + l.host + "/" + l.pathname.split('/')[1];
	var introduction = $('.dxd-course-introduction').html();
	$('a.dxd-course-ajax').click(function(){
		$('.dxd-course-body').load($(this).attr('href'));
		$('.dxd-course-header .nav-pills li').removeClass('active');
		return false;
	});

});
</script>
<?php Yii::app()->clientScript->registerScript("viewNum",
												'$.get("'.Yii::app()->createUrl('course/counter',array('id'=>$course->id)).'");'
												);?>

