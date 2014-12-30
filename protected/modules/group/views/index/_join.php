<?php 
//var_dump($role);
if(!$member) return;
if($member->inRoles(array('superAdmin','admin'))){
// echo CHtml::link('我是小组组长',array("#"),array('class'=>'btn','disabled'=>true));
// echo CHtml::tag('em',array("class"=>"dxd-group-user-role"),'我是管理员');
}

if(Yii::app()->user->checkAccess('admin')||$member->inRoles(array('superAdmin','admin'))){	
	echo CHtml::link( Yii::t('app','小组管理'),array('manage/view','id'=>$group->id),array('class'=>'btn',)); 	
}

if($member->inRoles(array('member','admin'))){
		echo CHtml::link(Yii::t('app','退出小组'),array('quit','id'=>$group->id),array('class'=>'btn ','onclick'=>'confirm('.Yii::t('app','确定退出？').')')); 
}else if($member->inRoles(array('questioned_applicant'))){
		echo CHtml::tag('em',array("class"=>"dxd-group-user-role"),Yii::t('app','申请等待审核'));
		echo CHtml::link(Yii::t('app','取消申请'),array('quit','id'=>$group->id),array('class'=>'btn','onclick'=>'confirm('.Yii::t('app',"确定取消申请？").')'));
}else if($member->inRoles(array('unquestioned_applicant'))){
		//echo CHtml::tag('em',array('class'=>'dxd-group-user-role'),'问题未回答');
		echo CHtml::link(Yii::t('app','查看问题'),array('join','id'=>$group->id),array('class'=>'dxd-group-user-role'));
		echo CHtml::link(Yii::t('app','取消申请'),array('quit','id'=>$group->id),array('class'=>'btn','onclick'=>'confirm('.Yii::t('app',"确定取消申请？").')'));
}else if($member->inRoles(array('superAdmin'))){
	
}else{
		echo CHtml::link(($group->joinType=="free"?"":Yii::t('app',"申请")).Yii::t('app','加入小组'),array('index/join','id'=>$group->id),array('class'=>' btn btn-success')); 
}
?>
