<?php
/* @var $this MessageController */
/* @var $data Message */
$user= $data->fromUserId==Yii::app()->user->id ? $data->toUser : $data->fromUser;

?>

<a href="<?php echo Yii::app()->createUrl('message/view',array('userId'=>$user->id));?>"  style="display:block;">

<?php 
echo CHtml::image($user->face,'image',array('class'=>'pull-left','style'=>'width:48px;height:48px;'));?>

<div style="margin-left:15px" class="pull-left">
	<div style="margin-bottom:5px;"><span> <?php echo $user->name;?></span>
	&nbsp;&nbsp;<span class="muted"><?php echo date("Y-m-d H:i",$data->addTime);?></span>
	
	</div>
	<span style="color:#333"><?php echo mb_substr($data->content,0,50,'utf8');?></span>

</div>
	<?php 
	$uncheckNum = Message::model()->countUnchecked(Yii::app()->user->id,  $data->fromUserId==Yii::app()->user->id ? $data->toUser->id : $data->fromUser->id);
	if($uncheckNum>0)
		$this->widget('booster.widgets.TbBadge', array(
	    'type'=>'warning', // 'success', 'warning', 'important', 'info' or 'inverse'
	    'label'=>$uncheckNum,
		'htmlOptions'=>array('class'=>'pull-right','style'=>'margin-top:20px;')
	));
 ?>
<div class="clearfix"></div>

</a>

