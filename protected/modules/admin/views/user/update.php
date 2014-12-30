<?php
/* @var $this UserController */
/* @var $model UserInfo */
?>

<h1>修改用户信息</h1>
<p>用户ID：<?php echo $model->id;?></p>
<p>用户名：<?php echo $model->name;?></p>

<?php echo $this->renderPartial('_form', array('model'=>$model)); ?>