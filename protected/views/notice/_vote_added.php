<?php
/* @var $this NoticeController */
/* @var $data Notice */
$vote = Vote::model()->findByPk($data['voteid']);
$entity = @Entity::model()->findByPk($vote->voteableEntityId);
$model=@$entity->getModel();
if(!$vote || !$model)  return false;

?>
<?php echo Yii::t('app','你的')?>
<?php echo $entity->getTypeLabel();?>
<?php echo CHtml::link($entity->getTitle(),array($entity->type.'/view','id'=>$model->id));?>
<?php echo Yii::t('app','新增加一个')?><em><?php echo ($vote->value>0?"<span style=\"color:green\">".Yii::t('app','赞同')."</span>":"<span style=\"color:red\">".Yii::t('app',"反对")."</span>")?></em>
