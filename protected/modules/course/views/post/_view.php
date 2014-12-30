		<h3 ><?php echo $post->title;?></h3>
		<hr style="margin: 10px 0 20px 0"/>
		<table style="width:100%">
			<tr>
				<td style="width:60px;vertical-align:top;">
									<?php $img = CHtml::image(Yii::app()->baseUrl."/".DxdUtil::xImage($post->user->face, 50, 50),"images",array('style'=>'width:50px;height:50px;'));
						echo CHtml::link($img,$post->user->name,array('class'=>' dxd-username','data-userId'=>$post->user->id));
					?>
				</td>
				<td>
					<?php echo CHtml::ajaxLink(' ',array('post/toggleVote','id'=>$post->id,'value'=>1),array('success'=>'js:function(data){$(".dxd-post-up").addClass("dxd-voted");$(".dxd-post-vote-result").html(data);}'),array('class'=>'pull-right dxd-post-up '.($post->voteUpNum ? "dxd-voted" : "")));?>

					<div style="margin-bottom:5px;"><?php echo CHtml::link($post->user->name,$post->user->pageUrl,array('class'=>'dxd-username','data-userId'=>$post->user->id));?><span class="muted">&nbsp;&nbsp;<?php echo date("Y-m-d H:i",$post->addTime);?></span>
					<?php //$img = CHtml::image(Yii::app()->baseUrl."/".DxdUtil::xImage($post->user->face, 25, 25),"images",array('style'=>'width:25px;height:25px;'));
						//echo CHtml::link($img,$post->user->name,array('class'=>'pull-right dxd-username','data-userId'=>$post->user->id));
					?>
					<div class="muted dxd-post-vote-result pull-right" style="font-size:0.8em;padding-right:5px;"><?php if($post->voteUpNum || $post->voteDownNum) $this->renderPartial('//vote/result',array('score'=>$post->voteUpNum-$post->voteDownNum,'voteUpers'=>$post->getVoteUperDataProvider()->getData()));?></div>
					<div class="clearfix"></div>
					</div>
					<div class="dxd-post-content" style="margin-bottom:30px;">
						<?php echo $post->content;?>
					</div>
					<?php  $this->widget('ext.jiathis.JiaThis');?>
					<div style="text-align:right" class="muted">
					<?php if($member->inRoles(array('superAdmin','admin'))):?>
						<?php echo CHtml::link(($post->isTop>0?Yii::t('app','取消置顶'):Yii::t('app','置顶')),array('setTop','id'=>$post->id,'value'=>($post->isTop>0?'0':'1')),array('class'=>'muted'));?>
					<?php endif;?>
					&nbsp;|&nbsp;
					<?php
					if(Yii::app()->user->checkAccess('updatePost',array('post'=>$post))){
						 echo CHtml::link(Yii::t('app','编辑'),array('update','id'=>$post->id),array('class'=>'muted'));
					}
					?>
					&nbsp;|&nbsp;
				<?php if(Yii::app()->user->checkAccess('deletePost',array('post'=>$post)) || $member->inRoles(array('superAdmin','admin'))):?>
						<?php echo CHtml::link(Yii::t('app','删除'),array('delete','id'=>$course->id,'postId'=>$post->id),array('class'=>'muted'));?>
				<?php endif;?>
					</div>

				</td>
			</tr>
		</table>

		<div>

	<div style="margin-top:50px;">
	<?php
	$this->widget('booster.widgets.TbListView', array(
	'dataProvider'=>$post->getCommentDataProvider(array('pagination'=>array('pageSize'=>40))),
	'itemView'=>'_comment_item',
	'viewData'=>array('post'=>$post,'member'=>$member,'group'=>$course),
	'summaryText'=>Yii::t('app','{count} 回复',array("{count}"=>$count)),
	'emptyText'=>false,
)); ?>
	</div>
<div >
<?php $comment = new Comment;?>
<?php $form=$this->beginWidget('CActiveForm', array(
	'id'=>'post-comment-form',
	'action'=>array('post/addComment','id'=>$post->id),
	'clientOptions'=>array('validateOnSubmit'=>true,),
)); ?>

	<?php echo $form->errorSummary($comment); ?>
	<?php if(!Yii::app()->user->isGuest){?>
	<div class="row" >
	<div style="margin-left:40px;">
		<h4><?php echo Yii::t('app','我的回复：');?></h4>

		<?php echo $form->textArea($comment,'content',array('rows'=>7,'style'=>'width:100%','class'=>'dxd-kind-editor')); ?>

		<?php echo $form->error($comment,'content'); ?>
		</div>
	</div>
<br/>
	<div class="row" style="maring-top:60px;">
			<?php $this->widget('booster.widgets.TbButton', array(
    'context'=>'success',
    'label'=>$comment->isNewRecord ? Yii::t('app','发布') : Yii::t('app','保存'),
    'buttonType'=>'submit',
	'htmlOptions'=>array('class'=>'pull-right')
    )); ?>
	</div>
<?php }else{
Yii::app()->user->returnUrl=Yii::app()->request->getUrl();;

	?>
	<div class="row" >
	<div style="margin-left:30px;">
	<h4><?php echo Yii::t('app','我的回复：');?></h4>
		<p><?php echo Yii::t('app','回复前请先');?><?php echo CHtml::link(Yii::t('app',' 登录 '),array('//u/login'))?><?php echo Yii::t('app','或')?><?php echo CHtml::link(Yii::t('app',' 注册 '),array('//u/register'));?></p>
	</div>
	</div>
<?php }?>
<?php $this->endWidget(); ?>

</div><!-- form -->
</div>


<?php  Yii::app()->clientScript->registerScript("viewNum",
												'$.get("'.$this->createUrl('post/counter',array('id'=>$post->id)).'");'
												);?>


