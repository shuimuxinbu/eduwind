<?php 
$vote = Vote::model()->findByPk($data['voteId']);
$post = null;
if($vote) $post = Post::model()->findByAttributes(array('entityId'=>$vote->voteableEntityId));
if(!$post) return false;
?>

<?php echo CHtml::link($vote->user->name,$vote->user->pageUrl);?> 
<?php echo Yii::t('app','向');?><?php if($post->userId==Yii::app()->user->id) {echo "你的帖子";} else{echo "你关注的帖子";} ?> 
<?php echo CHtml::link($post->title,array('post/view','id'=>$post->id)); echo Yii::t('app','投了');?>
<?php if($vote->value>0): ?><span style="color:greed"><?php echo Yii::t('app','赞成票');?></span><?php else:?><span style="color:red"><?php echo Yii::t('app','反对票'?></span><?php endif;?>