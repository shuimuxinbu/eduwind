<div class="col-sm-9" style="margin-left:0;margin-bottom:10px;">
	<div style="font-size:1.2em">
	<?php echo CHtml::link($data->question->title,array('question/view','id'=>$data->question->id));;
	?>
	</div>
	<div>
		<div style="margin:10px 0">
		<?php if($data->voteupNum) $this->renderPartial('//vote/result',array('score'=>$data->voteupNum-$data->count_votedown,'voteUpers'=>$data->voteUpers));?>
		</div>
		<div style="margin:10px 0">
			<?php echo $data->content;;?>
		</div>
		<div class="muted pull-right"><?php echo date('Y-m-d H:i',$data->addTime);?></div>
		<div class="clearfix"></div>
	</div>
</div>
