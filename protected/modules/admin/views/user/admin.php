<?php
/* @var $this UserController */
/* @var $model UserInfo */

$this->breadcrumbs=array(
	'User Infos'=>array('index'),
	'Manage',
);

$this->menu=array(
	array('label'=>'List UserInfo', 'url'=>array('index')),
	array('label'=>'Create UserInfo', 'url'=>array('create')),
);

Yii::app()->clientScript->registerScript('search', "
$('.search-button').click(function(){
	$('.search-form').toggle();
	return false;
});
$('.search-form form').submit(function(){
	$('#user-info-grid').yiiGridView('update', {
		data: $(this).serialize()
	});
	return false;
});
");
?>

<h3 class="side-lined">用户管理</h3>


<div class="search-form" style="display:none">
<?php $this->renderPartial('_search',array(
	'model'=>$model,
)); ?>
</div><!-- search-form -->

<?php
echo '当前在线用户数：'.$onlineNum;
$this->widget('booster.widgets.TbGridView', array(
	'id'=>'user-info-grid',
	'dataProvider'=>$model->search(),
	'filter'=>$model,
	'columns'=>array(
		'id',
		'email',
		'name',
		//'roles',
		array(
//'header' => 'role',
// 'filter' => CHtml::activeDropDownList($model, 'roles', $model->getRolesAsListData(), array('empty' => '')),
 	'filter'=>false,
		'name' => 'roles',
// 'value' => '$data->getUserRoleName($data->id)',
	'value'=>'$data->getRolesAsString()',
 ),
		array('name'=>'addTime','value'=>'date("Y-m-d H:m:s",$data->addTime)'),
		array('name'=>'upTime','value'=>'date("Y-m-d H:m:s",$data->upTime)'),
		'status',
		/*
		'face',
		*/
		array(
            'class'=>'booster.widgets.TbButtonColumn',
		//	'template'=>'{frozen}{unfrozen}{setAdmin}{unsetAdmin}{update}',
		 	'template'=>'{frozen}{unfrozen}{update}{setRoles}',

            'htmlOptions'=>array('style'=>'width: 60px'),
			'buttons'=>array(
				'frozen'=>array(
					'label'=>'<i class="glyphicon glyphicon-pause"></i>',
           			'url'=>'Yii::app()->getController()->createUrl("toggleFrozened", array("id"=>$data->id))',
            		'visible'=>'$data->status !== "frozened"',
					'options'=>array('title'=>"冻结用户"),
				),
				'unfrozen'=>array(
					'label'=>'<i class="glyphicon glyphicon-play"></i>',
           			'url'=>'Yii::app()->getController()->createUrl("toggleFrozened", array("id"=>$data->id))',
            		'visible'=>'$data->status == "frozened"',
     				'options'=>array('title'=>"解除冻结"),
				//	'htmlOptions'=>array('class'=>'dxd-fancy-elem'),
				),
				'setRoles'=>array(
					'label'=>'<i class="glyphicon glyphicon-user"></i>',
           			'url'=>'Yii::app()->getController()->createUrl("setRoles", array("id"=>$data->id))',
     				'options'=>array('title'=>"设置角色组"),
				),
	/*			'setAdmin'=>array(
					'label'=>'<i class="icon-arrow-up"></i>',
           			'url'=>'Yii::app()->getController()->createUrl("toggleAdmin", array("id"=>$data->id))',
            		'visible'=>'$data->isAdmin == 0',
					'options'=>array('title'=>"设为管理员"),
				),
				'unsetAdmin'=>array(
					'label'=>'<i class="icon-arrow-down"></i>',
           			'url'=>'Yii::app()->getController()->createUrl("toggleAdmin", array("id"=>$data->id))',
            		'visible'=>'$data->isAdmin == 1',
					'options'=>array('title'=>"取消管理员"),
				),*/
			)
		),
))); ?>
