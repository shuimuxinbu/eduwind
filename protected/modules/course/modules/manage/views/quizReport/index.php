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
        array('label'=>Yii::t('app','测验列表'), 'url'=>array('index','courseId'=>$this->course->id),'active'=>true),
        array('label'=>Yii::t('app','学生答题统计'), 'url'=>array('member','courseId'=>$this->course->id)),
    ),
)); ?>

<?php $this->widget('booster.widgets.TbGridView', array(
    'type'=>'striped bordered condensed',
    'dataProvider'=>$quizDataProvider,
    'template'=>"{items}",
    'columns'=>array(
      //  array('name'=>'id', 'header'=>'#'),
        array('name'=>'lesson.title',
        	'type'=>'raw',
        	'value'=>'CHtml::link($data->lesson->title,array("view","quizId"=>$data->id))',
        	'header'=>Yii::t('app','标题')),
        array('name'=>'questionNum', 'header'=>Yii::t('app','题数')),
        array('name'=>'reportCount', 'header'=>Yii::t('app','作答人数')),
         array('name'=>'avgScore', 'header'=>Yii::t('app','平均分'),'value'=>'round($data->avgScore,2);'),
/*        array(
            'class'=>'booster.widgets.TbButtonColumn',
            'htmlOptions'=>array('style'=>'width: 50px'),
        ),*/
    ),
));
?>
