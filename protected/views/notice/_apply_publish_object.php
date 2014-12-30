<?php
/* @var $this NoticeController */
/* @var $data Notice */
//$model = Course::model()->with('user')->findByPk($data['courseId']);
$model = DxdUtil::type2Model($data['objectType'])->findByPk($data['objectId']);
if(!$model) return false;
?>


	<?php
	 echo $model->user->name; echo Yii::t('app',"申请发布"); echo CHtml::link($model->name,array("/".$data['objectType']."/view",'id'=>$data['objectId']));?>
