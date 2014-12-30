<?php
/* @var $this CourseManageController */
/* @var $dataProvider CActiveDataProvider */
 $this->widget('booster.widgets.TbBreadcrumbs', array(
 	'homeLink'=>false,
    'links'=>array($course->name=>array('/course/index/view','id'=>$course->id), Yii::t('app',"课程管理")),
));
?>

<div class="row ">

	<div class="col-sm-2 dxd-course-category">
	<?php $this->renderPartial('_side_nav',array('course'=>$course));?>
	</div>
	<div class="col-sm-10">
		<h3 class="side-lined"><?php echo Yii::t('app','成员管理');?></h3>
<div>
<?php echo CHtml::link('<i class="icon-plus icon-white"></i>'.Yii::t('app','添加成员'),"#",array('class'=>'btn btn-success','data-toggle'=>'collapse','data-target'=>'#collapseOne'))?>
   <div id="collapseOne" class="collapse">

<?php
$model=new CourseMember();
unset($model->userId);
$form=$this->beginWidget('booster.widgets.TbActiveForm', array(
	'id'=>'course-form',
	'action'=>array('addMember','id'=>$course->id),
	'enableAjaxValidation'=>false,
)); ?>


	<?php //echo $form->textFieldGroup($model,'userId',array('maxlength'=>64,'class'=>'input-block-level')); ?>
<br/>
 	<?php echo $form->hiddenField($model,'courseId',array('value'=>$model->courseId));?>

    <?php echo $form->checkBoxListGroup($model,'arrRoles',array(
        'widgetOptions' =>  array(
            'data'  =>  array('admin'=>Yii::t('app','管理员'),'teacher'=>Yii::t('app','教师'),'student'=>Yii::t('app','学生'))
        ),
    )); ?>

<div class="form-group">
    <?php echo $form->labelEx($model,'userId', array('class'=>''));?>
    <div class="">
    <?php
    $this->widget('zii.widgets.jui.CJuiAutoComplete',array(
 	'name'=>'userName',
    'sourceUrl'=>array('//u/fetchNames'),
    'htmlOptions'=>array(
 		'placeHolder'=>Yii::t('app','请输入用户名，（只能添加已注册用户）'),
        'class'=>'form-control',
        'style' =>  'width:400px',
    ),
));
?>
    </div>
</div>
<?php $this->widget('booster.widgets.TbButton',array('label'=>'提交','buttonType'=>'submit','context'=>'primary'));?>
<br><br>
<div class="clearfix"></div>


<?php $this->endWidget(); ?>
    </div>
</div>

<h4>超级管理员</h4>
	<?php $this->widget('booster.widgets.TbListView', array(
			    'dataProvider'=>$superAdminDataProvider,
			    'template'=>"{items}\n{pager}",
				'separator'=>'<hr style="margin:10px 0;"/>',
				'viewData'=>array('course'=>$course),
				'itemView'=>'_member_item',   // refers to the partial view named '_post'
		)); ?>
		<br/>
<h4>管理员</h4>
	<?php $this->widget('booster.widgets.TbListView', array(
			    'dataProvider'=>$adminDataProvider,
			    'template'=>"{items}\n{pager}",
				'separator'=>'<hr style="margin:10px 0;"/>',
				'emptyText'=>'暂时还没有',
				'viewData'=>array('course'=>$course),
				'itemView'=>'_member_item',   // refers to the partial view named '_post'
		)); ?>
				<br/>

<h4>教师</h4>
	<?php $this->widget('booster.widgets.TbListView', array(
			    'dataProvider'=>$teacherDataProvider,
			    'template'=>"{items}\n{pager}",
				'separator'=>'<hr style="margin:10px 0;"/>',
				'emptyText'=>'暂时还没有',
				'viewData'=>array('course'=>$course),
				'itemView'=>'_member_item',   // refers to the partial view named '_post'
		)); ?>
				<br/>

<h4>学员</h4>
	<?php $this->widget('booster.widgets.TbListView', array(
			    'dataProvider'=>$studentDataProvider,
			    'template'=>"{items}\n{pager}",
				'emptyText'=>'暂时还没有',
				'separator'=>'<hr style="margin:10px 0;"/>',
				'viewData'=>array('course'=>$course),
				'itemView'=>'_member_item',   // refers to the partial view named '_post'
		)); ?>

<h4>其他</h4>
	<?php $this->widget('booster.widgets.TbListView', array(
			    'dataProvider'=>$otherDataProvider,
			    'template'=>"{items}\n{pager}",
				'emptyText'=>'暂时还没有',
				'separator'=>'<hr style="margin:10px 0;"/>',
				'viewData'=>array('course'=>$course),
				'itemView'=>'_member_item',   // refers to the partial view named '_post'
		)); ?>

	</div>
</div>

