			<!-- topics -->
			<div style="margin-bottom:15px">
				<div style="display:none">
					<?php 
						$this->widget('editable.Editable', array(
							'type' => 'select2',
							'name' => 'hidden',
						));
					?>
				</div>
				
			<span class="dxd-topics dxd-topics editable" id="dxd-topics-editable-1"
            	data-toggle="manual" data-type="select2" data-pk="1"
            	data-value="<?php echo $course->tags->toString();?>" data-original-title="<?php echo Yii::t('app',"编辑话题");?>"></span>
        	
        	<?php if(!Yii::app()->user->isGuest):?>
        	&nbsp;&nbsp;<a href="#" id="dxd-topics-edit-1" data-editable="dxd-topics-editable-1" class="muted" courseId="<?php echo $course->id?>"><i class="icon-pencil"></i><?php echo Yii::t('app','编辑');?></a>
        	<?php endif;?>
        	&nbsp;&nbsp;<?php echo CHtml::link('<i class="icon-list"></i>'.Yii::t('app','历史'),array('revisionHistory/coursetopic','courseId'=>$course->id),array('class'=>' dxd-course-topic-revision muted'));?>
        	
			</div>
			<!-- topics -->