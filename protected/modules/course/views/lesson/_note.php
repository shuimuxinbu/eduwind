<?php 
?>
<style>
.dxd-note-block .editable-container{
width:96%;
}
.dxd-note-block .editable-input{
width:100%;
}
.dxd-note-block .editable-input textarea{
width:100%;
}
a.editable-click{
color:#333;
text-decoration:none;
border-bottom:none;
}
a.editable-empty{
color:#DD1144;
}

</style>
			<!-- 个人笔记开始 -->
			<?php if(!Yii::app()->user->isGuest){?>
			<div class="dxd-note-block dxd-break">
			<h4><?php echo Yii::t('app','个人笔记');?></h4>
				<?php     
    $this->widget('editable.EditableField', array(
    'type' => 'textarea',
    'model' => $myNote,
    'mode'=>'inline',
    'attribute' => 'content',
	'emptytext'=>Yii::t('app','点击打开笔记本'),
    'send'=>'always',
    'options'=>array('toggle'=>'click','rows'=>16,'onblur'=>'ignore'),
    'url' => $this->createUrl('lesson/saveNote',array('id'=>$lesson->id)),
    'showbuttons' => 'bottom',
//    'inputclass'=>'input-block-level',
    'htmlOptions'=>array('style'=>'width:100%;max-height:500px;','class'=>'dxd-noteable-object' )
    ));
    ?>
				<div style="margin-top:0px">
				<div class="pull-right" style="margin-top:5px">
					<?php // echo CHtml::link('<i class="icon-pencil dxd-opacity60"></i>编辑','#',array('class'=>'dxd-lesson-note-edit dxd-lesson-note-edit1 muted'));?>

					<?php 
						/*	echo CHtml::link('<i class="icon-lock dxd-opacity60"></i>'.($note->published || !$note->content? '设为私密' : '设为公开'),
											array('lessonNote/togglePublished','id'=>intval($note->id),'id'=>$lesson->id),
											array('class'=>'muted','id'=>'dxd-lesson-note-toggle-published','rel'=>'tooltip','data-title'=>'强烈推荐您公开笔记'));
											*/
											?>
				</div>
				<div class="clearfix"></div>

			</div>
			</div>
			<hr/>
			<?php }?>
			<!-- 个人笔记结束 -->

		
	<div class="dxd-note-block">	
<!--	<hr/>	
  
	<h4>同学笔记</h4>
	-->
	<?php 
/*		$this->widget('booster.widgets.TbListView', array(
				    'dataProvider'=>$publicNoteDataProvider,
				    'itemView'=>'_public_note_item',   // refers to the partial view named '_post'
					'separator'=>'<hr style="margin:10px 80px"/>',
					'emptyText'=>'还没有同学公开个人笔记',
				    'summaryText'=>false,
		));*/
	?>
	</div>
	
	<script type="text/javascript">
$(document).ready(function(){
	$('.dxd-lesson-note-edit').click(function(e){
        e.stopPropagation();
		$(this).parents('.dxd-note-block').find('.dxd-noteable-object').editable('toggle');
	});
});
	</script>
