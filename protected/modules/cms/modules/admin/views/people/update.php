<?php
/* @var $this TeacherController */
/* @var $model Teacher */

$this->breadcrumbs=array(
	'Teachers'=>array('index'),
	'Create',
);

$this->menu=array(
	array('label'=>'List Teacher', 'url'=>array('index')),
	array('label'=>'Manage Teacher', 'url'=>array('admin')),
);
?>


            <h3 class="side-lined">修改人员信息</h3>
            <?php $this->renderPartial('_form', array('model'=>$model)); ?>
