<?php
?>
		<h1><span  class="text-warning">EduWind </span>安装向导</h1>
		<br/>
		<div>
		<?php 
		$action = Yii::app()->controller->action->id;
		$this->widget('booster.widgets.TbMenu', array(
    'type'=>'pills', // '', 'tabs', 'pills' (or 'list')
    'stacked'=>false, // whether this is a stacked menu
    'items'=>array(
        array('label'=>'1、检测环境', 'url'=>"#",'itemOptions'=>array('class'=>($action!=='env'?'disabled':'')),'active'=>($action=='env'?true:false)),
        array('label'=>'2、连接数据库', 'url'=>'#','itemOptions'=>array('class'=>($action!=='database'?'disabled':'')),'active'=>($action=='database'?true:false)),
        array('label'=>'3、初始化系统', 'url'=>'#','itemOptions'=>array('class'=>($action!=='init'?'disabled':'')),'active'=>($action=='init'?true:false)),
        array('label'=>'4、完成安装', 'url'=>"#",'itemOptions'=>array('class'=>($action!=='finish'?'disabled':'')),'active'=>($action=='finish'?true:false)),
        ))); ?>
		</div>
