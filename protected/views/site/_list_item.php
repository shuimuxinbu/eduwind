<div>
<?php
echo $index+1;?>
&nbsp;.
<?php
echo CHtml::link(mb_substr($data->name,0,12,'utf-8'),$data->pageUrl,array('style'=>'color:#666;'));
?>
<span class="pull-right" style="color:#999"><?php echo $data->studentNum;?></span>
<div class="clearfix"></div>
</div>
