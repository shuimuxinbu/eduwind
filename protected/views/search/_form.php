<br/>

<div class="row">
<?php /** @var BootActiveForm $form */
$form = $this->beginWidget('booster.widgets.TbActiveForm', array(
		    'id'=>'searchForm',
			'method'=>'get',
			'action'=>array('//search'),
		    'htmlOptions'=>array(),
)); ?>

    <input type="hidden" name="type" value="<?php echo $_GET['type']; ?>" />

    <div class="form-group col-sm-8">
        <div class="input-group">
            <input type="text" name="keyword" class="search-query form-control" placeHolder="<?php echo Yii::t('app','搜索')?>" value="<?php echo $keyword;?>" />
            <div class="input-group-btn">
                <button class="btn btn-default" type="submit"><i class="icon-search"></i><?php echo Yii::t('app','搜索')?></button>
            </div>
        </div>
    </div>

<?php $this->endWidget(); ?>
</div>

<?php if(!$keyword):?>
	<h5><?php echo Yii::t('app','请输入关键词');?></h5>
<?php endif;?>


