<?php
/* @var $this GroupController */
/* @var $model Group */
 $this->widget('booster.widgets.TbBreadcrumbs', array(
    'links'=>array($group->name=>array('group/view','id'=>$group->id), 
 					Yii::t('app',"小组管理"),
 					),
 'homeLink'=>false					
)); 
?>
<div class="row">
	<div class="col-sm-9">
	<h3><?php echo Yii::t('app','小组成员')?></h3>
	<?php $this->widget('booster.widgets.TbListView', array(
			    'dataProvider'=>$memberDataProvider,
			    'template'=>"{items}\n{pager}",
				'separator'=>'<hr style="margin:10px 0;"/>',
				'viewData'=>array('group'=>$group),
				'itemView'=>'_admin_member_item',   // refers to the partial view named '_post'
		)); ?>
		<br/>
			<h3><?php echo Yii::t('app','小组申请者')?></h3>
		
			<?php $this->widget('booster.widgets.TbListView', array(
			    'dataProvider'=>$applicantDataProvider,
				'viewData'=>array('group'=>$group),
				'separator'=>'<hr style="margin:10px 0;"/>',
			    'template'=>"{items}\n{pager}",
				'emptyText'=>Yii::t('app','没有申请者'),
				'itemView'=>'_admin_applicant_item',   // refers to the partial view named '_post'
		)); ?>
	</div>
	<div class="col-sm-3">
		
	</div>
</div>
