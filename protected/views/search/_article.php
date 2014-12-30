<?php 
$title = Search::highlightWord($data->title, $keyword);
?>
<div>
	<div>
        <?php  echo CHtml::link($title ,$data->pageUrl); ?>

        <br/>
        <div class="muted" style="margin:5px 0">
            by 
            <?php echo CHtml::link(UserInfo::model()->findByPk($data->uid)->name, array('u/index','id'=>$data->uid),array('class'=>'muted'));?>
            <?php echo date('Y-m-d',$data->addTime);?>
        </div>

    </div>
    <div class="clearfix"></div>
</div>
