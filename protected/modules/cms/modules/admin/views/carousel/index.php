<?php
/* @var $this CarouselController */
/* @var $dataProvider CActiveDataProvider */

$this->breadcrumbs=array(
	'Carousels',
);

$this->menu=array(
	array('label'=>'Create Carousel', 'url'=>array('create')),
	array('label'=>'Manage Carousel', 'url'=>array('admin')),
);
?>

<h3 class="side-lined">首页轮播图片</h3>
<?php echo CHtml::link('添加图片',array('create'),array('class'=>'btn btn-success'));?>
<br/>
<br/>
<?php /*$this->widget('booster.widgets.TbListView', array(
	'dataProvider'=>$dataProvider,
	'itemView'=>'_view',
	'emptyText'=>'没有图片',
)); */?>

<?php 
$carousels = $dataProvider->getData();
$sortItems = array();
foreach($carousels as $item){
	$sortItems["$item->id"] =$this->renderPartial('_view',array('data'=>$item),true);
}
$this->widget('zii.widgets.jui.CJuiSortable', 
				array('id'=>'orderList',					
						'items'=>$sortItems,
						'options'=>array('delay'=>100,
								 'disableSelection'=>true,								
                        		 'cursor'=>'move',
								'stop'=>"js:function(){
                        $.ajax({
                                type: 'POST',
                                data: {'order':$('.ui-sortable').sortable('toArray').toString()}                                               
                        });}"
				)));
?>
