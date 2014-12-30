<?php
?>

<?php echo Yii::t('app','{voteNum}票，来自：',array('{voteNum}'=>$voteNum));?>
<?php foreach($voteUpers as $voter){?>
<?php echo CHtml::link($voter->username,"#",array('class'=>'muted'));?>&nbsp;,
<?php }?>
