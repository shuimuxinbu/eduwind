<?php
/**
 * 取出当前主题首页面数据
 */

$userDataProvider = new CActiveDataProvider(
    'UserInfo',
    array(
        'criteria'  =>  array(
            'order' =>  'addTime desc',
        ),
        'pagination'    =>  array(
            'pageSize'  =>  10,
        )
    )
);

// 文章分类
$articleCategorys = Category::model()->findAll(
    array(
        'condition' =>  'type="article"',
        'order'     =>  'weight desc',
    )
);
array_unshift($articleCategorys, array('name'=>'全部', 'id'=>0));
// 文章数据提供者 全部
$articleDataProviders[]  = new CActiveDataProvider(
    'Article',
    array(
        'criteria'  =>  array(
            'order' =>  'addTime desc',
        ),
        'pagination'    =>  array('pageSize'=>3)
    )
);
// 文章数据提供者 分类
foreach ($articleCategorys as $articleCategory) {
    $articleDataProviders[]  = new CActiveDataProvider(
        'Article',
        array(
            'criteria'  =>  array(
                'condition' =>  'categoryId=' . $articleCategory['id'],
                'order' =>  'addTime desc',
            ),
            'pagination'    =>  array('pageSize'=>3)
        )
    );
}

// 小组数据提供者
$groupDataProvider = new CActiveDataProvider(
    'Group',
    array(
        'criteria'  =>  array(
            'condition' =>  'status="ok"',
            'order' =>  'memberNum desc, addTime desc'
        ),
        'pagination'=>  array(
            'pageSize'=>5
        )
    )
);
// 帖子数据提供者
$postDataProvider = new CActiveDataProvider(
    'Post',
    array(
        'criteria'  =>  array(
            'order'=>'addTime desc'
        ),
        'pagination'    =>  array(
            'pageSize'  =>  4,
        )
    )
);

// 课程分类
$courseCategorys = Category::model()->findAll(
    array(
        'condition' => 'type="course"',
        'limit'     =>  7,
    )
);
array_unshift($courseCategorys, array('name'=>'热门', 'categoryId'=>null, 'id'=>0));
// 课程数据提供者
$courseDataProvider = new CActiveDataProvider(
    'Course',
    array(
        'criteria'  =>  array(
            'order' =>  'viewNum desc, memberNum desc',
        ),
        'pagination'    =>  array(
            'pageSize'  =>  6
        )
    )
);
?>

<div id="edu-home">
    <!-- Section: 课程 -->
    <div class="row panel-course">
        <div class="col-sm-12 hair">
            <?php echo CHtml::link('全部 <i class="icon-angle-right"></i>', array('//course'), array('class'=>'pull-right more')); ?>
            <span class="caption">课程</span>
        </div>
        <div class="col-sm-3 course-nav">
            <ul>
                <?php foreach ($courseCategorys as $k => $courseCategory) : ?>
                    <li class=""><?php echo CHtml::link($courseCategory['name'], array('//course', 'categoryId'=>$courseCategory['id']), array()); ?></li>
                <?php endforeach; ?>
            </ul>
        </div>
        <div class="col-sm-9 body">
            <div class="row">
                <?php $this->widget(
                    'booster.widgets.TbListView',
                    array(
                        'dataProvider'  =>  $courseDataProvider,
                        'itemView'      =>  '_item_course',
                        'template'      =>  '{items}',
                        'emptyText'     =>  '<div class="col-sm-9">该分类暂时未有课程</div>'
                    )
                ); ?>
            </div>
        </div>
    </div>


    <div class="edu-separator-home main-background main-spearate-line"></div>


    <div class="row">
        <!-- Section: 资讯 -->
        <div class="col-sm-9 panel-article">
            <!-- 菜单 -->
            <div class="hair">
                <span class="caption">资讯</span>
                <div class="pull-right more">
                    <?php foreach ($articleCategorys as $k => $articleCategory) {
                        echo CHtml::link($articleCategory['name'], ('#tab-article-' . $k), array('onClick'=>'location.replace("' . CHtml::normalizeUrl(array('//cms/article', 'categoryId'=>$articleCategory['id'])) . '")'));
                    } ?>
                </div>
            </div>
            <!-- 内容 -->
            <div class="body tab-content">
                <?php foreach ($articleDataProviders as $k => $articleDataProvider) : ?>
                <div class="tab-pane" id="tab-article-<?php echo $k; ?>">
                    <?php $this->widget(
                        'booster.widgets.TbListView',
                        array(
                            'dataProvider'  =>  $articleDataProvider,
                            'itemView'      =>  '_item_article',
                            'template'      =>  '{items}',
                            'separator'     =>  '<div class="main-background main-separate-line"></div>',
                        )
                    ); ?>
                </div>
                <?php endforeach; ?>
            </div>
            <script>
            $('.panel-article .hair .more a').tab('show');
            $('.panel-article .hair .more a').mouseover(function (e) {
                e.preventDefault();
                $(this).tab('show');
            })
            </script>
        </div>

        <!-- Section: 用户 -->
        <div class="col-sm-3">
            <div class="panel-user">
                <span class="caption">新注册用户</span>
                <?php $this->widget(
                    'booster.widgets.TbListView',
                    array(
                        'dataProvider'  =>  $userDataProvider,
                        'itemView'      =>  '_item_user',
                        'template'      =>  '{items}',
                        'itemsTagName'  =>  'ul',
                    )
                ); ?>
                <script type="text/javascript" src="<?php echo Yii::app()->theme->baseUrl; ?>/js/jquery.scrollbox.js"></script>
                <script type="text/javascript">
                $(document).ready(function(){
                    $('.panel-user .list-view').scrollbox({
                        switchItems: 1,
                        distance: 90
                    });
                });
                </script>
            </div>
        </div>
    </div>


    <div class="edu-separator-home"></div>


    <div class="row">
        <!-- Section: 社区 -->
        <div class="col-sm-9 panel-post">
            <div class="hair">
                <?php echo CHtml::link('全部 <i class="icon-angle-right"></i>', array('//group/index/list'), array('class'=>'pull-right more')); ?>
                <span class="caption">社区</span>
            </div>
            <div class="body">
                 <?php $this->widget(
                    'booster.widgets.TbListView',
                    array(
                        'dataProvider'  =>  $postDataProvider,
                        'itemView'      =>  '_item_post',
                        'template'      =>  '{items}',
                        'separator'     =>  '<div class="main-background main-separate-line"></div>',
                    )
                ); ?>
            </div>
        </div>

        <!-- Section: 小组 -->
        <div class="col-sm-3">
            <div class="panel-group">
                <span class="caption">热门小组</span>
                <?php $this->widget(
                    'booster.widgets.TbListView',
                    array(
                        'dataProvider'  =>  $groupDataProvider,
                        'itemView'      =>  '_item_group',
                        'template'      =>  '{items}',
                        'separator'     =>  '<div class="edu-separator"></div>',
                    )
                ); ?>
            </div>
        </div>
    </div>


</div>


