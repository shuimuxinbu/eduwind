<?php
/* @var $this ArticleController */

Yii::app()->clientScript->registerMetaTag($model->keyWord, 'keyword');
Yii::app()->clientScript->registerMetaTag(mb_substr(strip_tags($model->content), 0, 100, 'utf-8'), 'description');

$category = Category::model()->findByPk($model->categoryId);
// 如果文章未有分类
if (empty($category)) {
    $category = new StdClass();
    $category->name = Yii::t('app','全部');
}
$this->breadcrumbs=array(
    'links' =>  array(
        Yii::t('app','新闻')          =>  array('index'),
        $category->name =>  array('index', 'categoryId'=>$model->categoryId),
        $model->title,
    ),
    'homeLink'=>false,
);
?>

<div class="container ew-news page-article" id="edu-article">
    <div class="row">
        <div class="col-sm-12">
            <?php $this->widget('booster.widgets.TbBreadcrumbs', $this->breadcrumbs); ?>
        </div>
    </div>

    <div class="row">
        <!-- Article -->
        <div class="col-sm-8 news section-content">
            <h2 class="text-center"><?php echo $model->title ?></h2>
            <div class="text-center info">
                <span><?php echo Yii::t('app', '发布时间:');?> <?php echo date('Y-m-d', $model->addTime); ?> </span>
                <span><?php echo Yii::t('app', '阅读数:');?> <?php echo $model->viewNum; ?> </span>
            </div>

            <hr>

            <div class="content">
            <?php echo $model->content; ?>
            </div>

            <!-- JiaThis 分享 -->
            <div style="margin-top: 1em;"></div>
            <?php $this->widget('ext.jiathis.JiaThis', array('line'=>1)); ?>

            <!-- 评论 -->
            <div class="comment">
            <?php $this->renderPartial('_comments', array('model'=>$model)); ?>
            </div>
        </div>

        <!-- Side -->
         <div class="col-sm-4 side" style="margin-top: 20px;">
		<?php $this->renderPartial('_aside',array('hotArticleDataProvider'=>$hotArticleDataProvider));?>
		</div>
    </div>
</div>
