<div class="form-rate">
    <?php $form = $this->beginWidget(
        'booster.widgets.TbActiveForm',
        array(
            'action'    =>  array('index/createRate', 'courseId'=>$courseId),
        )
    ); ?>

        <?php echo $form->textArea($model, 'content', array('class'=>'content col-sm-12')); ?>
        <?php $this->widget(
            'CStarRating',
            array(
                'model' =>  $model,
                'attribute' =>  'score',
                'minRating' =>  2,
                'maxRating' =>  10,
                'ratingStepSize'    =>  2,
                'starCount' =>  5,
                'allowEmpty'=>  false,
                'titles'    =>  array(2=>Yii::t('app', '很差'), 4=>Yii::t('app', '较差'), 6=>Yii::t('app', '还行'), 8=>Yii::t('app', '推荐'),10=>Yii::t('app', '力荐')),
                'readOnly'  =>  false,
            )
        ); ?>
        <?php echo CHtml::ajaxSubmitButton(Yii::t('app', '发表评论'), array('index/createRate', 'id'=>$courseId), array('success'=>'updateRate'), array('class'=>'btn-submit pull-right')); ?>

    <?php $this->endWidget(); ?>

    <div class="clearfix"></div>
</div>

<script type="text/javascript">
function updateRate(data) {
    $('.form-rate .content').attr('value', '');
    $('.panel-rate').html(data);
}
</script>
