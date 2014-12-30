<div class="dxd-post-comment-item" data-commentId="<?php echo $data->id;?>">
<hr/>
<table style="width:100%">
	<tr>
	<!--
		<td style="width:40px;vertical-align:top;padding-top:24px;padding-left:10px;">
					<?php echo CHtml::ajaxLink(' ',array('vote/postcomment','commentId'=>$data->id,'value'=>1),array('success'=>'js:function(data){var item=$(".dxd-post-comment-item[data-commentId='.$data->id.']"); item.find(".dxd-post-comment-up").addClass("dxd-voted");item.find(".dxd-post-comment-vote-result").html(data);}'),array('class'=>'dxd-post-comment-up '.($data->voteUpNum ? "dxd-voted" : "")));?>
					<?php // echo CHtml::ajaxLink(' ',array('vote/postcomment','commentId'=>$data->id,'value'=>0),array('success'=>'js:function(data){var item =$(".dxd-post-comment-item[data-commentId='.$data->id.']");item.find(".dxd-post-comment-vote-result").html(data);}'),array('class'=>'dxd-post-comment-down '.($data->voteUpNum ? "dxd-voted" : "")));?>
		</td>
	-->
		<td style="width:60px;vertical-align:top;">
		<?php $img = CHtml::image(Yii::app()->baseUrl."/".DxdUtil::xImage($data->user->face, 50, 50),"images",array('style'=>'width:50px;height:50px;'));
				echo CHtml::link($img,$data->user->name,array('class'=>' dxd-username','data-userId'=>$data->user->id));
		?>
		</td>
		<td>
			<div style="margin-bottom:5px;"><?php echo CHtml::link($data->user->name,$data->user->pageUrl,array('class'=>'dxd-username','data-userId'=>$data->user->id));?><span class="muted">&nbsp;&nbsp;<?php echo date("Y-m-d H:i",$data->addTime);?></span>
			<?php // $img = CHtml::image(Yii::app()->baseUrl."/".DxdUtil::xImage($data->user->face, 25, 25),"images",array('style'=>'width:25px;height:25px;'));
				  //echo CHtml::link($img,$data->user->name,array('class'=>'dxd-username pull-right', 'data-userId'=>$data->user->id));
			?>
			<?php echo CHtml::ajaxLink(' ',array('comment/toggleVote','id'=>$data->id,'value'=>1),array('success'=>'js:function(data){var item=$(".dxd-post-comment-item[data-commentId='.$data->id.']"); item.find(".dxd-post-comment-up").addClass("dxd-voted");item.find(".dxd-post-comment-vote-result").html(data);}'),array('class'=>'pull-right dxd-post-comment-up '.($data->voteUpNum ? "dxd-voted" : "")));?>

			<div class="muted dxd-post-comment-vote-result pull-right" style="font-size:0.8em;padding-right:5px;" commentId="<?php echo $data->id?>"><?php if($data->voteUpNum || $data->voteDownNum) $this->renderPartial('//vote/result',array('score'=>$data->voteUpNum-$data->voteDownNum,'voteUpers'=>$data->getVoteUperDataProvider()->getData()));?></div>
			<div class="clearfix"></div>
			</div>
			<div class="dxd-post-comment-content" style="margin-bottom:30px;">
				<?php if($data->refer){?>
					<div class="dxd-post-comment-refer"><?php echo $data->refer->user->name;?>:<?php $output=strip_tags($data->refer->content);echo mb_strlen($output)>160 ? mb_substr($output,0,160,'utf8')."...":$output;?></div>
					<span style="font-weight:bold;color:#000;"><?php echo Yii::t('app','回复');?></span><?php echo CHtml::link($data->refer->user->name.":","#",array('style'=>'font-weight:bold;color:#000;'));?>
				<?php }?>
			<?php echo $data->content;?>
			</div>
			<div style="text-align:right" class="muted">
				<?php echo CHtml::link(Yii::t('app','回复'),'javascript:;',array('class'=>'muted','data-toggle'=>'collapse','data-target'=>'#dxd-comment-form'.$index));?>&nbsp;|
				<?php
					if(Yii::app()->user->checkAccess('admin') || $member->inRoles(array('admin','superAdmin')))
				   		 echo CHtml::link(Yii::t('app','删除'),array('deleteComment','id'=>$group->id,'commentId'=>$data->id),array('class'=>'muted'));?>
			</div>
			<div id="dxd-comment-form<?php echo $index;?>" class="collapse">
			<?php /** @var BootActiveForm $form */
			$form = $this->beginWidget('CActiveForm',array('action'=>array('post/addComment','id'=>$post->id))); ?>
			<?php echo $form->hiddenField($data,'referId',array('value'=>$data->id));?>
			<?php //echo $form->hiddenField($data,'id',array('value'=>$data->id));?>
			<div>
			<?php echo $form->textarea($data,'content',array('style'=>'width:96%;height:5em;margin:5px;','value'=>""));?>
			</div>
			<div>
			<?php $this->widget('booster.widgets.TbButton', array(
			    'context'=>'success',
			    'label'=>Yii::t('app','回复'),
			    'buttonType'=>'submit',
				'htmlOptions'=>array('class'=>'pull-right','style'=>'margin-right:15px;')
			    )); ?>
			</div>
			<?php $this->endWidget(); ?>
			</div>
		</td>
	</tr>
</table>
</div>
