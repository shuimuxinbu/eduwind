<?php

?>

<h3 class="side-lined">用户管理</h3>


<div class="form">

<?php $form=$this->beginWidget('booster.widgets.TbActiveForm', array(
	'id'=>'user-info-form',
	'enableAjaxValidation'=>false,
)); ?>
<?php
if (Yii::app()->user->isSuperuser) {
       $all_roles=new RAuthItemDataProvider('roles', array( 
    'type'=>2,
    ));
      $data=$all_roles->fetchData();
      //var_dump($data);
?>

<?php
}
?>
	<?php echo $form->errorSummary($model); ?>
		<p>为用户<?php echo $model->name;?>分配角色：</p>
		<?php echo $form->checkBoxList($model,'roles',CHtml::listData($data,'name','name'),array('labelOptions'=>array('style'=>'display:inline')
		)); ?>
		
	<div class="row buttons">
		<?php echo CHtml::submitButton(('提交'),array('class'=>'btn btn-primary pull-right')); ?>
	</div>

<?php $this->endWidget(); ?>

</div><!-- form -->
<div>
<p>
注：
<ul>
<li>
admin：整站管理员，具有最高权限，包括进入后台进行管理，以及其他角色具有的全部权限。
</li>
<li>
teacher：教师角色，具有创建课程，并且管理自己所创建课程的权限
</li>
</ul>

</p>
</div>
