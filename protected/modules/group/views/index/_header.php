<div class="row group-header">
    <div class="col-sm-12">
        <!-- 小组头像 -->
        <div class="pull-left pic hidden-xs">
            <?php
                if($group->face && DxdUtil::xImage($group->face,140,140)):
                    $imgUrl = Yii::app()->baseUrl."/".DxdUtil::xImage($group->face,100,100);
                else:
                    $imgUrl = "http://placehold.it/100x100";
                endif;
                echo CHtml::image($imgUrl,'image',array('class'=>'pull-left dxd-group-face'));
            ?>
            <div class="clearfix"></div>
        </div>
        <!-- 管理小组 -->
        <div class="pull-right admin hidden-xs">
            <?php $this->renderPartial('_join',array('member'=>$member,'group'=>$group)); ?>
        </div>
        <!-- 小组信息 -->
        <div class="info">
            <span class="name">
                <?php echo mb_substr($group->name, 0, 12, 'utf-8'); ?>
            </span>
            &nbsp;&nbsp;
            <span class="text">
                <?php echo $group->leaderTitle; ?> : <?php echo CHtml::link($group->superAdmin->name,$group->superAdmin->pageUrl)?>
                &nbsp;&nbsp;
				<?php echo Yii::t('app','{memberNum} 位 {memberTitle} 在此',array('{memberNum}'=>$group->memberNum,'{memberTitle}'=>$group->memberTitle))?>
            </span>
            <p class="de"><?php echo mb_substr(strip_tags($group->introduction), 0, 98, 'utf-8'); ?></p>
        </div>
        <!-- 管理小组 -->
        <div class="visible-xs">
            <?php $this->renderPartial('_join',array('member'=>$member,'group'=>$group)); ?>
        </div>
        <div class="clearfix"></div>
    </div>
</div>


<div class="row menu menu-group-home group-menu hidden-xs">
    <?php echo CHtml::link(Yii::t('app','发布讨论'), array('post/create', 'groupId'=>$group->id), array('class'=>'btn pull-right create-post hidden-xs')); ?>
    <?php $this->widget('booster.widgets.TbMenu', array(
        'type'  =>  'pills',
        'items' =>  array(
            array('label'=>Yii::t('app','讨论区'), 'url'=>array('view', 'id'=>$group->id), 'active'=>$this->action->id==='view'),
            array('label'=>Yii::t('app','小组成员'), 'url'=>array('member', 'id'=>$group->id), 'active'=>$this->action->id==='member'),
        ),
    )); ?>
</div>
<div class="row group-menu visible-xs">
    <?php echo CHtml::link(Yii::t('app','发布讨论'), array('post/create', 'groupId'=>$group->id), array('class'=>'btn pull-right create-post hidden-xs')); ?>
    <?php $this->widget('booster.widgets.TbMenu', array(
        'type'  =>  'pills',
        'items' =>  array(
            array('label'=>Yii::t('app','讨论区'), 'url'=>array('view', 'id'=>$group->id), 'active'=>$this->action->id==='view'),
            array('label'=>Yii::t('app','小组成员'), 'url'=>array('member', 'id'=>$group->id), 'active'=>$this->action->id==='member'),
            array('label'=>Yii::t('app','发布评论'), 'url'=>array('post/create', 'groupId'=>$group->id)),
        ),
    )); ?>
</div>
