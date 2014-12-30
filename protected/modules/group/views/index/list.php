<?php
$this->pageTitle = Yii::app()->name."-".Yii::t('app',"小组");
?>

<div id="edu-group" class="page-list row">
    <!-- 小组帖子列表 -->
    <div class="col-sm-9 index-postlist">
        <!-- menu -->
        <?php echo $this->renderPartial('_navMenu'); ?>

        <!-- 所有小组 -->
        <div class="section-grouplist tab-pane list-group" id="post-tab-group-all">
            <?php $this->widget(
                'booster.widgets.TbListView',
                array(
                    'dataProvider'=>$allGroupDataProvider,
                    'template'=>"{items}{pager}",
                    'itemView'=>'_item_index_allGroup',
                    'emptyText'=>'<div class="col-sm-9">'.Yii::t('app','暂时没有小组').'</div>',
                    'htmlOptions'   =>  array('class'=>'row')
                )
            ); ?>
        </div>
    </div>

    <!-- Side: 热门小组 -->
    <div class="col-sm-3">
        <div class="side-hotgroup">
            <h3><?php echo Yii::t('app','热门小组');?></h3>
            <?php $this->widget(
                'booster.widgets.TbListView',
                array(
                    'dataProvider'  =>  $hotGroupDataProvider,
                    'template'      =>  '{items}',
                    'itemView'      =>  '_item_index_hotGroup',
                    'separator'     =>  '<hr class="separator" style="margin:20px 0;">',
                    'emptyText'     => Yii::t('app', '暂时没有小组')
                )
            ); ?>
        </div>

    </div>
</div>

