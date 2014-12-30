<?php
/* @var $this ContactController */
/* @var $dataProvider CActiveDataProvider */

?>
<div class="container">
<div class="row">
	<div class="col-sm-2" >
		<?php $this->renderPartial("/index/_side_nav");?>
	</div>
	<div class="col-sm-10">
		<h3 class="side-lined">修改分类</h3>
            <?php $this->renderPartial('_form',array('model'=>$model));?>
	</div>
</div>
</div>
