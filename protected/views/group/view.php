<?php
/* @var $this CourseController */
/* @var $course Course */
$lesson = new Lesson;
?>
<style type="text/css">
<!--

-->
.dxd-course-notok{
margin-bottom:20px;
}
.dxd-course-notok li{
font-size:20px;
font-weight:bold;
line-height:40px;
}
</style>

<?php echo $this->renderPartial('_header', array('group'=>$group,'member'=>$member)); ?>

<div class="row dxd-course-body">



	<div class="col-sm-7 dxd-left-col">
		<?php $this->renderPartial('_post',array('group'=>$group,
							'postDataProvider'=>$postDataProvider,'member'=>$member,
							'courseDataProvider'=>$courseDataProvider) );?>
	
	<?php //$this->renderPartial('_question',array('group'=>$group,'questionDataProvider'=>$questionDataProvider,'member'=>$member) );?>


	</div>

	<div class="col-sm-5 dex-right-col pull-right">


	
		<?php 
		$this->renderPartial('_introduction',array('group'=>$group,'member'=>$member) );?>
	


	<?php // $this->renderPartial('_file',array('group'=>$group,'fileDataProvider'=>$fileDataProvider) );?>

<?php //	$this->renderPartial('_course',array('group'=>$group,'courseDataProvider'=>$courseDataProvider) );?>

	<?php 
	$this->renderPartial('/member/_items',array('memberDataProvider'=>$memberDataProvider) );?>

	</div>

</div>
