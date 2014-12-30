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
        array('label'=>Yii::t('app','按学生'), 'url'=>array('view','quizId'=>$quiz->id)),
        array('label'=>Yii::t('app','按题目'), 'url'=>array('questions','quizId'=>$quiz->id),'active'=>true),
    ),
)); ?>

<p><span class="text-error"><?php echo Yii::t('app','提示：');?></span><?php echo Yii::t('app','点击表头，可对表格数据进行排序');?></p>

<?php $this->widget('booster.widgets.TbGridView', array(
    'type'=>'striped bordered condensed',
    'dataProvider'=>$questionReportDataProvider,
    'template'=>"{items}",
    'columns'=>array(
      //  array('name'=>'id', 'header'=>'#'),
   //      array('name'=>'question.weight', 
       //  	'type'=>'raw',
        // 	'value'=>'CHtml::link($data->lesson->title,array("/course/lesson/view","id"=>$data->lesson->id))',
     //    	'header'=>'标题'),
        array('name'=>'questionId', 'header'=>Yii::t('app','题目'),'value'=>Yii::t('app','第 {num} 题',array("{num}"=>$data->question->weight))),
        array('name'=>'correctRate', 
         	'type'=>'raw',
       		'value'=>'round($data->correctRate,2)',
         	'header'=>Yii::t('app','完全正确')),
             array('name'=>'partialCorrectRate', 
         	'type'=>'raw',
       		'value'=>'round($data->partialCorrectRate,2)',
         	'header'=>Yii::t('app','部分正确')),
         	 array('name'=>'wrongRate', 
         	'type'=>'raw',
       		'value'=>'round($data->wrongRate,2)',
         	'header'=>Yii::t('app','错误')),
        array('name'=>'aNum', 
         	'type'=>'raw',
       		'value'=>array($this,'getQuestionColumn'),
         	'header'=>'A'),
        array('name'=>'bNum', 
         	'type'=>'raw',
        	'value'=>array($this,'getQuestionColumn'),
         	'header'=>'B'),
         array('name'=>'cNum', 
         	'type'=>'raw',
        	'value'=>array($this,'getQuestionColumn'),
         	'header'=>'C'),
        array('name'=>'dNum', 
         	'type'=>'raw',
        	'value'=>array($this,'getQuestionColumn'),
         	'header'=>'D'),
        array('name'=>'eNum', 
         	'type'=>'raw',
        	'value'=>array($this,'getQuestionColumn'),
         	'header'=>'E'),  
        array('name'=>'fNum', 
         	'type'=>'raw',
        	'value'=>array($this,'getQuestionColumn'),
         	'header'=>'F'),     
/*        array(
            'class'=>'booster.widgets.TbButtonColumn',
            'htmlOptions'=>array('style'=>'width: 50px'),
        ),*/
    ),
)); 
?>
