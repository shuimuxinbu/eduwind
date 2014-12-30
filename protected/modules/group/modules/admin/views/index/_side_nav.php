<div style="margin-top: 40px;border-right:1px solid #ddd;padding-bottom:200px;" >

<?php
	$this->widget('booster.widgets.TbMenu', array(
    'type'=>'list',
	'encodeLabel'=>false,
    'items'=>array(
				   array('label'=>'小组列表','icon'=>'th','url'=>array('index/index')),
				   array('label'=>'小组分类','icon'=>'th','url'=>array('category/index')),
				   ),
	)); 
?>
</div>
