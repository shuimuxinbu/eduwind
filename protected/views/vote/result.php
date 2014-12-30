<?php
?>

<?php echo Yii::t('app','{score}票，来自：',array('{score}'=>$score));?>

<?php 
foreach($voteUpers as $voter){?>
<?php echo CHtml::link($voter->name,"#",array('class'=>'muted dxd-username','data-userId'=>$voter->id));?>&nbsp;,
<?php }?>
