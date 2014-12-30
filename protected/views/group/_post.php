<!--  

		-->
		
			
    <div class="tabbable" style="border:1px solid #ccc;padding:5px 15px 10px 15px;margin-bottom:20px;border-radius:3px;"> <!-- Only required for left/right tabs -->

    <ul class="nav nav-tabs" style="margin-top:5px;margin-bottom: 15px">
    <li class="active"><a href="#tab1" data-toggle="tab"><?php echo Yii::t('app','讨论区')?></a></li>
    <li><a href="#tab2" data-toggle="tab"><?php echo Yii::t('app','课程收藏区')?></a></li>
    </ul>
    
        <div class="tab-content">
    <div class="tab-pane active" id="tab1">

	
		
			<?php //echo CHtml::link('全部帖子',array('post/index','groupid'=>$group->id),array('class'=>'pull-right dxd-course-edit'));?>
				<div class="pull-right">			
				<?php if($member->inRoles(array('superAdmin','admin','member'))){
					echo CHtml::link("<i class='icon-pencil'></i>".Yii::t('app','发布新贴'),array('addPost','id'=>$group->id),array('class'=>'btn'));
						}else{
					echo CHtml::tag('em',array(),Yii::t('app','欢迎非小组成员参与回帖'));
						}
						?>
				</div>		
				
			<div class="dxd-panel-content" style="padding:10px 0">
				<?php //echo CHtml::link("<i class='icon-pencil'></i>发布新帖",array('post/create','groupid'=>$group->id),array('class'=>'btn pull-right'));?>
				<div class="clearfix"></div>
				<?php 
				$this->widget('booster.widgets.TbListView', array(
				    'dataProvider'=>$postDataProvider,
				    'itemView'=>'_post_item',   // refers to the partial view named '_post'
					'summaryText'=>false,
					'template'=>'{items}',
					'separator' => '<hr style="margin:10px 0;"/>',
					'emptyText'=>Yii::t('app','暂时还没有人发帖'),
				));
				?>
			
		</div>



    </div>
	    <div class="tab-pane" id="tab2">
	<?php $this->widget('booster.widgets.TbThumbnails', array(
	    'dataProvider'=>$courseDataProvider,
	    'template'=>"{items}\n{pager}",
	    'itemView'=>'_course_item',	
		'emptyText'=>Yii::t('app','还没有收藏课程'),
	)); ?>
	 	</div>
	 		<div class="clearfix"></div>
	 	</div>
    </div>
