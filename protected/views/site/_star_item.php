<div style="margin-bottom:10px"> 
<div class="pull-left">
	<?php
	$img = CHtml::image(Yii::app()->baseUrl."/".DxdUtil::xImage($data->face, 40, 40),$data->name,array('style'=>'width:40px;height:40px;'));
	echo CHtml::link($img,array('u/index','id'=>$data->id),array('class'=>'dxd-username','data-userId'=>$data->id),array('style'=>'display:block;width:40px;height:40px;'));
	?>
</div>
<div style="line-height:16px;margin-left:50px;">
<div>
<?php 
echo CHtml::link($data->name,$data->pageUrl,array('class'=>'dxd-username','data-userId'=>$data->id,'style'=>'margin-top:5px;'));
?>
&nbsp;&nbsp;
<span >
<?php  echo Yii::t('app','{answerNum}个回答',array("{answerNum}"=>$data->answerNum));?>&nbsp;
<!--  
<?php   echo $data->fanNum;?> 人关注Ta&nbsp;-->
<?php echo Yii::t('app','获{answerVoteupNum}次赞同',array("{answerVoteupNum}"=>$data->answerVoteupNum))?>&nbsp;
</span>
</div>
<div style="margin-top:10px;font-size:0.9em;" class="muted" >
<?php echo Yii::t('app','回答了：');?><?php  
$answer= $data->getBestAnswer();
if($answer && isset($answer->question)){
echo CHtml::link(mb_substr($answer->question->title,0,18,'utf8')."...",array('question/view','id'=>$answer->questionid),array('class'=>'muted'));
}
?>
</div>

</div>
<div class="clearfix"></div>
</div>
