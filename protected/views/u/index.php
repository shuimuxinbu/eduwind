<div class="row">
	<div style="border:1px solid #ccc;" class="col-sm-12">
	<div style="padding:15px">
		<div class="pull-left">
			<?php echo CHtml::image(Yii::app()->baseUrl."/".DxdUtil::xImage($user->face,120,120),$user->name,array('class'=>'pull-left','style'=>"margin-right:20px"));?>
			<div class="pull-left">
				<h2><?php echo $user->name;?>	</h2>
				<p class="dxd-break-word dxd-self-introduction" style="margin-top:20px;font-size:1.5em;"><?php echo $user->bio;?></p>
			</div>
			<div class="clearfix"></div>
		</div>
	<div class="pull-right">
		<?php
		 /*$this->widget('booster.widgets.TbButton', array(
    'label'=>'<i class="icon-envelope"></i>'.Yii::t('app','发私信'),
//	'url'=>'javascript:openFancyBox("'.Yii::app()->createUrl('message/create',array('toUserId'=>$user->id)).'");',
   'url'=>array('message/create','toUserId'=>$user->id),
	'htmlOptions'=>array('style'=>'margin:0 5px;','class'=>"dxd-message-btn",'onclick'=>'openFancyBox(this);return false;'),
     'encodeLabel'=>false,
	));*/
        echo CHtml::link(
            Yii::t('app','发私信'),
			array('message/create','toUserId'=>$user->id),
			array('onclick'=>'openFancyBox(this);return false;','class'=>'btn btn-default dxd-message-btn'));
	?>
	<?php
	$isFan = $user->isFan(Yii::app()->user->id);
	echo CHtml::link(($isFan ? Yii::t('app','取消关注'):'<i class="icon-plus icon-white"></i>'.Yii::t('app','关注')),
						array('u/toggleFollow','id'=>$user->id),
						array('onclick'=>'toggleFollow(this);return false;','id'=>'dxd-user-followed-'.$user->id,'class'=>'btn btn-default dxd-user-followed-'.$user->id." ".($isFan ? ' ':' btn-success '))
					);
?>
	</div>
	<div class="clearfix"></div>

	<p class="dxd-break-word " style="margin-top:20px;font-size:1.1em;font-weight:normal;"><?php echo $user->introduction;?></p>

	</div>
	</div>
<br/>
</div>
<div class="row">
<div class="col-sm-12">

	<div class="tabbable" style="margin-top:30px"> <!-- Only required for left/right tabs -->
	  <ul class="nav nav-tabs">
	   <!--
	   	<li ><a href="#tab3" data-toggle="tab">回答<span class="muted">&nbsp;<?php // if($user->answerCount) echo $user->answerCount;?></span></a></li>

	    <li><a href="#tab2" data-toggle="tab">提问<span class="muted">&nbsp;<?php //if($user->questionCount) echo $user->questionCount;?></span></a></li>
-->
	    <li class="active">
	    	<a href="#tab1" data-toggle="tab">
	    	<?php echo Yii::t('app','课程')?><span class="muted">&nbsp;<?php if($user->courseCount) echo $user->courseCount;?></span>
	    	</a>
	    </li>
	  </ul>
	  <div class="tab-content">

	   <div class="tab-pane " id="tab3">
			<?php  //$this->renderPartial('_answer',array('dataProvider'=>$answerDataProvider));?>
	    </div>
	    <div class="tab-pane" id="tab2">
			<?php //$this->renderPartial('_question',array('dataProvider'=>$questionDataProvider));?>
	    </div>



	    <div class="tab-pane  active" id="tab1">
			<?php  $this->widget('booster.widgets.TbThumbnails', array(
	    'dataProvider'=>$courseDataProvider,
	    'template'=>"{items}\n{pager}",
	    'itemView'=>'/site/_course_item'
	)); ?>
	    </div>


	  </div>
	</div>
</div>
</div>
