<?php
/* @var $this NoticeController */
/* @var $dataProvider CActiveDataProvider */

?>
<div class="row">
	<div class="col-sm-2">
		<?php $this->renderPartial("/me/_side_nav",array('user'=>$user));?>
	</div>
	<div class="col-sm-10">
	<h3 class="side-lined"><?php echo Yii::t('app','提醒')?></h3>
	<?php
	/*$this->widget('booster.widgets.TbMenu', array(
    'type'=>'pills', // '', 'tabs', 'pills' (or 'list')
    'stacked'=>false, // whether this is a stacked menu
    'encodeLabel'=>false,
    'items'=>array(
        array('label'=>'评论'.(isset($uncheckedNums['comment_added'])&&$uncheckedNums['comment_added']>0 ? "<span class=\"badge badge-warning\">". $uncheckedNums['comment_added']:"")."</span>", 'url'=>array('commentAdded')),
        array('label'=>'投票'.(isset($uncheckedNums['vote_added'])&&$uncheckedNums['vote_added']>0 ? "<span class=\"badge badge-warning\">".$uncheckedNums['vote_added']:"")."</span>", 'url'=>array('commentAdded')),
 //       array('label'=>'系统',(isset($uncheckedNums['commentAdded'])&&$uncheckedNums['commentAdded']>0 ? isset($uncheckedNums['commentAdded']):""), 'url'=>array('commentAdded')),
    ),
));
*/
?>

<?php $this->widget('booster.widgets.TbListView', array(
	'dataProvider'=>$dataProvider,
	'itemView'=>'_view',
	'separator'=>'<hr/>'
)); ?>

	</div>
</div>
