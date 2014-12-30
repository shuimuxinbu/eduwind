<!-- 公共笔记开始 -->
<div class="dxd-public-lesson-note">
		
		<div class="muted">
		by <?php echo CHtml::link($data->user->name,$data->user->pageUrl,array('class'=>'dxd-username muted','data-userId'=>$data->userId));?>
		</div>
		<div class="clearfix"></div>
		
		<!-- 笔记内容-->
		<div class="dxd-lesson-note" style="font-size: 16px;line-height:1.5em;margin-top:5px;">
			<?php echo $data->content; ?>
		</div>
		<!-- 公共笔记结束-->
		
				<!-- 为公共笔记添加感谢 -->
		<div>
			<?php echo CHtml::link(' ',array('vote/lessonNote','noteid'=>$data->id),array('rel'=>'tooltip','data-title'=>Yii::t('app','对我有用'),'class'=>'pull-left dxd-lesson-note-vote dxd-post-up '.($data->voteNum ? "dxd-voted" : "")));?>&nbsp;&nbsp;
			<span class="dxd-lesson-note-vote-result muted"><?php if($data->voteNum) $this->renderPartial('/vote/thanks_result',array('score'=>$data->voteNum,'voteUpers'=>$data->voteUpers));?></span>
		</div>
		<div class="clearfix"></div>
		<!-- 为公共笔记添加感谢结束 -->

</div>			
