
	
	<?php
/* @var $this NoticeController */
/* @var $data Notice */
$user = UserInfo::model()->findByPk($data['userId']);
if(!$user) return false;

?>


	<?php echo CHtml::link($user->name,$user->pageUrl);?>&nbsp;<?php echo Yii::t('app','关注了你')?>
	