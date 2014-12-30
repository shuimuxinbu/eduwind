<div style="margin-top: 40px;border-right:1px solid #ddd;padding-bottom:200px;" >
    <?php $this->widget('booster.widgets.TbMenu', array(
        'type'=>'list',
        'encodeLabel'=>false,
        'items'=>array(
            array('label'=>'文章'),
            array('label'=>'文章列表', 'icon'=>'th', 'url'=>array('index')),
            array('label'=>'分类'),
            array('label'=>'分类管理', 'icon'=>'plus', 'url'=>array('category')),
        ),
    )); ?>
</div>
