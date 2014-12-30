<?php 
$group = Group::model()->findByPk($data['groupId']);
if(!$group) return false;
?>
<?php echo Yii::t('app','你申请成立的小组')?>
<?php echo CHtml::link($group->name,array("/group/index/view",'id'=>$group->id));?><?php echo Yii::t('app','已被批准')?>
