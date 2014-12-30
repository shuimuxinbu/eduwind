
<h3 class="dxd-fancybox-header"><?php echo Yii::t('app','设置用户组');?></h3>
<div class="dxd-fancybox-body">
<div class="form">

<?php
$form=$this->beginWidget('booster.widgets.TbActiveForm', array(
	'id'=>'group-form',
	'enableAjaxValidation'=>false,
)); ?>


    <?php echo $form->checkBoxListGroup($member, 'arrRoles',$roleItems); ?>
    <br/>
    <br/>
	<div class="row buttons">
<?php $this->widget('booster.widgets.TbButton',
					array('label'=>Yii::t('app','保存'),'buttonType'=>'submit','context'=>'primary',
					'htmlOptions'=>array('class'=>'pull-right'))
					);?>
	<div class="clearfix"></div>
	</div>

<?php $this->endWidget(); ?>

</div><!-- form -->
</div>

<div class="dxd-fancybox-footer">
</div>
