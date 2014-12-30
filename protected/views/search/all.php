<?php
/* @var $this CourseController */
/* @var $dataProvider CActiveDataProvider */

?>
<div class="row ">
<?php

?>
	<div class="col-sm-2">
		<?php $this->renderPartial('_side_nav',array('keyword'=>$keyword));?>
	</div>
	<div class="col-sm-10">

	<?php $this->renderPartial('_form',array('cate'=>'all','keyword'=>$keyword))?>

	<?php $totalCount =
						$courseDataProvider->totalItemCount
						+$postDataProvider->totalItemCount
	//					+$questionDataProvider->totalItemCount
						+$groupDataProvider->totalItemCount
						+$userDataProvider->totalItemCount;?>
	<h5><?php echo Yii::t('app','搜索');?> "<em><b><?php echo CHtml::link($keyword,"#");?>"</b></em> <?php echo Yii::t('app','共得{totalCount}条结果',array('{totalCount}'=>$totalCount))?></h5>

	<h4><?php echo Yii::t('app','课程'); echo CHtml::link("<em>  ".Yii::t('app','更多')."</em>",array('index', 'type'=>'course', 'keyword'=>$keyword),array('style'=>'font-size:0.8em'))?></h4>
	<hr style="margin:0px 0px 20px 0"/>
	<?php $this->widget('booster.widgets.TbListView', array(
	    'dataProvider'=>$courseDataProvider,
	    'template'=>"{items}",
	    'itemView'=>'_course',
		'separator'=>'<div style="margin: 20px 0"></div>',
			'viewData'=>array('keyword'=>$keyword),
		'emptyText'=>Yii::t('app',"没有找到相关课程")
	)); ?>
	<br/>

	<h4><?php echo Yii::t('app','讨论'); echo CHtml::link("<em>  ".Yii::t('app','更多')."</em>",array('index', 'type'=>'post','keyword'=>$keyword),array('style'=>'font-size:0.8em'))?></h4>
	<hr style="margin:0px 0px 20px 0"/>
	<?php $this->widget('booster.widgets.TbListView', array(
	    'dataProvider'=>$postDataProvider,
	    'template'=>"{items}",
	    'itemView'=>'_post',
		'separator'=>'<div style="margin: 20px 0"></div>',
			'viewData'=>array('keyword'=>$keyword),
		'emptyText'=>Yii::t('app',"没有找到相关讨论")
			)); ?>

	<br/>

	<h4><?php echo Yii::t('app','用户'); echo CHtml::link("<em>  ".Yii::t('app','更多')."</em>",array('index', 'type'=>'user', 'keyword'=>$keyword),array('style'=>'font-size:0.8em'))?></h4>
	<hr style="margin:0px 0px 20px 0"/>
	<?php $this->widget('booster.widgets.TbListView', array(
	    'dataProvider'=>$userDataProvider,
	    'template'=>"{items}",
	    'itemView'=>'_user',
		'separator'=>'<div style="margin: 20px 0"></div>',
			'viewData'=>array('keyword'=>$keyword),
		'emptyText'=>Yii::t('app',"没有找到相关用户")
		)); ?>
	<br/>

	<h4><?php echo Yii::t('app','小组'); echo CHtml::link("<em>  ".Yii::t('app','更多')."</em>",array('index', 'type'=>'group', 'keyword'=>$keyword),array('style'=>'font-size:0.8em'))?></h4>
	<hr style="margin:0px 0px 20px 0"/>
	<?php $this->widget('booster.widgets.TbListView', array(
	    'dataProvider'=>$groupDataProvider,
	    'template'=>"{items}",
	    'itemView'=>'_group',
		'separator'=>'<div style="margin: 20px 0"></div>',
			'viewData'=>array('keyword'=>$keyword),
		'emptyText'=>Yii::t('app',"没有找到相关小组")
    )); ?>
    <br>


	<h4><?php echo Yii::t('app','新闻'); echo CHtml::link("<em>  ".Yii::t('app','更多')."</em>",array('index', 'type'=>'article', 'keyword'=>$keyword),array('style'=>'font-size:0.8em'))?></h4>
	<hr style="margin:0px 0px 20px 0"/>
	<?php $this->widget('booster.widgets.TbListView', array(
	    'dataProvider'=>$articleDataProvider,
	    'template'=>"{items}",
	    'itemView'=>'_article',
		'separator'=>'<div style="margin: 20px 0"></div>',
			'viewData'=>array('keyword'=>$keyword),
		'emptyText'=>Yii::t('app',"没有找到相关文章")
		)); ?>

	</div>
</div>

