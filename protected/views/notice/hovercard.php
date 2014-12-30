<div style="padding:10px;color:#555;font-size:0.8em;" class="dxd-notice-box">
<?php $this->widget('booster.widgets.TbListView', array(
	'dataProvider'=>$dataProvider,
	'itemView'=>'_view',
	'separator'=>'<hr style="margin:10px 0"/>',
	'template'=>'{items}',
	'emptyText'=>Yii::t('app','没有未读提醒'),
)); ?>
</div>
<script type="text/javascript">
<!--

//-->
$(document).ready(function(){
	$(".dxd-notice").parents('li').find(".badge").text("0");
});
</script>
<?php 

?>
