<div id="edu-article" class="page-index ew-news">

    <div class="row">
        <div class="col-sm-8">
            <div class="article-menu">
                <?php $this->renderPartial('_nav', array('categorys'=>$categorys)); ?>
            </div>

            <?php $this->widget('booster.widgets.TbListView', array(
                'dataProvider'  =>  $dataProvider,
                'itemView'      =>  '_view',
                'template'      =>  '{items}{pager}',
                'pager' =>  array(
                    'class'         =>  'booster.widgets.TbPager',
                    'header'        =>  '',
                    'nextPageLabel' =>  Yii::t('app','下一页'),
                    'prevPageLabel' =>  Yii::t('app','上一页'),
                    'maxButtonCount'=>  5,
                ),
                'separator'     =>  '<hr style="border-top:none; border-bottom:1px solid #ddd; margin:30px 0px;">',
            )); ?>
        </div>

         <div class="col-sm-4 side" style="margin-top: 20px;">
		<?php $this->renderPartial('_aside',array('hotArticleDataProvider'=>$hotArticleDataProvider));?>
		</div>
    </div>
</div>
