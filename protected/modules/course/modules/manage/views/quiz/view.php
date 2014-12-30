<?php
$this->course = $course;
$this->breadcrumbs =  
 				array($course->name=>array('/course/index/view','id'=>$lesson->course->id), 
    			Yii::t('app',"课时管理")=>array('lesson/index','courseId'=>$lesson->courseId), 
    			Yii::t('app',"编辑测试")); 
?>
		<h3 class="side-lined"><?php echo Yii::t('app','编辑测试');?></h3>
		<?php echo CHtml::link('<i class="icon-plus icon-white"></i>'.Yii::t('app','多项选择'),array('question/create','quizId'=>$quiz->id,'type'=>'multiple-choice'),array('class'=>'btn btn-success   mr10'));
		?>
				<?php echo CHtml::link('<i class="icon-plus icon-white"></i>'.Yii::t('app','单项选择'),array('question/create','quizId'=>$quiz->id,'type'=>'single-choice'),array('class'=>'btn btn-success   mr10'));
		?>

<div class="dxd-lession-order-list">
<?php 
$questions = $questionDataProvider->getData();
$sortItems = array();
foreach($questions as $item){
	$sortItems["$item->id"] =$this->renderPartial('_question_item',array('data'=>$item,'course'=>$course),true);
}
$this->widget('zii.widgets.jui.CJuiSortable', 
				array('id'=>'orderList',
						
						'items'=>$sortItems,
						'options'=>array('delay'=>100,
								 'disableSelection'=>true,								
                        		 'cursor'=>'move',
								'stop'=>"js:function(){
                        $.post('".$this->createUrl('question/order')."',
                                {'order':$('.ui-sortable').sortable('toArray').toString()}                                               
                        );}"
				)));
?>

	</div>


