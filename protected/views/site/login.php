<?php
/* @var $this SiteController */
/* @var $model LoginForm */
/* @var $form CActiveForm  */

$this->pageTitle=Yii::app()->name . ' - Login';
$this->breadcrumbs=array(
	'Login',
);
?>


<div class="col-sm-4 center " style="margin-top:60px">
<h2 style="text-align:center"><?php echo Yii::t('app','登陆'); Yii::app()->params['settings']['site']['name'];?></h2>
<?php $this->renderPartial("_login_form",array('model'=>$model));?>
</div><!-- form -->
