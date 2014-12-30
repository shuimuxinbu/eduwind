<div class="text-center" style="width:400px">
    <h3><?php echo Yii::t('app','恭喜你学完了这个课程!');?></h3>
    <?php echo CHtml::link(Yii::t('app','重新学习'), array('//course/lesson/view', 'id'=>$_GET['id']), array('class'=>'btn')); ?>
    <?php
    if (isset($nextLesson)) {
        echo CHtml::link(Yii::t('app','学习下一课时'), array('//course/lesson/view', 'id'=>$nextLesson->id), array('class'=>'btn'));
    } else {
        echo CHtml::link(Yii::t('app','当前已是最未课时'), array(), array('class'=>'btn disabled'));
    }
    ?>
    <br><br>
</div>
