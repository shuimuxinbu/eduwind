<?php
/* @var $this ContactController */
/* @var $dataProvider CActiveDataProvider */

?>

<div class="row">
	<div class="col-sm-2">
		<?php $this->renderPartial("/default/_sidenav");?>
	</div>
	<div class="col-sm-10">
		<h3 class="side-lined">分类管理</h3>

		<?php $this->widget('booster.widgets.TbMenu', array(
    'type'=>'pills', // '', 'tabs', 'pills' (or 'list')
    'stacked'=>false, // whether this is a stacked menu
    'items'=>array(
        array('label'=>'课程', 'url'=>array('index','type'=>'course'),'active'=>($type=="course"?true:false)),
        array('label'=>'小组', 'url'=>array('index','type'=>'group'),'active'=>($type=="group"?true:false)),
    ),
)); ?>

<!-- 添加联系人开始 -->
<?php $form = $this->beginWidget('booster.widgets.TbActiveForm', array(
    'id'=>'inlineForm',
    'type'=>'inline',
	'action'=>array('create'),
    'htmlOptions'=>array('class'=>''),
)); ?>

<?php echo $form->textFieldGroup($model, 'name', array('class'=>'mr10')); ?>
<?php //echo $form->textFieldGroup($model, 'weight', array('class'=>'mr10','value'=>"",'placeholder'=>'可填')); ?>

<?php  echo $form->hiddenField($model, 'type', array('value'=>$type)); ?>
<?php $this->widget('booster.widgets.TbButton', array('buttonType'=>'submit', 'label'=>'添加分类')); ?>

<?php $this->endWidget(); ?>
<?php //echo CHtml::link('<i class="icon-plus icon-white"></i>添加分类','#')?>
<div class="clearfix"></div>

<!-- 添加联系人 -->

<?php
	if(Category::model()->count(array('condition'=>'type="'.$type.'"'))>0){
	$model->type=$type;
	$this->widget('booster.widgets.TbGridView', array(
	'id'=>'category-grid',
	'dataProvider'=>$model->search(50),
	'filter'=>$model,
	'columns'=>array(
        array(
           'class' => 'editable.EditableColumn',
           'name' => 'name',
          'filter'=>CHtml::activeTextField($model, 'name',
                 array('placeholder'=>'搜索')),
           'editable' => array(    //editable section
                  'url'        => $this->createUrl('category/update'),
                  'placement'  => 'right',
              )
        ),
        array(
           'class' => 'editable.EditableColumn',
           'name' => 'weight',
        	'filter'=>CHtml::activeTextField($model, 'weight',
                 array('placeholder'=>'搜索')),
           'editable' => array(    //editable section
                  'url'        => $this->createUrl('category/update'),
                  'placement'  => 'right',
              )
        ),
		array(
            'class'=>'booster.widgets.TbButtonColumn',
			'template'=>'{delete}',
	         'htmlOptions'=>array('style'=>''),
		),
	),
));
}else{
echo "暂无分类";
}?>

</div>
