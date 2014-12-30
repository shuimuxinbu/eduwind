<div class="item">
    <?php
    // 头像优先级 人员头像 > 用户头像 > 默认头像
    $face = 'http://placehold.it/120x120';
    if(isset($data->user['face'])) $face = Yii::app()->baseUrl .'/'. $data->user['face'];
    if(isset($data->face)) $face = Yii::app()->baseUrl .'/'. $data->face;
    ?>
    <img class="pull-right face" src="<?php echo $face; ?>">
    <div class="info">
        <h3 class="name"><?php echo $data->name; ?> <small></small></h3>
        <p class="description"><?php echo mb_substr($data->description, 0, 220, 'utf-8'); ?></p>
    </div>
    <div class="clearfix"></div>
</div>
