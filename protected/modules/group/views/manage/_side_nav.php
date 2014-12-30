<div style="margin-top: 20px">
<?php $this->widget('booster.widgets.TbMenu', array(
    'type'=>'list',
    'items'=>array(
        array('label'=>Yii::t('app','小组信息')),
        array('label'=>Yii::t('app','基本信息'),'url'=>array('setBasic','id'=>$group->id)),
        array('label'=>'小组头像','url'=>array('uploadFace','id'=>$group->id)),

        array('label'=>Yii::t('app','成员管理')),
        array('label'=>Yii::t('app','成员管理'),'url'=>array('members','id'=>$group->id)),
        array('label'=>Yii::t('app','成员称号'),'url'=>array('title', 'id'=>$group->id)),
    ),
));?>
</div>
