<h3 class="side-lined">导航栏设置</h3>
<div class="mb10">
<?php echo CHtml::link('<i class="icon-plus icon-white"></i>添加栏目',array('create'),array('class'=>'btn btn-success'));?>
</div>
<br/>
<div>
<?php 
$pages = $dataProvider->getData();
$sortItems = array();
foreach($pages as $item){
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
</div>