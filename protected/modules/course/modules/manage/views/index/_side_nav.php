<div style="margin-top: 20px">

<?php
	$this->widget('booster.widgets.TbMenu', array(
    'type'=>'list',
    'items'=>array(
				   array('label'=>Yii::t('app','课程信息')),
				   array('label'=>Yii::t('app','基本信息'),'url'=>array('index/setBasic','id'=>$course->id)),
				   array('label'=>Yii::t('app','封面图片'),'url'=>array('index/uploadFace','id'=>$course->id)),
				   array('label'=>Yii::t('app','详细信息'),'url'=>array('index/setDetail','id'=>$course->id)),
				   array('label'=>Yii::t('app','价格设置'),'url'=>array('index/setFee','id'=>$course->id)),

				   array('label'=>Yii::t('app','内容管理')),
				   array('label'=>Yii::t('app','课时管理'),'url'=>array('lesson/index','courseId'=>$course->id)),
				   array('label'=>Yii::t('app','订单列表'),'url'=>array('order/admin','courseId'=>$course->id)),
                   array('label'=>Yii::t('app','公告管理'), 'url'=>array('announcement/index', 'courseId'=>$course->id)),

				   array('label'=>Yii::t('app','分析')),
				   array('label'=>Yii::t('app','测验分析'),'url'=>array('quizReport/index','courseId'=>$course->id)),

				   array('label'=>Yii::t('app','成员管理'),'url'=>array('index/members','id'=>$course->id)),
				   ),
	));
?>
</div>
