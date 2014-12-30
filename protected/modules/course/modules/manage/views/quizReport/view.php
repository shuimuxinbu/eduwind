<?php 
$this->breadcrumbs =  
 				array($this->course->name=>array('/course/index/view','id'=>$this->course->id), 
 				      Yii::t('app',"测验分析")=>array('index','courseId'=>$this->course->id), 
 				$quiz->lesson->title); 
?>
		<h3 class="side-lined"><?php echo Yii::t('app','测验分析');?></h3>
<p>
<?php echo CHtml::link('<i class="icon-chevron-left"></i>'.Yii::t('app','返回'),array('index','courseId'=>$this->course->id),array('class'=>'btn'));?>
</p>
<?php $this->widget('booster.widgets.TbMenu', array(
    'type'=>'pills', // '', 'tabs', 'pills' (or 'list')
    'stacked'=>false, // whether this is a stacked menu
    'items'=>array(
        array('label'=>Yii::t('app','按学生'), 'url'=>array('view','quizId'=>$quiz->id),'active'=>true),
        array('label'=>Yii::t('app','按题目'), 'url'=>array('questions','quizId'=>$quiz->id)),
    ),
)); ?>
<p><span class="text-error"><?php echo Yii::t('app','提示：')?></span><?php echo Yii::t('app','点击表头，可对表格数据进行排序');?></p>

<?php $this->widget('booster.widgets.TbGridView', array(
    'type'=>'striped bordered condensed',
    'dataProvider'=>$quizReportDataProvider,
    'template'=>"{items}",
    'columns'=>array(
        array('name'=>'user.name', 'header'=>Yii::t('app','姓名')),
        array('name'=>'responses', 
        	'type'=>'raw',
        	'value'=>array($this,'getReportColumn'),
        	'header'=>Yii::t('app','回答')),
//        array('name'=>'correctNum', 'header'=>'正确'),
 //       array('name'=>'partialCorrectNum', 'header'=>'部分正确'),
 //       array('name'=>'partialCorrectNum', 'header'=>'错误'), 
         array('name'=>'score', 'header'=>Yii::t('app','得分'),'value'=>'round($data->score,2);'),
/*        array(
            'class'=>'booster.widgets.TbButtonColumn',
            'htmlOptions'=>array('style'=>'width: 50px'),
        ),*/
    ),
)); 
?>
