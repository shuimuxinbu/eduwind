<?php
/* @var $this TeacherController */

$this->breadcrumbs=array(
	'Teacher',
);
?>

<div class="ew-teacher row">
    <div class="col-sm-12">
        <div class="small-menu">
            <?php $this->renderPartial('_nav', array('categorys'=>$categorys)); ?>
        </div>
    </div>

    <div class="items col-sm-12">
        <?php $this->widget(
            'booster.widgets.TbListView',
            array(
                'dataProvider'  =>  $dataProvider,
            	'template'=>'{items}{pager}',
                'itemView'      =>  '_view',
                'separator'     =>  '<hr>',
            )
        ); ?>
    </div>
</div>
<br/><br/>
