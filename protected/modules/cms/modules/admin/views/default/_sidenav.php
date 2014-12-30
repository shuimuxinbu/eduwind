<div style="margin-top: 40px">

<?php


	$this->widget('booster.widgets.TbMenu', array(
    'type'=>'list',
	'encodeLabel'=>false,
    'items'=>array(
				   array('label'=>'资讯文章','icon'=>'th','url'=>array('article/index'), 'active'=>$this->id==='article'),
				   array('label'=>'单页管理','icon'=>'th','url'=>array('page/index'), 'active'=>$this->id==='page'),
				   array('label'=>'人员展示','icon'=>'th','url'=>array('people/index'), 'active'=>$this->id==='people'),
				   array('label'=>'底部设置','icon'=>'info-sign','url'=>array('footer/index'), 'active'=>$this->id==='footer'),
				   array('label'=>'首页轮播图片','icon'=>'th','url'=>array('carousel/index'), 'active'=>$this->id==='carousel'),
				   array('label'=>'导航栏','icon'=>'road','url'=>array('nav/index'), 'active'=>$this->id==='nav'),
				   array('label'=>'友情链接','icon'=>'hand-up','url'=>array('friendLink/index'), 'active'=>$this->id==='friendLink'),
			//	   array('label'=>'图片上传','icon'=>'picture','url'=>array('picture/index'), 'active'=>$this->id==='picture'),
				   ),
	)); 
?>
</div>
