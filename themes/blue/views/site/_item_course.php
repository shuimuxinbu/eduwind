<div class="col-sm-4 edu-course-card">
    <div class="pic">
        <?php
        $face = CHtml::image($data->xFace);
        echo CHtml::link($face, array('//course/index/view', 'id'=>$data->id));
        ?>
    </div>
    <div class="name text-center"><?php echo CHtml::link($data->name, array('//course/index/view', 'id'=>$data->id), array('class'=>'main-color')); ?></div>
</div>
