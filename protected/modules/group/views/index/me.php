<?php
$this->pageTitle = Yii::app()->name."-".Yii::t('app',"小组");
?>

<div id="edu-group" class="page-index row">
    <!-- 小组帖子列表 -->
    <div class="col-sm-9 index-postlist">
        <!-- menu -->
        <?php echo $this->renderPartial('_navMenu'); ?>

        <!-- 我的小组帖子 -->
        <div class="section-post-list tab-pane" id="post-tab-group-me">
            <?php $this->widget(
                'booster.widgets.TbListView',
                array(
                    'dataProvider'=>$newPostDataProvider,
                    'template'=>"{items}{pager}",
                    'itemView'=>'_item_index_post',
                    'separator'     =>  '<hr class="separator" style="margin:25px 0;">',
                    'emptyText'=>Yii::t('app','暂时没有小组帖子数据')
                )
            ); ?>
        </div>
    </div>

    <!-- Side: 我的小组 -->
    <div class="col-sm-3">
        <div class="side-mygroup">
            <h3><?php echo Yii::t('app','我的小组');?></h3>
            <?php $this->widget(
                'booster.widgets.TbListView',
                array(
                    'dataProvider'  =>  $myGroupDataProvider,
                    'template'      =>  '{items}',
                    'itemView'      =>  '_item_index_myGroup',
                    'emptyText'     =>  '<div class="col-sm-3">'.Yii::t('app','暂时没有小组').'</div>',
                    'htmlOptions'    =>  array('class'=>'row'),
                )
            ); ?>
        </div>

        <!-- 创建小组按钮 -->
        <div class="" >
            <?php echo CHtml::link('+&nbsp;'.Yii::t('app','申请创建小组'),array('create'),array('class'=>'create-group-bar text-center'));?>
        </div>
    </div>
</div>

