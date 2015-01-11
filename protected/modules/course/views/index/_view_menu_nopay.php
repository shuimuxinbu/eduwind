<div class="pull-right hidden-sm hidden-xs">
    <span class="score"><?php echo $model->rateScore; ?><?php echo Yii::t('app', '分'); ?></span>
    <?php $this->widget('ext.jiathis.JiaThis', array('line'=>1)); ?>
</div>

<?php echo CHtml::link(Yii::t('app', '课时列表'), array('index/view', 'id'=>$model->id), array('class'=> $this->action->id === 'view' ? 'active' : '')); ?>
<?php echo CHtml::link(Yii::t('app', '课程评价'), array('index/viewRate', 'id'=>$model->id), array('class'=> $this->action->id === 'viewRate' ? 'active' : '')); ?>123
