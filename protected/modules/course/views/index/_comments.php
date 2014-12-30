<?php
/* @var $this LessionController */
/* @var $data Lession */
?>
<div class="dxd-dashboard-panel  dxd-comments">

	<h4 class="dxd-panel-title">
		<?php echo Yii::t('app','课程讨论');?>
		<?php //echo CHtml::link('全部 &gt', array('announcement/list', 'courseId'=>$course->id), array('onclick'=>'openFancyBox(this);return false;', 'class'=>'pull-right','style'=>'font-size:0.9em;;')); ?>
	</h4>
	<?php $this->renderPartial('//layouts/_flash_messages');?>

	<div class="dxd-panel-content">
		<div style="margin-top:20px">
		<?php $this->renderPartial('_comment_form',array('commentableEntityId'=>$course->entityId));?>
		</div>

	<?php
	$this->widget('booster.widgets.TbListView',array(
				'dataProvider'=>$commentDataProvider,
			'itemView'=>'_comment_item',
			'separator'=>'<hr style="margin:15px 0"/>',
			'template'=>'{items}{pager}',
	//			'viewData'=>array('lesson'=>$lesson),
			'emptyText'=>Yii::t('app','还没有留言'),
	));
	?>
	</div>
</div>
<script type="text/javascript">
$(document).ready(function(){
    $('.dxd-add-comment-textarea').focus(function() {
        $(this).parents('.dxd-add-comment-form').find('.btn').fadeIn();
    }).blur(function(){
        $(this).parents('.dxd-add-comment-form').find('.btn').fadeOut();
    });
});
function onCommentSuccess(data){
    if(data){
			$('.dxd-add-comment-textarea').attr('value','');
            $(".dxd-comments").replaceWith(data);
        }
}
</script>
