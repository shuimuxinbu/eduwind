<?php
/* @var $this NoticeController */
/* @var $data Notice */

$comment    =   Comment::model()->findByPk($data['commentId']);
$post       =   CoursePost::model()->findByAttributes(array('entityId'=>$comment['commentableEntityId']));
if(!$post || !$comment ) return false;
echo CHtml::link($comment->user->name,$comment->user->pageUrl);
echo Yii::t('app',' 对你在');
echo CHtml::link(mb_substr($post->title,0,10,'utf8'), array('/course/post/view', 'id'=>$post->id));
echo Yii::t('app',' 的评论做了回复: ');
echo mb_substr($comment->content,0,10);
?>
