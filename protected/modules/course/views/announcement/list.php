<h3 class="dxd-fancybox-header"><?php echo Yii::t('app','所有公告');?></h3>
<div class="dxd-fancybox-body" style="min-width: 300px">
    <?php
    $widget = $this->widget('booster.widgets.TbListView', array(
        'dataProvider'  =>  $announcementDataProvider,
        'itemView'      =>  '_list_item',
        'template'      =>  '{items}{pager}',
        'id'            =>  'announcement-list',
    	'separator'	=>'<hr style="margin:15px 0;"/>',
    ));
    ?>
</div>
<div class="dxd-fancybox-footer"> </div>
