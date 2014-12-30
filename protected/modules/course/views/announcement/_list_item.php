<div style="">
    <div  ><?php echo $data->content; ?></div>
    <?php empty($data->upTime) ? $time=$data->addTime : $time=$data->upTime; ?>
    <p style="font-size:0.9em; color:#AAA; margin-top:5px;"><?php echo Yii::t('app','发布日期:');?>&nbsp; <?php echo date('Y-m-d', $time); ?></p>
</div>
