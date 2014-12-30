<?php
/* @var $this TopicController */
/* @var $model Topic */
?>
<div class="row">
	<div class="col-sm-8">
		<div class="dxd-topic-header">
				<div class="pull-left"><h2><?php echo $topic->name;?></h2></div>
				<div class="pull-right">
				<?php
				echo CHtml::link((TopicFollow::model()->hasFollow(Yii::app()->user->id, $topic->id) ? Yii::t('app','取消关注'):'<i class="icon-plus  icon-white"></i>'.Yii::t('app','关注')),
									array('topic/togglefollow','topicid'=>$topic->id),
									array('onclick'=>'toggleFollow(this);return false;','class'=>'btn  dxd-topic-followed'." ".(TopicFollow::model()->hasFollow(Yii::app()->user->id, $topic->id) ? ' ':' btn-success '))
								);

				?>
				</div>
				<div class="clearfix"></div>
		</div>
		<div class="dxd-topic-body">

		<div class="tabbable"> <!-- Only required for left/right tabs -->
		  <ul class="nav nav-pills">
		    <li <?php if($type=='course'):?>class="active"<?php endif;?>><a href="#tab1" data-toggle="tab"><?php echo Yii::t('app','课程')?></a></li>
		    <li <?php if($type=='question'):?>class="active"<?php endif;?>><a href="#tab2" data-toggle="tab"><?php echo Yii::t('app','问答')?></a></li>
		  </ul>
		  <div class="tab-content">
		    <div class="tab-pane <?php if($type=='course'):?> active<?php endif;?>" id="tab1">
			<?php $this->widget('booster.widgets.TbThumbnails', array(
			    'dataProvider'=>$courseDataProvider,
			    'template'=>"{items}\n{pager}",
			    'itemView'=>'//course/_card',
				'afterAjaxUpdate'=>'js:function(id,data) {
		            $("span[id^=\'rating\'] > input").rating({"readOnly":true});
		        }'
			)); ?>

		    </div>
		    <div class="tab-pane <?php if($type=='question'):?>active<?php endif;?>" id="tab2">
			<?php $this->widget('booster.widgets.TbThumbnails', array(
			    'dataProvider'=>$questionDataProvider,
			    'template'=>"{items}\n{pager}",
			    'itemView'=>'//question/_question_item',
				'afterAjaxUpdate'=>'js:function(id,data) {
		            $("span[id^=\'rating\'] > input").rating({"readOnly":true});
		        }'
			)); ?>

		    </div>
		  </div>
		</div>

		</div>
	</div>
	<div class="col-sm-4">
	<div class="dxd-topic-description-container">
			<h4><?php echo Yii::t('app','话题描述')?></h4>
		<?php $form=$this->beginWidget('booster.widgets.TbActiveForm', array(
						'id'=>'topic-description-form',
						'action'=>array('revision/topicdescription','topicid'=>$topic->id),
						'enableAjaxValidation'=>false,
						'htmlOptions'=>array('style'=>'margin-bottom:0'),
		)); ?>
		<div style="display:none">
			<?php /*	$this->widget('ext.redactor.ERedactorWidget',array(
						'name'=>'description',
						'value'=>'',
						'htmlOptions'=>array('id'=>'dxd-topic-description-input-hidden'),
					));*/
			?>
		</div>
		<div class="dxd-topic-description" style="font-size: 16px;line-height:1.75em;">
			<?php echo ($topic->description)?$topic->description:'还没有话题描述' ?>
		</div>

		<?php echo CHtml::link(Yii::t('app','取消'),'#',array('class'=>'pull-right dxd-topic-description-cancel btn dxd-topic-description-edit2','style'=>"display:none;"));?>

		<?php
			$this->widget('booster.widgets.TbButton', array(
		    					'label'=>Yii::t('app','保存'),
								'buttonType'=>'submit',
		    					'context'=>'primary', // null, 'primary', 'info', 'success', 'warning', 'danger' or 'inverse'
								'htmlOptions'=>array('class'=>'pull-right dxd-topic-description-save dxd-topic-description-edit2','style'=>"display:none;margin:0 10px;")
			));
		?>
		<div class="pull-right" style="margin-top:5px">
			<?php if(Yii::app()->user->isGuest) echo CHtml::link('<i class="icon-pencil"></i>'Yii::t('app','编辑'),'#',array('class'=>' dxd-topic-description-edit dxd-topic-description-edit1 muted','style'=>'margin-left:10px;'));?>
			<?php echo CHtml::link('<i class="icon-list"></i>'.Yii::t('app','历史'),array('revisionHistory/topicDescription','topicid'=>$topic->id),array('class'=>' dxd-topic-descriptioin-revision  muted','style'=>'margin-left:10px;'));?>
		</div>
		<?php $this->endWidget();?>

	</div>
	</div>
</div>
<script type="text/javascript">
$(document).ready(function(){
	var note = $('.dxd-topic-description').html();
	$('.dxd-topic-description-edit1').click(function(){
		$('.dxd-topic-description-edit1').hide();
		$('.dxd-topic-description-edit2').show();
	});

	$('.dxd-topic-description-edit2').click(function(){
		$('.dxd-topic-description-edit2').hide();
		$('.dxd-topic-description-edit1').show();
	});

	$('.dxd-topic-description-edit').click(function(){
		$('.dxd-topic-description').redactor({focus:true});

	});

	$('.dxd-topic-description-save').click(function(){
	    // save content if you need
	    var html = $('.dxd-topic-description').html();//redactor('get');
		note = html;
	    //将课堂笔记填充到隐藏的表单字段中
	    $('#dxd-topic-description-input-hidden').val(html);

	    // destroy editor
	    $('.dxd-topic-description').redactor('destroy');
	    $('.dxd-topic-description').html(html);
	});
	$('.dxd-topic-description-cancel').click(function(){
	    // destroy editor
	    $('.dxd-topic-description').redactor('destroy');
	    $('.dxd-topic-description').html(note);
	});
});
</script>
