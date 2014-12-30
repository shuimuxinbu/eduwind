<?php
/* @var $this PostController */
/* @var $model Post */
 
/* $this->widget('booster.widgets.TbBreadcrumbs', array(
    'links'=>array($post->group->name=>array('group/view','id'=>$post->group->id), 
 				//	'讨论区'=>array('post/index','groupid'=>$post->groupid),
 					$post->title),
 	'homeLink'=>false)); 
*/
$this->pageTitle = $question->title;
 Yii::app()->clientScript->registerMetaTag(mb_substr(strip_tags($question->description),0,200,'utf8')."...", 'description');
 ?>
<div class="row dxd-group-body">
	<div class="col-sm-9 dxd-left-col">
		<?php $this->renderPartial('/question/view',array('question'=>$question))?>
	</div>
	<div class="col-sm-3 dxd-right-col" style="padding-top:20px">
	<?php echo CHtml::link(Yii::t('app','<  返回').$model->name,array('group/view','id'=>$model->id));?>
	
		<div>
		<br/>

	</div>
	</div>
</div>

<style type="text/css">
.dxd-right-col{
padding-top:40px;
}
</style>

