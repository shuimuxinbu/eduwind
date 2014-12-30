<div class="row">
    <?php $this->renderPartial('_side_nav', array('model'=>$model)); ?>

    <div class="col-sm-10">
    <h2><?php echo $model->title;?></h2>
    <hr/>
    <?php echo $model->content;?>
    </div>
</div>
