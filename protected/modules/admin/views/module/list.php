<?php
/* @var $this AnswerController */
/* @var $dataProvider CActiveDataProvider */

?>
<div class="container">
<div class="row">
<div class="col-sm-12">
<h2>模块列表</h2>
<div>
<table class="table" style="width:98%">
<tr>
	<th>模块名</th>
	<th>版本</th>
	<th>描述</th>
	<th  style="text-align:right">操作&nbsp;&nbsp;</th>
</tr>
<?php foreach($modules as $module):?>
<tr>
	<td><?php echo $module->getDisplayName(); ?></td>
	<td><?php echo $module->getVersion(); ?></td>
	<td><?php echo $module->getDescription(); ?></td>
	<td style="text-align:right">
	<?php 
		//echo CHtml::link((in_array($module->id,$setting->activeModules) ? '<span class="text-error">暂停</span>' :'开启'),array('toggleActive','id'=>$module->id),array('class'=>'mr10'));
		// echo CHtml::link((in_array($module->id,$setting->navModules) ? '<span class="text-error">停止导航</span>' :'加入导航'),array('toggleNav','id'=>$module->id),array('class'=>'mr10'));
		 echo CHtml::link('管理',array('//'.$module->id."/admin/index"),array('class'=>'mr10'));
	?>
	</td>
</tr>
<?php endforeach;?>
</table>
</div>
</div>
</div>
</div>
