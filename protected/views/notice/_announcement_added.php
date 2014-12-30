<?php 

$announcementId = is_numeric($data) ? $data : $data['announcementId'];
$announcement = Announcement::model()->findByPk($announcementId); 
if($announcement) $course=$announcement->course;
// 如果Announcement 或 Course 不为空则跳过打印Notice
if (empty($announcement) || empty($coure)) return;

echo Yii::t('app','课程 '). CHtml::link($course['name'], array('/course/index/view', 'id'=>$course['id'])) . Yii::t('app',' 发布了新公告 ');
echo CHtml::tag('em',array(),mb_substr($announcement->content, 0,10,'utf8'));

/** 通知详情,暂不使用
echo CHtml::link('&nbsp;&nbsp;&nbsp;[详情]', array('/course/announcement/detail', 'id'=>$announcement['id']), array('onclick'=>'openFancyBox(this);return false;'));
*/
