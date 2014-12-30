<h3 class="side-lined">页面管理</h3>
<?php $this->renderPartial('_head_nav'); ?>
<br>

<div class="dxd-lession-order-list">
    <?php
    $categorys = Page::model()->getCategorys(array());
    foreach ($categorys as $category) {
        echo '<div class="wrapper-page">';
        // 分类头部
        echo '<div class="head">';
        echo $category->name;
        echo CHtml::link('+ 添加单页', array('create','categoryId'=>$category->id), array('class'=>'pull-right'));
        echo '</div>';
        // echo "<div id='$category->id>"

        // 分类数据
      //  $pageDataProvider = Page::model()->getDataProviderByCategory($category->id,100);
       // $pages = $pageDataProvider->getData();
        $criteria = new CDbCriteria;
        $criteria->condition = "categoryId=".$category->id;
        $criteria->order = 'weight asc';
        $pages = Page::model()->findAll($criteria);
        $sortItems = array();
        foreach($pages as $page){
             $sortItems["page-$page->id"] =$this->renderPartial('_page_item',array('data'=>$page),true);
        }
        $this->widget('zii.widgets.jui.CJuiSortable',
                array('id'=>'order_list_'.$category->id,
                        'items'=>$sortItems,
                        'options'=>array('delay'=>100,
                                 'disableSelection'=>true,
                                 'cursor'=>'move',
                                //'placeholder'=>'sortable-placeholder',
                                'stop'=>"js:function(){
                        $.post('".$this->createUrl('order',array('categoryId'=>$category->id))."'
                                ,{'order':$('.ui-sortable').sortable('toArray').toString()}
                        );}"
                )));
        // $this->widget(
        //     'booster.widgets.TbListView',
        //     array(
        //         'dataProvider'  =>  $pageDataProvider,
        //         'itemView'      =>  '_page_item',
        //         'template'      =>  '{items}',
        //         'id'            =>   'order_list'.$category->id,
        //         'htmlOptions'   =>  array('class'=>'body list-view'),
        //         'itemsTagName'  =>  'ul',
        //     )
        // );
        echo '</div>';


    }
    ?>
</div>
<?php


?>

<style type="text/css">
.wrapper-page {
    margin-bottom: 20px;
}
.wrapper-page .head {
    padding: 6px 10px;
    border: 1px solid #ddd;
    margin-bottom: 10px;
}
.wrapper-page .body {
    line-height: 1.5em;
}
</style>
