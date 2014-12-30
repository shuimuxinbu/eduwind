<?php 
$group = Group::model()->findByPk($data['groupId']);
if(empty($group)) return;
?>
<?php echo CHtml::link($group->user->name,$group->user->pageUrl); echo Yii::t('app','申请成立小组');?>
<?php echo CHtml::link($group->name,array("//group/index/view",'id'=>$group->id));?> 

