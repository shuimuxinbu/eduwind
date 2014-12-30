<div style="margin-bottom:15px">
	<div style="display:none">
		<?php 
			$this->widget('editable.Editable', array(
				'type' => 'select2',
				'name' => 'hidden',
			));
		?>
	</div>
					
	<span class="dxd-topics dxd-topics editable" id="dxd-topics-editable-1"
		data-toggle="manual" data-type="select2" data-pk="1"
	    data-value="<?php echo $group->getTagNamesString();?>" data-original-title="<?php echo Yii::t('app','编辑话题');?>"></span>
	        	
	<?php if(!Yii::app()->user->isGuest):?>
	&nbsp;&nbsp;<a href="#" id="dxd-topics-edit-1" data-editable="dxd-topics-editable-1" class="muted" courseId="<?php echo $group->id?>"><i class="icon-pencil"></i>编辑</a>
	<?php endif;?>
	&nbsp;&nbsp;<?php echo CHtml::link('<i class="icon-list"></i>'.Yii::t('app','历史'),array('revisionHistory/coursetopic','courseId'=>$group->id),array('class'=>' dxd-course-topic-revision muted'));?>        	
</div>

<script type="text/javascript">
$(document).ready(function(){
	var strtopics = '<?php echo addslashes(Tag::getTagNamesString());?>';
	var topics = strtopics.split(',');
	$('.dxd-topics').editable({
		url: '<?php echo Yii::app()->createUrl('group/updateMark',array('id'=>$group->id));?>',
		emptytext: Yii::t('app','没有话题'),
	    placement: 'bottom',
	    mode:'inline',
	    select2: {
	        tags: topics,
	        formatNoMatches: null,
	        tokenSeparators: [",", " ", "，"],
	        width:240
	    },
	    display: function(value) {
		    values = new Array();
		    if(value) {
		        $.each(value,function(i){
		           // value[i] needs to have its HTML stripped, as every time it's read, it contains
		           // the HTML markup. If we don't strip it first, markup will recursively be added
		           // every time we open the edit widget and submit new values.
		           //value[i] = "<span class='label'><a style='color: rgb(0,0,0)' href='"+base_url+"/index.php?r=course&topic="+value[i]+"'>" + $('<p>' + value[i] + '</p>').text() + "</a></span>";
		        	values[i] = "<a class='dxd-topic-label' href='<?php echo Yii::app()->baseUrl;?>/topic/view?name="+value[i]+"'>" + $('<p>' + value[i] + '</p>').text() + "</a>";
		        });
		        $(this).html(values.join(" "));
		    }
		    else $(this).html("<font style=\"color:#DD1144;font-style: italic;\">".Yii::t('app','没有话题')."</font>");
	    }
	});

	$('.dxd-topics').on('shown', function() {
	    var editable = $(this).data('editable');
	    value = editable.value;
	    if(value) {
		    $.each(value,function(i){
		       value[i] = $('<p>' + value[i] + '</p>').text()
		    });
	    }
	});

	$('#dxd-topics-edit-1').click(function(e) {
		//alert($(this).attr('courseId'));
	    e.stopPropagation();
	    e.preventDefault();
	    $('#' + $(this).data('editable') ).editable('toggle');
	});
});
</script>
