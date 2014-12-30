<div id="edu-home">
<?php
// 取当前主题首页数据
$groupDataProvider = new CActiveDataProvider('Group',array('criteria'=>array('condition'=>'status="ok"','order'=>'memberNum desc,addTime desc'),'pagination'=>array('pageSize'=>4)));
$courseDataProvider=new CActiveDataProvider('Course',array(
    'criteria'=>array('with'=>array('user'),'order'=>'studentNum desc','condition'=>'t.status='.Course::STATUS_OK),
    'pagination'=>array(
        'pageSize'=>4,
)));
$postDataProvider=new CActiveDataProvider('Post',array(
    'criteria'=>array('order'=>'upTime desc'),
    'pagination'=>array(
        'pageSize'=>5,
)));
$linkDataProvider = new CActiveDataProvider('FriendLink',array('criteria'=>array('order'=>'weight asc'),'pagination'=>array('pageSize'=>100)));
$newbieDataProvider = new CActiveDataProvider('User',array('criteria'=>array('order'=>'addTime desc'),'pagination'=>array('pageSize'=>5)));


/* @var $this SiteController */
$this->pageTitle=Yii::app()->params['settings']['site']['name']." - ".Yii::app()->params['settings']['site']['subTitle'];
?>
<?php //$this->renderPartial('_header');?>
<div class="row" style="margin-top:10px">
	<div class="col-sm-9">
	<div  style="margin-bottom:26px; solid #354b59;font-size:2em;"><?php echo Yii::t('app','热门课程');?>
	<?php //echo CHtml::link('<em>更多</em>',array('group/index'),array('style'=>'font-size:16px;font-weight:normal;'));?>
	<div class="pull-right" style="font-size:14px; line-height:40px">
	<?php echo CHtml::link(Yii::t('app','查看课程 》'),array('course/index'),array('class'=>'theme-color'));?>
	</div>
	</div>
	<!--
	<hr style="margin: 0px 0 15px 0"/>
	-->
	<?php
		$this->widget('booster.widgets.TbThumbnails', array(
		    'dataProvider'=>new CActiveDataProvider('Course',array('criteria'=>array('condition'=>'status='.Course::STATUS_OK,'order'=>'studentNum desc'),'pagination'=>array('pageSize'=>3))),
		    'template'=>"{items}",
		    'itemView'=>'_course_item'
		));
	?>
	</div>
	<div class="col-sm-3">
	<?php $this->renderPartial('_list');?>
	</div>
</div>
<hr/>
      <?php
      	$categoryDataProvider = new CActiveDataProvider('Category',array('criteria'=>array('condition'=>'type="course" and parentId=0','order'=>'weight asc'),'pagination'=>array('pageSize'=>4)));
      	$this->widget('booster.widgets.TbListView', array(
		    //'dataProvider'=>new CActiveDataProvider('Course',array('criteria'=>array('order'=>'memberNum desc'),'pagination'=>array('pageSize'=>10))),
			'dataProvider'=>$categoryDataProvider,
      		'itemView'=>'_category_courses',   // refers to the partial view named '_post'
			'summaryText'=>false,
			'template'=>'{items}',
			'separator'=>'<hr/>'
		//	'emptyText'=>'暂时还没有收藏课程',
		));
      ?>
<br/>

<div class="row">
<?php if($linkDataProvider->totalItemCount):?>
	<div class="col-xs-12">
	<div  style="font-size:20px;background-color:#ececec;margin-top: 40px;
margin-bottom: 40px;
padding: 20px 40px;">
		<div class="pull-left" style="margin-right:30px;"><?php echo Yii::t('app','友情链接:');?></div>
		<div class="">
		<?php
			$links = $linkDataProvider->getData();
			foreach($links as $item){
				echo "<a href='$item->url'  class=' light-green' style='margin-right:30px;' target='_blank'>$item->title</a>";
			}
		?>
		</div>
		<div class="clearfix"></div>
	</div>
	</div>
<?php endif;?>
</div>
</div>
