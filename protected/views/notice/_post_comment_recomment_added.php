<?php
$commentId = $data['commentId'];
$comment = Comment::model()->findByPk($commentId);
$post = Post::model()->findByAttributes(array('entityId'=>$comment->commentableEntityId));
if (empty($comment) || empty($post)) return;
?>

<?php echo CHtml::link($comment->user->name,$comment->user->pageUrl);?>
<?php echo Yii::t('app','回复了你对帖子')?> <?php echo CHtml::link($post->title, array('/group/post/view', 'id'=>$post->id)); echo Yii::t('app',' 的评论');?>
