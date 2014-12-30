<div class="pull-right hidden-sm hidden-xs">
    <span class="score"><?php echo $model->rateScore; ?><?php echo Yii::t('app', '分'); ?></span>
    <?php $this->widget('ext.jiathis.JiaThis'); ?>
</div>
<?php echo CHtml::link(Yii::t('app', '课时列表'), array('index/view', 'id'=>$model->id), array('class'=> $this->action->id === 'view' ? 'active' : '')); ?>
<?php echo CHtml::link(Yii::t('app', '课程评价'), array('index/viewRate', 'id'=>$model->id), array('class'=> $this->action->id === 'viewRate' ? 'active' : '')); ?>
<?php echo CHtml::link(Yii::t('app', '课程讨论'), array('post/index', 'courseId'=>$model->id), array('class'=> $this->action->id === 'index' ? 'active' : '')); ?>

<div class="clearfix"></div>
