<li>
    <div class="dxd-hover-show-container">
        <span style="display:inline-block; line-height:20px !important; margin-top:8px;"><?php echo $data->content; ?></span>
        
        <p  style="line-height:12px">
            <?php isset($data->upTime) ? $time=$data->upTime : $time=$data->addTime; ?>
            <?php echo Yii::t('app','时间:');?>&nbsp; <?php echo date('Y-m-d', $time); ?>
            <!-- 编辑按钮 -->
            <span class="pull-right">
                <?php
                echo CHtml::link('<i class="icon-pencil"></i>'.Yii::t('app','编辑'), array('update', 'id'=>$data->id, 'courseId'=>$data->courseId), array('class'=>'ml10', 'onclick'=>'openFancyBox(this);return false;', 'data-fancywidth'=>'700', 'data-fancyheight'=>'350'));
                echo CHtml::link('<i class="icon-trash"></i>'.Yii::t('app','删除'), array('delete', 'id'=>$data->id, 'courseId'=>$data->courseId), array('class'=>'ml10'));
                ?>
            </span>
        </p>
        <div class="clearfix"></div>
    </div>
</li>
