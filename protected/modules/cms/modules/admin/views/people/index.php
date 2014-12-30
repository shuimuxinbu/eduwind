<?php
/* @var $this TeacherController */
/* @var $dataProvider CActiveDataProvider */

$this->breadcrumbs=array(
	'Teachers',
);

$this->menu=array(
	array('label'=>'Create Teacher', 'url'=>array('create')),
	array('label'=>'Manage Teacher', 'url'=>array('admin')),
);
?>

            <h3 class="side-lined">人员管理</h3>
            <!-- 添加人员 -->
            <?php echo CHtml::link('添加人员', array('create'), array('class'=>'btn btn-primary')); ?>
			<?php echo CHtml::link('管理分类', array('category'), array('class'=>'btn ')); ?>

			<div>
            <!-- 人员列表 -->
            <?php
            $this->widget(
                'booster.widgets.TbGridView',
                array(
                    'id'                =>  'grid-teacher',
                    'dataProvider'      =>  $model->search(),
                    'filter'            =>  $model,
                    'columns'           =>  array(
                        'user.id',
                        'name',
                        'user.email',
                        'user.name',
                        'category.name',
                        array(
                            'class' =>  'booster.widgets.TbButtonColumn',
                            'template'  =>  '{face} {update} {delete}',
                            'buttons'   =>  array(
                                'face'  =>  array(
                                    'label'     =>  '<i class="glyphicon glyphicon-picture"></i>',
                                    'options'   =>  array('title'=>'封面图'),
                                    'url'       =>  'YII::app()->getController()->createUrl("uploadFace", array("id"=>$data->id))',
                                ),
                            ),
                        ),
                    ),
                )
            );
            ?>
        </div>
