
            <h3 class="side-lined">人员分类管理</h3>
<div>
<?php echo CHtml::link('返回',array('index'),array('class'=>'btn btn-default'));?>
</div>
            <!-- 添加文章分类表单 -->
            <?php $this->renderPartial('_form_category', array('model'=>$model)); ?>
            <div class="clearfix"></div>
            <br>


            <!-- 文章分类列表 -->
            <span class="text-error">提示：</span>上下拖动分类可以改变显示顺序
            <br/>
            <?php $this->widget(
                'ext.sortabletree.SortableTree',
                array(
                    'model'=>new Category(),
                    'maxDepth'=>1,
                    'itemViewFile'=>"nestable_item",
                    'criteria'=>array('condition'=>"type='{$type}'", 'order'=>'weight ASC'),
                    'withChildren'=>true,
                	'updateUrl'=>Yii::app()->createUrl('//category/sort'),
                )
            );?>

