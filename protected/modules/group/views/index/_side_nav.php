<div class="dxd-side-nav">
		<?php $this->widget('booster.widgets.TbMenu', array(
    'type'=>'list',
    'items'=>array(
					//array('label'=>'课堂专区','url'=>"#"),
					array('label'=>Yii::t('app','我的小组'),'url'=>array('my'),'visible'=>!Yii::app()->user->isGuest),
					array('label'=>Yii::t('app','最新 & 热门'),'url'=>'#'),
					
					))); ?>

<p style="font-size:1.3em;margin-top:10px;" class="muted"><?php echo Yii::t('app','分类');?></p>
		<?php $this->widget('booster.widgets.TbMenu', array(
    'type'=>'list',
    'items'=>Group::model()->getCategoryItems(),
)); ?>
	
<br/>
<?php	 echo CHtml::link(Yii::t('app','+创建小组'),array('group/create'));?>

</div>
