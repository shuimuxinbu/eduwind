<?php
/* @var $this NoticeController */
/* @var $data Notice */
$comment = Comment::model()->findByPk($data['commentId']);
$entity = Entity::model()->findByPk($comment->commentableEntityId);
if(!$comment || !$entity->getModel()) return false;

?>
	<?php echo CHtml::link($comment->user->name,$comment->user->pageUrl); echo Yii::t('app',"回复了");?>
	<?php echo $entity->getTypeLabel();?>
	<?php echo CHtml::link($entity->getTypeLabel(),array($entity->type.'/view','id'=>$entity->getModel()->id));?>
