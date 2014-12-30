<div class="form-post">
    <?php $form = $this->beginWidget(
        'booster.widgets.TbActiveForm',
        array(
            'action'    =>  array('createInCourse', 'courseId'=>$courseId),
        )
    ); ?>

            <?php echo $form->textArea($model, 'content', array('class'=>'content col-sm-12')); ?>
        <?php echo CHtml::ajaxSubmitButton('发表讨论', array('createInCourse', 'courseId'=>$courseId), array('success'=>'updatePost'), array('class'=>'btn-submit pull-right')); ?>

    <?php $this->endWidget(); ?>

    <div class="clearfix"></div>
</div>

<script type="text/javascript">
function updatePost(data) {
    $('.form-post .content').attr('value', '');
    $('.panel-post').html(data);
}
</script>
