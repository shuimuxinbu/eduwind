<?php
/* @var $this LessonController */
/* @var $data Lesson */
?>
<style type="text/css">
.dxd-video-iframe{
width: 100%;
}
.dxd-container{
margin-top:10px;
}
@media (min-width: 767px) {
/*.dxd-video-iframe{
height:520px;
}
*/
}
</style>

<?php
if($lesson->mediaType=="link"):
?>
<embed class="dxd-video-iframe" src="<?php echo $lesson->mediaLink->url;?>" height="480" allowfullscreen="true">

<?php elseif($lesson->mediaType=="video"):
$this->renderPartial('/lesson/_file_video',array('lesson'=>$lesson));
elseif($lesson->mediaType == "text"):?>
<div class="dxd-post-content" style="margin-bottom:30px;">
<?php
	$text = Text::model()->findByPk($lesson->mediaId);
	echo $text->content;
?>
</div>
<?php endif;?>

<div class="mt10">
    <!-- JiaThis 分享 -->
    <div class="pull-left">
        <?php $this->widget('ext.jiathis.JiaThis'); ?>
    </div>
    <?php $finished = LessonLearn::model()->checkFinish($lesson->id, Yii::app()->user->id);?>
    <?php echo CHtml::link(Yii::t('app', '学完了'), array('lesson/toggleFinishLearn','id'=>$lesson->id), array('onclick'=>'openFancyBox(this);$(this).toggleClass("btn-success");return false;', 'class'=>'pull-right btn btn-default '.($finished?'btn-success':"")));?>
    <div class="clearfix"></div>
</div>
