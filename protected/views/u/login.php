<?php
/* @var $this SiteController */
/* @var $model LoginForm */
/* @var $form CActiveForm  */

$this->pageTitle=Yii::app()->name . ' - '.Yii::t('app','登录');

?>

<div class="row">
<div class="col-sm-4 col-sm-offset-4" style="margin-top:60px">
<h2 style="text-align:center"><?php echo Yii::t('app','登陆')?><?php echo Yii::app()->params['settings']['site']['name'];?></h2>
<?php $this->renderPartial("_login_form",array('model'=>$model));?>
</div><!-- form -->
</div>
