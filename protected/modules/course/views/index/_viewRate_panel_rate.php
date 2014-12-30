<div class="panel-rate">
    <?php $this->widget(
        'booster.widgets.TbListView',
        array(
            'dataProvider'  =>  $rateDataProvider,
            'template'      =>  '{items} {pager}',
            'itemView'      =>  '_view_item_rate',
            'separator'     =>  '<div class="separator"></div>',
            'id'            =>  'form-rate',
        )
    ); ?>
</div>
