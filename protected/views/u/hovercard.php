<div style="padding:10px;">
	<table style="width:100%">
	<tr><td style="width:55px;vertical-align:top;">

	<?php  $img = CHtml::image(($user->face && DxdUtil::xImage($user->face,48,48)) ? Yii::app()->baseUrl."/".DxdUtil::xImage($user->face,48,48) : "http://placehold.it/48x48",
							"$user->name",array(
								'style'=>"width:48px;height:48px;"
							));
		 echo CHtml::link($img,$user->pageUrl,array('class'=>'pull-left'));
	?>
	</td>
	<td>
					
		<div class="pull-right">
		<?php
				 $this->widget('booster.widgets.TbButton', array(
		    'label'=>Yii::t('app','私信'),
		    'url'=>array('message/create','toUserId'=>$user->id),
		    'size'=>'small', // null, 'large', 'small' or 'mini'
			'htmlOptions'=>array('style'=>'margin:0 5px;','class'=>"dxd-message-btn",'onclick'=>'openFancyBox(this);return false;')
		)); 
			?>
			<?php 
			$isFan = $user->isFan(Yii::app()->user->id);
			echo CHtml::link(($isFan ? Yii::t('app','取消关注'):Yii::t('app','关注')),
								array('u/toggleFollow','id'=>$user->id),
								array('onclick'=>'toggleFollow(this);return false;','id'=>'dxd-user-followed-'.$user->id,'class'=>'btn btn-small dxd-user-followed-'.$user->id." ".($isFan ? ' ':' btn-success '))
							);
		?>
		</div>
	
		<?php 	 echo CHtml::link($user->name,$user->pageUrl,array("class"=>'pull-left','style'=>'font-size:1em;padding-top:4px;'));
		?>
		<div class="clearfix" ></div>
		<div style="margin-top:10px">
		<!--  
				<span style="font-weight:bold;font-size:1em;"><?php echo $user->answerNum;?></span><span class="muted"> 个回答</span>
				 
				<span style="font-weight:bold;font-size:1em;"><?php echo $user->fanNum;?></span><span class="muted"> 人关注他/她</span>
		-->
				 <!--  
				<span style="font-weight:bold;font-size:1em;"><?php // echo $user->answerVoteupNum;?></span><span class="muted"> 赞同</span>
				 -->
		</div>
		</td>
		</tr>
		</table>
	<div  class="dxd-break-word"><?php echo $user->bio;?></div>


</div>

<?php 

?>
