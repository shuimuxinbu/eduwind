<?php
/* @var $this GroupController */
/* @var $dataProvider CActiveDataProvider */

?>
<div class="row">
<div class="col-sm-9">
<div style="margin-top: 18px;">
<div style="font-size:24.5px;line-height:36px;font-weight:bold;display:inline-block;"><?php echo Yii::t('app','小组列表')?></div>
		<?php
$items=array(array('label'=>Yii::t('app','全部'),'url'=>array('group/category','id'=>0)));
$items=array_merge_recursive($items,Group::model()->getCategoryItems());
		$this->widget('booster.widgets.TbMenu', array(
    'type'=>'pills',
    'items'=>$items,
	'htmlOptions'=>array('class'=>'pull-right','style'=>'margin-bottom:15px;'),
)); ?>
<div class="clearfix"></div>
</div>
	<?php $this->widget('booster.widgets.TbThumbnails', array(
	    'dataProvider'=>$dataProvider,
	    'template'=>"{items}\n{pager}",
	    'itemView'=>'_card'
	)); ?>
</div>
 
<div class="col-sm-3" style="padding-top:25px">
<?php if($myGroupDataProvider):?>
	<div><?php echo Yii::t('app','我的小组')?></div>
	<hr style="margin: 15px 0"/>
	<div>
		<?php $this->widget('booster.widgets.TbThumbnails', array(
	    'dataProvider'=>$myGroupDataProvider,
	    'template'=>"{items}\n{pager}",
		'emptyText'=>false,
	    'itemView'=>'_item'
	)); ?>
	</div>
	<br/>
<?php endif;?>

	<div><?php echo Yii::t('app','热门话题')?></div>
	<hr style="margin: 15px 0"/>
				<?php 
				$this->widget('booster.widgets.TbListView', array(
				    'dataProvider'=>$postDataProvider,
				    'itemView'=>'_index_post_item',   // refers to the partial view named '_post'
					'summaryText'=>false,
					'template'=>'{items}',
					'separator' => '<div style="margin:10px 0;"> </div>',
					'emptyText'=>Yii::t('app','暂时还没有人发帖'),
				));
				?>
<br/>
 <?php echo CHtml::link(Yii::t('app','+申请创建小组'),array('group/create'));?>
</div>

</div>


