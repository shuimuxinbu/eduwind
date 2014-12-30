	<h3 class="side-lined">文章管理</h3>
            <?php echo CHtml::link('添加文章', array('create'), array('class'=>'btn btn-primary')); ?>
            <?php echo CHtml::link('分类管理', array('category'), array('class'=>'btn')); ?>

            <?php
            $options = array(
                'class'     =>  'booster.widgets.TbButtonColumn',
                'template'  =>  '{coverpic} {top} {untop} {update} {delete}',
                'buttons'   =>  array(
                    'coverpic'  =>  array(
                        'label'     =>  '<i class="glyphicon glyphicon-picture"></i>',
                        'options'   =>  array('title'=>'封面图'),
                        'url'       =>  'YII::app()->getController()->createUrl("uploadFace", array("id"=>$data->id))',
                    ),
                    'top'   =>  array(
                        'label'     =>  '<i class="glyphicon glyphicon-arrow-up"></i>',
                        'options'   =>  array('title'=>'置顶'),
                        'url'       =>  'YII::app()->getController()->createUrl("setTop", array("id"=>$data->id, "isTop"=>1))',
                        'visible'   =>  '$data->isTop==0',
                    ),
                    'untop'   =>  array(
                        'label'     =>  '<i class="glyphicon glyphicon-arrow-down"></i>',
                        'options'   =>  array('title'=>'取消置顶'),
                        'url'       =>  'YII::app()->getController()->createUrl("setTop", array("id"=>$data->id, "isTop"=>0))',
                        'visible'   =>  '$data->isTop>0',
                    )
                )
            );
            ?>
            <?php $this->widget('booster.widgets.TbGridView', array(
                'id'    =>  'article-grid',
                'dataProvider'  =>  $model->search(),
                'filter'        =>  $model,
                'columns'       =>  array('id', 'title', 'keyWord', $options)
            )); ?>


<style>
th.button-column {
    width: 120px !important;
}
</style>
