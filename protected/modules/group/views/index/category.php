<?php ?>
<div class="row" style="margin-top:30px;">
<div class="col-sm-12">
<div class="pull-left mr15 light-green" style="font-size:1.2em;line-height:32px;"><?php echo Yii::t('app','分类');?></div>
	<div class="course-category-tabs">
	<?php
	$firstCategoryItems = array();
	$firstCategoryItems[] = array('label'=>Yii::t('app','全部'),'url'=>array('index','categoryId'=>0),'active'=>(empty($category)));
	foreach($firstCategories as $item){
		$firstCategoryItems[] = array('label'=>$item->name,'url'=>array('category','categoryId'=>$item->id),'active'=>($categoryId==$item->id));
	}
	$this->widget('booster.widgets.TbMenu', array(
	    'type'=>'pills', // '', 'tabs', 'pills' (or 'list')
	    'stacked'=>false, // whether this is a stacked menu
	    'items'=>$firstCategoryItems
	)); ?>
	</div>
</div>

</div>

<div class="row">
	<div class="col-sm-12">
			<?php 	
			$this->widget('booster.widgets.TbThumbnails', array(
			    'dataProvider'=>$dataProvider,
				'template'=>"{items}",
			    'itemView'=>'_group_item',
			    'emptyText'=>Yii::t('app','暂时还没有该类小组')
			)); 
		?>	
	</div>
</div>

<div class="row">
	<div class="col-sm-12" >
		<?php echo CHtml::link('+&nbsp;'.Yii::t('app','申请创建小组'),array('create'),array('class'=>'create-group-bar'));?>
	</div>
</div>
