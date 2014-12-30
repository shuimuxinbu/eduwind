<div>
<?php $groupCourse = GroupCourse::model()->findByAttributes(array('courseId'=>$courseId,'groupId'=>$data->id));?>
<?php if($groupCourse):?>
<?php echo CHtml::ajaxLink(Yii::t('app','取消收藏'),array('groupCourse/delete','id'=>$groupCourse->id),array('type'=>'post','success'=>'js:function(data){window.location.reload();}'),array('class'=>'btn pull-right'));?>
<?php else:?>
<?php echo CHtml::ajaxLink(Yii::t('app','收藏'),array('groupCourse/create','groupId'=>$data->id,'courseId'=>$courseId),array('success'=>'js:function(data){window.location.reload();}'),array('class'=>'btn  btn-success pull-right'));?>
<?php endif;?>
<?php echo $data->name;?>
<div class="clearfix"></div>
</div>