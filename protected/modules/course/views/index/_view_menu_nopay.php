<?php echo CHtml::link(Yii::t('app', '课时列表'), array('index/view', 'id'=>$model->id), array('class'=> $this->action->id === 'view' ? 'active' : '')); ?>
<?php echo CHtml::link(Yii::t('app', '课程评价'), array('index/viewRate', 'id'=>$model->id), array('class'=> $this->action->id === 'viewRate' ? 'active' : '')); ?>123
