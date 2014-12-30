<?php
/* @var $this CourseController */
/* @var $dataProvider CActiveDataProvider */

?>
<div class="row ">
<div class="col-sm-2 dxd-course-category">
<?php $this->renderPartial('_side_nav');?>
</div>
	<div class="col-sm-10">
	<div>
		<div class="pull-left">
		<h3 class=""><?php echo $category->name;?><?php echo Yii::t('app','课程')?></h3>
		</div>
		<div class="pull-right mb10">
		<?php $this->widget('booster.widgets.TbMenu', array(
		    'type'=>'pills', // '', 'tabs', 'pills' (or 'list')
		    'stacked'=>false, // whether this is a stacked menu
		    'items'=>array(
		        array('label'=>Yii::t('app','最新'), 'url'=>array('course/category','id'=>$category->id,'sort'=>'new'),'active'=>($sort=='new'?true:false)),
		        array('label'=>Yii::t('app','最热'), 'url'=>array('course/category','id'=>$category->id,'sort'=>'hot')),
		        
		    ),
		    'htmlOptions'=>array(
		    	'style'=>'margin-top:8px;'
		    ),
		)); ?>
		</div>
		<div class="clearfix"></div>
	</div>
	<?php $this->widget('booster.widgets.TbThumbnails', array(
	    'dataProvider'=>$dataProvider,
	    'template'=>"{items}\n{pager}",
	    'itemView'=>'_card',
		'enableSorting'=>true,
		'sortableAttributes'=>array('addTime'),
		'afterAjaxUpdate'=>'js:function(id,data) {             
            $("span[id^=\'rating\'] > input").rating({"readOnly":true});
        }'
	)); ?>
	</div>
</div>

