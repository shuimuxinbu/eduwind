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
//if($lesson->mediaSource=="self" || $lesson->mediaSource=="cloud"){
//$this->renderPartial('/lesson/_file_video',array('lesson'=>$lesson));
//}else{
//	$mediaUri = DxdUtil::generalYoukuSrc($lesson->mediaUri);

?>

<!--
<div class="bungeer_video_html5" href="http://v.youku.com/v_show/id_XNjEyODk1MzM2.html" poster="http://www.bungeer.com/static/img/web_hi_res_512.png" width='640' height='360'></div>
<script type=text/javascript  src="http://bungeer.com/static/js/video_html5.js"></script>
-->
<?php
//}
?>
<?php
if($lesson->mediaType=="link"):
?>
<iframe class="dxd-video-iframe" src="<?php echo $lesson->mediaLink->url;?>" frameborder=0 allowfullscreen  height="480px"></iframe>
<?php elseif($lesson->mediaType=="video"):
$this->renderPartial('/lesson/_file_video',array('lesson'=>$lesson));
endif;?>
<div class="mt10">
    <!-- JiaThis 分享 -->
    <div class="pull-left">
        <?php $this->widget('ext.jiathis.JiaThis'); ?>
    </div>
    <?php $finished = LessonLearn::model()->checkFinish($lesson->id, Yii::app()->user->id);?>
    <?php echo CHtml::link(Yii::t('app', '学完了'), array('lesson/toggleFinishLearn','id'=>$lesson->id), array('onclick'=>'openFancyBox(this);$(this).toggleClass("btn-success");return false;', 'class'=>'pull-right btn '.($finished?'btn-success':"")));?>
    <div class="clearfix"></div>
</div>
