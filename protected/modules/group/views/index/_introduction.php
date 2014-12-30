		<div class="dxd-dashboard-panel">
			<div class="pull-right dxd-course-edit">
			
			</div>	
					<?php //echo CHtml::link('全部问答',array('question/index','groupid'=>$group->id),array('class'=>'pull-right dxd-group-edit'));?>
			<h4 class="dxd-panel-title"><?php echo Yii::t('app','小组简介');?></h4>
			<div class="dxd-panel-content">
				<?php // echo CHtml::link("<i class='icon-pencil'></i>提问",array('question/create','groupid'=>$group->id),array('class'=>'btn pull-right'));?>
				<div>		
				<?php  echo (isset($group->introduction) ? $group->introduction : Yii::t('app',"还没有简介"));?>
				
				<div class="clearfix"></div>
				</div>
				<div>
			<?php if($member && $member->inRoles(array('superAdmin,admin'))):?>
			<?php //echo CHtml::link('编辑',array('group/updateInroduction','id'=>$group->id),array('class'=>'muted pull-right'));?>
			<?php endif;?>
			</div>
				<div class="clearfix"></div>					
			
			</div>
		</div>