<div class="main-content group-courses">
    <div class="col-sm-10 center">
        <ul class="thumbnails">
            <?php
            $tab2 = $this->widget('booster.widgets.TbListView', array(
                'dataProvider'=>$dataProvider,
                'itemView'=>'_course_item',
                'summaryText'=>Yii::t('app','共 {page} 页',array("{page}"=>$page)),
                'summaryCssClass'   =>  'pull-right page-jump',
                'pagerCssClass' =>  'pagination group-pagination',
                'template'=>'{items}',
                'emptyText'=>Yii::t('app','还没有收藏课程'),
                'pager' =>  array(
                    'class'         =>  'booster.widgets.TbPager',
                    'header'        =>  '',
                    'nextPageLabel' =>  Yii::t('app','下一页'),
                    'prevPageLabel' =>  Yii::t('app','上一页'),
                    ),
            ));
            ?>
        </ul>
    </div>
</div>

<!-- 分页 -->
<?php 
    $tab2->renderPager();
?>
