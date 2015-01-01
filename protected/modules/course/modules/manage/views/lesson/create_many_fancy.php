<h3 class="dxd-fancybox-header"><?php echo Yii::t('app','导入外部视频');?></h3>
<div class="dxd-fancybox-body">
	 <ul class="nav nav-tabs">
	    <li class="active"><a href="#tab1" data-toggle="tab"><?php echo Yii::t('app','批量导入视频');?></a></li>
	  </ul>
	  <div class="tab-content">
	    <div class="tab-pane active" id="tab1">
  		<h3><?php echo Yii::t('app','支持从优酷导入视频');?></h3>
  	    	    <?php /** @var BootActiveForm $form */
			$form = $this->beginWidget('booster.widgets.TbActiveForm', array(
			    'id'=>'horizontalForm2',
				'action'=>array('createMany','courseId'=>$course->id),
			)); ?>
			<div class="form-group">
				<input type="text" name="playList" placeHolder="<?php echo Yii::t('app','请输入优酷专辑地址');?>" class="input-block-level form-control"/>
			</div>
			<div class="buttons">
				<?php $this->widget('booster.widgets.TbButton',
					array('label'=>Yii::t('app','提交'),'buttonType'=>'submit','context'=>'primary',
					'htmlOptions'=>array('class'=>'pull-right'))
					);?>
	<div class="clearfix"></div>
	</div>
			<?php $this->endWidget(); ?>

		</div>

	  </div>
</div>

<div class="dxd-fancybox-footer">
</div>

