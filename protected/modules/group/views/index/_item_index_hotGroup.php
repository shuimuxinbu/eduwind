<div class="item">
    <div class="">
        <?php
        $face = CHtml::image($data->xFace, $data->name, array('class'=>'pull-left'));
        echo CHtml::link($face, array('//group/index/view', 'id'=>$data->id), array('class'=>'pic'));
        ?>
    </div>
    <div class="info">
        <?php echo CHtml::link(mb_substr($data->name, 0, 8, 'utf-8'), array('//group/index/view', 'id'=>$data->id), array('class'=>'name')); ?>
        <span><?php echo Yii::t('app','{memberNum} 位 {memberTitle} 在此',array('{memberNum}'=>$data->memberNum,'{memberTitle}'=>$data->memberTitle))?></span>
        <?php echo CHtml::link(Yii::t('app','+ 加入小组'), array('//group/index/view', 'id'=>$data->id), array('class'=>'btn btn-primary pull-right')); ?>
    </div>
    <div class="clearfix"></div>
</div>
