<!-- 评论列表 -->
<div>
    <?php
    $this->widget('booster.widgets.TbListView', array(
        'dataProvider'=>$model->getCommentDataProvider(array('pagination'=>array('pageSize'=>40))),
        'itemView'=>'_comment_item',
        'viewData'=>array('model'=>$model),
        'summaryText'=>'{count}'.Yii::t('app','回复'),
        'emptyText'=>false,
    )); ?>
</div>


<!-- 发布评论 -->
<div >
    <?php $comment = new Comment;?>
    <?php $form=$this->beginWidget('booster.widgets.TbActiveForm', array(
        'id'=>'post-comment-form',
        'action'=>array('addComment','id'=>$model->id),
        'clientOptions'=>array('validateOnSubmit'=>true,),
    )); ?>
    <?php echo $form->errorSummary($comment); ?>

    <?php if(!Yii::app()->user->isGuest){?>
        <!-- 已登录可发布评论 -->
        <div class="row" >
            <div style="">
            <h4><?php echo Yii::t('app','我的回复：'); ?></h4>
            <?php  $this->widget('ext.kindeditor.KindEditor', array(
                    'model'=>$comment,
                    'attribute'=>'content',
            )); ?>
            <?php echo $form->textArea($comment,'content',array('rows'=>7,'style'=>'width:100%','class'=>'dxd-kind-editor')); ?>

            <?php echo $form->error($comment,'content'); ?>
            </div>
        </div>
        <br/>
        <div class="row" style="maring-top:60px;">
        <?php $this->widget('booster.widgets.TbButton', array(
            'label'=>$comment->isNewRecord ? Yii::t('app','发布') : Yii::t('app','保存'),
            'buttonType'=>'submit',
            'htmlOptions'=>array('class'=>'pull-right btn-default')
        )); ?>
        </div>
    <?php }else{ ?>
        <!-- 先登陆再发布评论 -->
        <?php Yii::app()->user->returnUrl=Yii::app()->request->getUrl(); ?>
        <div class="row" >
            <div style="margin-left:30px;">
            <h4><?php echo Yii::t('app','我的回复：');?></h4>
            <p><?php echo Yii::t('app','回复前请先');?><?php echo CHtml::link(Yii::t('app',' 登录 '),array('u/login'))?>或<?php echo CHtml::link(Yii::t('app',' 注册 '),array('u/register'));?></p>
            </div>
        </div>
    <?php }?>
    <?php $this->endWidget(); ?>
</div>
