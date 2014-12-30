<?php
/* @var $this UserController */
/* @var $model UserInfo */
$this->pageTitle = Yii::app()->name."-".Yii::t('app',"注册");
?>

<h2 class="text-center"><?php echo Yii::t('app','欢迎加入')?><?php echo Yii::app()->params['settings']['site']['name'];?></h2>
<hr/>
<div class="row">
	<div class="col-sm-4 col-sm-offset-4" style="margin-top:20px;">

			<div class="pull-right" style="margin-bottom: 30px;">

		<?php
			$this->renderPartial('_oauth');
		?>
		</div>
		<div class="clearfix"></div>

<?php echo $this->renderPartial('_register_form', array('model'=>$model)); ?>

	</div>


</div>

