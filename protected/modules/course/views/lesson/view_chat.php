<?php
/* @var $this LessonController */
/* @var $model Lesson */
 $this->widget('booster.widgets.TbBreadcrumbs', array(
 	'homeLink'=>false,
    'links'=>array($lesson->course->name=>array('index/view','id'=>$lesson->course->id), $lesson->title),
)); 

?>
<h3><?php echo $lesson->title?></h3>

<div class="row">
<div class="col-sm-12">
<?php 
			$file = $lesson->file;
            	$src= CloudService::getInstance()->getDownloadUrl($file->convertStatus=="success" ? $file->convertKey : $file->path);
   
   $this->widget('ext.mukioplayer.MukioPlayer',array('flashvars'=>array('file'=>$src)));
?>

</div>

<br/>	
		<div class="col-sm-7" >
			<div class="mt20">		
	<h4><?php echo Yii::t('app','简介')?></h4>
		<!-- 笔记内容-->
		<div class="dxd-lesson-note" style="font-size: 16px;line-height:1.75em;">
			<?php echo ($lesson->introduction)?$lesson->introduction:Yii::t('app','笔记内容为空！') ?>
		</div>
		</div>
		
		
		<div class="tabbable"> <!-- Only required for left/right tabs -->
		 <!-- 标签 -->
		  <ul class="nav nav-pills" style="margin-bottom:0">
		    <li class="<?php if(!($member && $member->inRoles(array('student','member','teacher')))) echo "active";?>  "><a href="#tab0" data-toggle="tab"><?php echo Yii::t('app','评论')?></a></li>
		    <li class="<?php if($member && $member->inRoles(array('student','member','teacher'))) echo "active";?>  "><a href="#tab1" data-toggle="tab"><?php echo Yii::t('app','笔记')?></a></li>
		    
		    <li class=""><a href="#tab2" data-toggle="tab"><?php echo Yii::t('app','资料');?></a></li>
		    
		    <li class=""><a href="#tab3" data-toggle="tab"><?php echo Yii::t('app','目录');?></a></li>

		  </ul>
		  <!-- 内容 -->
		  <div class="tab-content">
		  <div class="tab-pane <?php if(!($member && $member->inRoles(array('student','member','teacher')))) echo "active";?>" id="tab0">
		  	<div style="margin-top:20px">
		<?php if(!Yii::app()->user->isGuest){?>
		<?php $this->renderPartial('/lesson/_comment_form',array('lesson'=>$lesson));?>
		<div class="clearfix"></div>
		<?php }else{
		Yii::app()->user->returnUrl=array('course/lesson/view','id'=>$lesson->id);	
		 ?>
		<p><?php echo Yii::t('app','评论前请先');?><?php echo CHtml::link(Yii::t('app',' 登录 '),array('//u/login'))?><?php echo Yii::t('app','或');?><?php echo CHtml::link(Yii::t('app',' 注册 '),array('//u/register'));?></p>
		<?php }?>
		</div>
		<div class="dxd-lesson-comments">
		<?php 
			$this->renderPartial('/lesson/_comments',array('commentDataProvider'=>$commentDataProvider,'lesson'=>$lesson));
		?>
	</div>
		  
		  
		  </div>
		    <!--  内容1 -->
		    <div class="tab-pane <?php if($member && $member->inRoles(array('student','member','teacher'))) echo "active";?>" id="tab1">
			<?php  echo $this->renderPartial('/lesson/_note',array('lesson'=>$lesson,'myNote'=>$myNote));?>		  
		    </div>
		    <!-- 内容1结束 -->
		    <!-- 内容2开始 -->
		    
		    <div class="tab-pane" id="tab2">
		      <div style=""> <?php // echo CHtml::link('<i class="icon-pencil"></i> 提问','javascript:;',array('class'=>'btn','data-toggle'=>'collapse','data-target'=>'#dxd-question-form-wrapper','id'=>'dxd-ask-question','style'=>'margin-bottom:10px;'));?></div>
		      <div class="clearfix"></div>
		      <div class="">
			  <?php
			 //	echo $this->renderPartial('_question_form', array('model'=> new Question(),'course'=>$lesson->course,'lesson'=>$lesson));
			  	 $this->widget('booster.widgets.TbListView', array(
				    'dataProvider'=>new CArrayDataProvider($lesson->docs),
				    'itemView'=>'_doc_item',   // refers to the partial view named '_post'
  					'summaryText'=>false,
					'emptyText'=>'<div style="padding: 15px;">'.Yii::t('app','还没有文档资料').'</div>',
				));
			  ?>
			   </div>

		    </div>
		   
		    <!-- 内容2结束 -->		
  
  			<div class="tab-pane" id="tab3" style="max-height:450px;overflow:auto;">
  						<?php 	$this->widget('booster.widgets.TbListView', array(
				    'dataProvider'=>$lessonDataProvider,
				    'itemView'=>'/index/_lesson',   // refers to the partial view named '_post'
					'viewData'=>array('pagination'=>$lessonDataProvider->pagination,'member'=>$member),
  					'summaryText'=>false,
					'emptyText'=>'<div style="padding: 15px;">'.Yii::t('app','课时列表为空').'</div>',
				));
				?>
  			</div>
		  </div>
		</div>
		</div>
	</div>



<script type="text/javascript">
$(document).ready(function(){

	//显示或隐藏修改理由输入框
	$('.dxd-lesson-note-reason select').change(function(){
		if($(this).val()=="0"){
			block.find('.dxd-lesson-note-other-reason').show();
		}else{
			block.find('.dxd-lesson-note-other-reason').hide();
		}
	});
	//是否公开个人笔记
	$('#dxd-lesson-note-toggle-published').click(function(){
		var dis=this;
		var url = $(dis).attr('href');
		$.get(url,function(data){
				if(data==true)
					$(dis).text(<?php echo Yii::t('app','设为私密');?>);
				else if(data==false)
					$(dis).text(<?php echo Yii::t('app','设为公开');?>);
		});
		return false;
	});
	//为个人笔记投票
	$('.dxd-lesson-note-vote').click(function(){
		var dis=this;
		var url = $(dis).attr('href');
		$.get(url,function(data){
			$(dis).parents('.dxd-public-lesson-note').find('.dxd-lesson-note-vote-result').html(data);
			$(dis).addClass('dxd-voted');
		});
		return false;
	});
	//hover切换tab
//	$('.dxd-right-col .nav-tabs > li > a').hover( function(){
//	      $(this).tab('show');
//	   });
});

</script>


<?php  Yii::app()->clientScript->registerScript("viewNum",
												'$.get("'.$this->createUrl('counter',array('id'=>$lesson->id)).'");'
												);?>
				

							
