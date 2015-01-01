<?php
?>
<div class="row">
<div class="col-sm-8 col-sm-offset-2">
	<div class="well">
	<?php
$this->renderPartial('_header');
?>		<br/>
		<table class="table">
			<tr>
				<th>环境检查</th>
				<th>推荐配置</th>
				<th>最低配置</th>
				<th>当前配置</th>
			</tr>
			<tr>
				<td>php版本</td>
				<td>>=5.3</td>
				<td>5.2</td>
				<td>
						<?php if($phpVersion):?>
			<span class="text-success">√ <?php echo PHP_VERSION;?></span>
		<?php else:?>
			<span class="text-error">× <?php echo PHP_VERSION;?></span>
		<?php endif;?>
				</td>
			</tr>
			<?php foreach($exts as $key=>$value):?>
			<tr>
				<td>php扩展:<?php echo $key;?></td>
				<td>必须安装</td>
				<td>必须安装</td>
				<td>
						<?php if($value):?>
			<span class="text-success">√ 已安装</span>
		<?php else:?>
			<span class="text-error">× 未安装</span>
		<?php endif;?>
				</td>
			</tr>
			<?php endforeach;?>




			<tr>
				<td>上传文件限制</td>
				<td>>=200M</td>
				<td>2M</td>
				<td>
					<span class="text-success">√ <?php echo $maxFileSize;?>M</span>
				</td>
			</tr>
		</table>
		<br/>
		<table class="table">
		<tr>
		<th>目录</th>
		<th>所需权限</th>
		<th>当前权限</th>
		</tr>
		<?php foreach($privates as $index=>$item):?>
		<tr>
		<td><?php echo $index;?></td>
		<td>可写</td>
		<td>
		<?php if($item):?>
			<span class="text-success">√ 可写</span>
		<?php else:?>
			<span class="text-error">× 不可写</span>
		<?php endif;?>
		</td>
		</tr>
		<?php endforeach;?>

		</table>
		<div class="text-center">
		<?php
		if($pass)
			echo CHtml::link('下一步',array('database'),array('class'=>'btn btn-primary'));
		else
			CHtml::link('下一步',"#",array('class'=>'btn btn-primary disabled'));	?>
		</div>
	</div>
</div>
</div>
