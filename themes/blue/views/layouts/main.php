<!DOCTYPE html>
<html lang="zh-CN">
<head>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="renderer" content="webkit">
    <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no">

    <title><?php echo CHtml::encode($this->pageTitle); ?></title>
    <link rel="stylesheet" href="<?php echo Yii::app()->baseUrl; ?>/css/font-awesome.min.css">
    <link rel="stylesheet" href="<?php echo Yii::app()->baseUrl; ?>/css/style.min.css">
    <link rel="stylesheet" href="<?php echo Yii::app()->baseUrl; ?>/css/less.min.css">
    <script type="text/javascript" src="<?php echo Yii::app()->baseUrl; ?>/js/function.js"></script>

    <!-- 加载主题的 style 和 javascript -->
    <?php if(Yii::app()->theme) : ?>
        <?php if(is_file(Yii::app()->theme->basePath . '/css/style.min.css')) : ?>
            <!-- <link rel="stylesheet" href="<?php echo Yii::app()->theme->baseUrl; ?>/css/style.min.css"> -->
        <?php endif; ?>
        <?php if(is_file(Yii::app()->theme->basePath . '/js/function.js')) : ?>
            <script type="text/javascript" src="<?php echo Yii::app()->theme->baseUrl; ?>/js/function.js"></script>
        <?php endif; ?>
    <?php endif; ?>

    <!-- 加载开发使用的 style 和 javascript -->
    <script>less = {env: 'development'}</script>
    <!-- dev use --><link rel="stylesheet/less" type="text/css" href="<?php echo Yii::app()->theme->baseUrl; ?>/css/less/bootstrap.less">
    <!-- dev use --><script type="text/javascript" src="<?php echo Yii::app()->baseUrl; ?>/css/less/other/less.js"></script>
</head>

<body>
    <!-- EduWind 头部 -->
    <div id="edu-header">
        <div class="head-bar section-head-bar">
            <div class="container">
                <div class="" style="padding-top:26px">
                    <form class="pull-right hidden-xs ew-search-form"  method="get" action="<?php echo Yii::app()->createUrl('//search/index');?>">
                        <div class="input-append">
                            <input type="hidden" name="r" value="search/index" />
                            <input type="hidden" name="type" value="all" />
                            <input type="text" name="keyword" class="keyword" placeholder="<?php echo Yii::t('app','搜索');?>" >
                            <button class="btn" type="submit" ><i class="icon-search icon-white"></i></button>
                        </div>
                    </form>
                </div>
                <div class="">
                    <?php
                    global $sysSettings;
                    if (isset($sysSettings['site']['logo'])) :
                        $img=CHtml::image(Yii::app()->baseUrl."/".$sysSettings['site']['logo'],"",array('style'=>'height:46px;margin-top:-4px;'));
                        echo CHtml::link($img,Yii::app()->baseUrl."/");
                    endif;
                    ?>
                </div>
            </div>
        </div>
        <div class="clearfix"></div>


        <!-- Main-nav -->
        <div class="ew-navigation main-nav">
            <?php
            $noticeLabel = Yii::t('app',"提醒");
            $messageLabel = Yii::t('app',"私信");
            if(!Yii::app()->user->isGuest){
                $me = UserInfo::model()->with('unisCheckedMessageCount','unisCheckedNoticeCount')->findByPk(Yii::app()->user->id);
                if(!empty($me) && $me->unisCheckedNoticeCount>0 && !(Yii::app()->controller->id=="notice") ){
                    $noticeLabel.=  '&nbsp;<span class="badge badge-warning">'.$me->unisCheckedNoticeCount.'</span>';
                }
                $noticeLabel = '<span class="dxd-notice">'.$noticeLabel.'</span>';
                if(!empty($me) && $me->unisCheckedMessageCount>0 && !(Yii::app()->controller->id=="message"))
                    $messageLabel.=  '&nbsp;<span class="badge badge-warning">'.$me->unisCheckedMessageCount.'</span>';
            }else{
            }
            $items=Nav::getTopItems();
            ?>
            <?php $this->widget('booster.widgets.TbNavbar', array(
                'brand'=>false,
                'fixed'=>false,
                'htmlOptions'=>array('style'=>'margin-bottom:0;'),
                'items'=>array(
                    array(
                        'class'=>'booster.widgets.TbMenu',
                        'type'  =>  'navbar',
                        'encodeLabel'=>false,
                        'items'=>$items,
                        'htmlOptions'=>array('class'=>''),
                    ),
                    array(
                        'class'=>'booster.widgets.TbMenu',
                        'htmlOptions'=>array('class'=>'pull-right launchpad hidden-xs'),
                        'type'  =>  'navbar',
                        'items'=>array(
                            array(
                                'url'=>array('//notice/index'),
                                'visible'=>!Yii::app()->user->isGuest,
                                'label'=>$noticeLabel,
                                'active'=>$this->activeMenu=='notice',
                                'class'=>'dxd-notice-link',
                                'htmlOptions'=>array('class'=>'dxd-notice-link'),
                            ),
                            array(
                                'url'=>array('//message/index'),
                                'visible'=>!Yii::app()->user->isGuest,
                                'label'=>$messageLabel,
                                'active'=>$this->activeMenu=='message',
                            ),
                            array(
                                'label'=>(isset(Yii::app()->user->displayName)?Yii::app()->user->displayName:""),
                                'url'=>'#',
                                'visible'=>!Yii::app()->user->isGuest,
                                'items'=>array(
                                     array('label'=>Yii::t('app','我的课程'), 'url'=>array('//course/me'),'active'=>false),
                                    array('label'=>Yii::t('app','设置'), 'url'=>array('//me/setBasic')),
                                    '---',
                                    array('label'=>Yii::t('app','退出'), 'url'=>array('//u/logout'),'htmlOptions'=>array('class'=>'dxd-logout-link')),
                                )
                            ),
                            array(
                                'label'=>Yii::t('app','后台管理'),
                                'url'=>(Yii::app()->user->checkAccess('admin') ? array('//admin'):""),
                                'visible'=>Yii::app()->user->checkAccess('admin'),
                                'visible'=>Yii::app()->user->checkAccess('admin')
                            ),

                            array('label'=>Yii::t('app','注册'),'url'=>array('//u/register'),'visible'=>Yii::app()->user->isGuest),
                            array('label'=>Yii::t('app','登陆'),'url'=>array('//u/login'),'visible'=>Yii::app()->user->isGuest),
                        ),
                        'encodeLabel'=>false,
                    ),
                ),
            )); ?>
        </div>
    </div>


    <!-- Flash 通知信息 -->
    <?php $this->renderPartial('//layouts/_flash_messages');?>

    <?php if (Yii::app()->controller->id=="site" && Yii::app()->controller->action->id=="index") : ?>
        <!-- 轮播图 -->
        <div class="hidden-xs main-carousel">
            <?php
            $carousels = Carousel::model()->findAll(array('order'=>'weight asc'));
            $carourseItems = array();
            foreach($carousels as $carousel){
                $item = array();
                $item['image'] = Yii::app()->baseUrl."/".$carousel->path;
                $item['imageOptions'] =array('style'=>"width:100%;");
                if($carousel->url) $item['url'] = $carousel->url;
                if($carousel->course) {
                    $item['label'] = CHtml::link($carousel->course->name,$carousel->course->pageUrl);
                    $item['url'] =$carousel->course->pageUrl;
                }
                $carourseItems[] = $item;
            }
            if (count($carourseItems) > 0) {
                $this->widget('booster.widgets.TbCarousel', array(
                    'items'=>$carourseItems,
                    'displayPrevAndNext'=>true,
                    'prevLabel'=>false,
                    'nextLabel'=>false,
                ));
            }
            ?>
        </div>
    <?php endif; ?>


<!-- Content 主要内容 -->
<?php echo $content; ?>


<!-- Footer 底部 -->
<div class="clearfix"></div>
<div id="edu-footer">
    <?php if ($this->activeMenu==='site') : ?>
    <!-- Section: 友情链接 -->
    <div class="links">
        <div class="container">
            <div class="row">
                <div class="col-sm-12">
                    <span class="tag">友情链接</span>
                    <?php
                    $links = FriendLink::model()->findAll();
                    foreach ($links as $link) {
                        echo CHtml::link($link->title, $link->url, array('target'=>'_blank'));
                    }
                    ?>
                </div>
            </div>
        </div>
    </div>
    <?php endif; ?>

    <!-- Section: 底部文本内容 -->
    <div class="footer-text main-background">
        <div class="container">
            <div class="row">
                <?php
                    Yii::import('application.modules.cms.models.Page');
                    $pageModel = Page::model();
                    $pageCategorys = $pageModel->getCategorys(array());

                    // 遍历Page分类
                    foreach ($pageCategorys as $k => $pageCategory) {
                        if ($k===4) break;
                        $pages = $pageModel->findAll(
                            array(
                                'condition' =>  'categoryId=' . $pageCategory->id,
                                'limit'     =>  4,
                                'order'     =>  'weight ASC',
                            )
                        );
                        echo '<div class="col-sm-3">';
                        echo '<span class="tag">' . $pageCategory->name . '</span>';
                        // 遍历Page
                        foreach ($pages as $page) {
                            echo CHtml::link($page->title);
                        }
                        echo '</div>';
                    }
                ?>
            </div>
            <div class="row">
                <div class="col-sm-12 text-center edu-copyright">
                    Powered by eduwind
                </div>
            </div>
        </div>
    </div>

    <!-- 代码统计 -->
    <div class="edu-analytic">
        <?php if(isset(Yii::app()->params['settings']['site']['analytic'])) echo Yii::app()->params['settings']['site']['analytic']; ?>
    </div>
</div>

<?php $this->widget('ext.hoverCard.HoverCard',array('target'=>'.dxd-username,.dxd-userface','config'=>array('url'=>Yii::app()->createUrl('u/hovercard'))));?>
<?php if(!Yii::app()->user->isGuest) $this->widget('ext.hoverCard.HoverCard',array('target'=>'.dxd-notice','config'=>array('url'=>Yii::app()->createUrl('notice/hovercard'))));?>

<!-- 模态框 -->
<?php $this->widget('application.extensions.fancybox.EFancyBox', array(
    'target'=>'.dxd-fancy-elem',
    'config'=>array(
        'type'=>'iframe',
        'hideOnOverlayClick'=>false,
        'fitToView'   => false,
        'autoSize'    => true,
        'closeClick'  => false,
        'openEffect'  => 'none',
        'closeEffect' => 'none',
        'onClosed'=>'js:function(){window.location.reload();}'
    ),
)); ?>

<?php $this->widget('ext.kindeditor.KindEditor', array()); ?>


</body>
</html>
