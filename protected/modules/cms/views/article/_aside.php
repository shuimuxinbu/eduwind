<div style="border-bottom:1px solid #e99061;margin-bottom:0px;">
    <div class="tag pull-left"><?php echo Yii::t('app','热点新闻');?></div>
    <div class="clearfix"></div>
</div>
<div style="background-color:#FAFAFA; padding:10px 20px;">
 <?php $this->widget('booster.widgets.TbListView', array(
        'dataProvider'  =>  $hotArticleDataProvider,
        'itemView'      =>  '_hot_article_item',
        'template'      =>  '{items}',
)); ?>           
</div>
