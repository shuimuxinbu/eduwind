<div class="pull-right" style="margin-right:15px">
<?php 
//var_dump($role);
if(!$member) return;
if($member->inRoles(array('superAdmin','admin'))){
	//echo CHtml::link('我是小组组长',array("#"),array('class'=>'btn','disabled'=>true));
	echo CHtml::tag('em',array("class"=>"dxd-group-user-role"),Yii::t('app','我是管理员'));
}

if(Yii::app()->user->checkAccess('admin')||$member->inRoles(array('superAdmin','admin'))){	
	echo CHtml::link(Yii::t('app','小组管理'),array('groupManage/view','id'=>$group->id),array('class'=>'btn mr10',)); 	
}

if($member->inRoles(array('member','admin'))){
		$_m = Yii::t('app','确定取消申请？');
		echo CHtml::link(Yii::t('app','退出小组'),array('group/quit','id'=>$group->id),array('class'=>'btn ','onclick'=>"confirm({$_m});")); 
}else if($member->inRoles(array('questioned_applicant'))){
		echo CHtml::tag('em',array("class"=>"dxd-group-user-role"),Yii::t('app','申请等待审核'));
		$_m = Yii::t('app',"确定取消申请？");
		echo CHtml::link(Yii::t('app','取消申请'),array('group/quit','id'=>$group->id),array('class'=>'btn','onclick'=>"confirm({$_m});"));
}else if($member->inRoles(array('unquestioned_applicant'))){
		//echo CHtml::tag('em',array('class'=>'dxd-group-user-role'),'问题未回答');
		echo CHtml::link(Yii::t('app','查看问题'),array('group/join','id'=>$group->id),array('class'=>'dxd-group-user-role'));
		$_m = Yii::t('app',"确定取消申请？");
		echo CHtml::link(Yii::t('app','取消申请'),array('group/quit','id'=>$group->id),array('class'=>'btn','onclick'=>"confirm({$_m});"));
}else if($member->inRoles(array('superAdmin'))){
	
}else{
		echo CHtml::link(($group->joinType=="free"?"":Yii::t('app',"申请")).Yii::t('app','加入小组'),array('group/join','id'=>$group->id),array('class'=>' btn btn-success')); 
}
?>
</div>
<style type="text/css">
.dxd-group-user-role{
display:inline-block;
margin-top:5px;
margin-right:10px;

}
</style>