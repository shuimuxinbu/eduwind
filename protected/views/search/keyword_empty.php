<?php
/* @var $this CourseController */
/* @var $dataProvider CActiveDataProvider */

?>
<div class="row ">
<?php

?>
	<div class="col-sm-2">
		<?php $this->renderPartial('_side_nav',array('keyword'=>""));?>
	</div>
	<div class="col-sm-10">

	<?php $this->renderPartial('_form',array('cate'=>'all','keyword'=>""))?>
	</div>
</div>

