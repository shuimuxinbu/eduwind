<?php
$this->breadcrumbs =
 				array($this->course->name=>array('/course/index/view','id'=>$this->course->id),
    			Yii::t('app',"测验分析"));
?>
		<h3 class="side-lined"><?php echo Yii::t('app','测验分析');?></h3>

<?php $this->widget('booster.widgets.TbMenu', array(
    'type'=>'pills', // '', 'tabs', 'pills' (or 'list')
    'stacked'=>false, // whether this is a stacked menu
    'items'=>array(
        array('label'=>Yii::t('app','测验列表'), 'url'=>array('index','courseId'=>$this->course->id)),
        array('label'=>Yii::t('app','学生答题统计'), 'url'=>array('member','courseId'=>$this->course->id), 'active'=>true),
    ),
)); ?>
<p><span class="text-error"><?php echo Yii::t('app','提示：');?></span><?php echo Yii::t('app','点击表头，可对表格数据进行排序');?></p>

<?php $this->widget('booster.widgets.TbGridView', array(
    'type'=>'striped bordered condensed',
    'dataProvider'=>$courseQuizReportDataProvider,
    'template'=>"{items}",
    'columns'=>array(
        array('name'=>'user.name', 'header'=>Yii::t('app','学生')),
        array('name'=>'totalScore', 'header'=>Yii::t('app','总分')),
        array('name'=>'avgScore','header'=>Yii::t('app','平均分')),
        array('name'=>'quizNum', 'header'=>Yii::t('app','完成测验数')),
    ),
));
?>
