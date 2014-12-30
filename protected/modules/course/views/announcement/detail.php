<h3 class="dxd-fancybox-header"><?php echo Yii::t('app','公告详情');?></h3>
<div class="dxd-fancybox-body" style="width:400px; min-height: 100px; padding-bottom:1.5em; position:relative">
    <p> <?php echo $announcement->content; ?> </p>
    <?php empty($announcemnt->upTIme) ? $aTime=$announcement->addTime : $aTime=$announcement->upTime; ?>
    <p style="position:absolute; bottom:0; right:0;"><?php echo Yii::t('app','公告时间:')?>&nbsp; <?php echo date('Y-m-d', $aTime); ?></p>
</div>
<div class="dxd-fancybox-footer"> </div>
