<?php
/* @var $this NoticeController */
/* @var $data Notice */
$comment = Comment::model()->findByPk($data['commentId']);
if(!$comment) return false;

?>


	<?php echo CHtml::link($comment->user->name,array("/u/index",'id'=>$comment->userId)); echo Yii::t('app',"回复了你的评论");?>
<?php echo CHtml::link(mb_substr($comment->content,0,20,'utf8'),array('comment/view','id'=>$comment->id));?>
