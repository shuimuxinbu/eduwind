<?php 
if(get_class($data)=="Lesson"):
?>
	<?php  $this->renderPartial('_progress_lesson_item',array('data'=>$data,'user'=>$user));?>

<?php else:?>
<div class="mt20">
	<?php  $this->renderPartial('_progress_chapter_item',array('data'=>$data,'user'=>$user));?>
</div>
	<?php endif;?>