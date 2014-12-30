<h3 class="side-lined">单页分类管理</h3>
<?php $this->renderPartial('_head_nav'); ?>

            <!-- 添加文章分类表单 -->
            <?php $form = $this->beginWidget(
                'booster.widgets.TbActiveForm',
                array(
                    'id'=>'inlineForm',
                    'type'=>'inline',
                    'htmlOptions'=>array('class'=>''
                ),
            )); ?>

                <?php echo $form->textFieldGroup($model, 'name', array('class'=>'mr10')); ?>
                <?php  echo $form->hiddenField($model, 'type', array('value'=>$type)); ?>
                <?php $this->widget('booster.widgets.TbButton', array('buttonType'=>'submit', 'label'=>'添加分类')); ?>

            <?php $this->endWidget(); ?>
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
                    'criteria'=>array('condition'=>'type="'.$type.'"', 'order'=>'weight'),
                     'withChildren'=>true,
                	'updateUrl'=>Yii::app()->createUrl('//category/sort'),
                )
            );?>
        </div>
