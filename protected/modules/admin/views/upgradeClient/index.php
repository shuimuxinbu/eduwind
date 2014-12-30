
<h3 class="side-lined">系统更新</h3>
<?php echo "当前版本:".$siteInfo->version;?>

<?php
$upgradeCount = UpgradeInfo::model()->count("status=:status",array(':status'=>'not installed'));
	echo '<br/><p>有'.$upgradeCount.'个更新包需要更新</p>';
if ($upgradeCount>0) {
	echo CHtml::link('开始更新',array('upgradeClient/doUpgrade'),array('class'=>'btn btn-success dxd-fancy-elem ml10',
															  'data-fancyWidth'=>700,
															  'data-fancyHeight'=>300));
}
$this->widget('booster.widgets.TbGridView',array(
	'id'=>'upgrade-package-grid',
	'dataProvider'=>$dataProvider,
	//'filter'=>$model,
	'columns'=>array(
		//'id',
		'version',
		'name',
		array('name'=>'description','type'=>'raw'),
		array('name'=>'addTime','value'=>'date("Y-m-d H:m:s",$data->addTime)'),
//		array('name'=>'status','value'=>'($data->status == "installed")?"<font color=\"#33CC00\">已安装</font>":"<font color=\"#FF0000\">未安装</font>"','type'=>'raw'),
		array('name'=>'status')
		),
)); ?>

<script type="text/javascript">
$(document).ready(function(){
	$("#fancybox-close").live('click',function(event){
		location.reload();
	});
});
</script>
