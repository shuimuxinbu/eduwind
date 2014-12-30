<div class="panel-post">
    <?php $this->widget(
        'booster.widgets.TbListView',
        array(
            'dataProvider'  =>  $dataProvider,
            'template'      =>  '{items} {pager}',
            'itemView'      =>  '_index_item_post',
            'separator'     =>  '<div class="separator"></div>',
            'id'            =>  'panel-post'
        )
    ); ?>
</div>
