<?php
/* @var $this GroupController */
/* @var $dataProvider CActiveDataProvider */

?>
<div class="row">
 
<div class="col-sm-2" style="padding-top:25px">
<?php echo $this->renderPartial('_side_nav');?>
</div>


<div class="col-sm-10">
	<h3 class="side-lined"><?php echo ((isset($topic))?$topic: Yii::t('app','最新小组'));?></h3>	<?php $this->widget('booster.widgets.TbThumbnails', array(
	    'dataProvider'=>$hotDataProvider,
	    'template'=>"{items}\n{pager}",
	    'itemView'=>'_card'
	)); ?>
	
	<h3 class="side-lined"><?php echo ((isset($topic))?$topic:Yii::t('app','热门小组'));?></h3>	<?php $this->widget('booster.widgets.TbThumbnails', array(
	    'dataProvider'=>$hotDataProvider,
	    'template'=>"{items}\n{pager}",
	    'itemView'=>'_card'
	)); ?>
</div>

</div>


