<!DOCTYPE html>
<html lang="zh-CN">
<head>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8">
    <meta name="renderer" content="webkit">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no">

    <title><?php echo CHtml::encode($this->pageTitle); ?></title>
    <link rel="stylesheet" href="<?php echo Yii::app()->baseUrl; ?>/css/font-awesome.min.css">
    <link rel="stylesheet" href="<?php echo Yii::app()->baseUrl; ?>/css/less/legacy/legacy.min.css">
    <link rel="stylesheet" href="<?php echo Yii::app()->baseUrl; ?>/css/style.min.css">
    <script type="text/javascript" src="<?php echo Yii::app()->baseUrl; ?>/js/function.js"></script>
    <script type="text/javascript" src="<?php echo Yii::app()->baseUrl; ?>/js/respond.min.js"></script>


    <!-- 加载主题的 style 和 javascript -->
    <?php if(Yii::app()->theme) : ?>
        <?php if(is_file(Yii::app()->theme->basePath . '/css/style.min.css')) : ?>
            <link rel="stylesheet" href="<?php echo Yii::app()->theme->baseUrl; ?>/css/style.min.css">
        <?php endif; ?>
        <?php if(is_file(Yii::app()->theme->basePath . '/js/function.js')) : ?>
            <script type="text/javascript" src="<?php echo Yii::app()->theme->baseUrl; ?>/js/function.js"></script>
        <?php endif; ?>
    <?php endif; ?>
</head>

<body>
    <!-- EduWind 头部 -->
    <div id="edu-header">
        <div class="head-bar section-head-bar hidden-xs">
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

        <!-- 导航 -->
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
                'brand'=>'EduWind',
                'fixed'=>false,
                'htmlOptions'=>array('style'=>'margin-bottom:0;', 'class'=>''),
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
        <!-- 全部课程分类 -->
        <div class="course-category hidden-xs">
            <div class="container">
                <div class="course-category-inner">
                    <div style="margin-bottom:35px">
                        <div style="font-size:2em" class="pull-left"> <?php echo Yii::t('app','全部课程分类');?></div>
                        <?php echo CHtml::link(Yii::t('app','查看全部 》'),array('/course/index'),array('class'=>'theme-color pull-right' ))?>
                        <div class="clearfix"></div>
                    </div>
                    <div class="course-category-list">
                        <?php $categorys = Course::model()->getCategorys(array('condition'=>'parentId=0 and type="course"'));?>
                        <?php
                        foreach($categorys as $category):
                        echo CHtml::link($category->name,array('/course/index','categoryId'=>$category->id),array('class'=>'category-btn btn', 'style'=>'margin-bottom:8px;'));
                        endforeach;
                        ?>
                    </div>
                </div>
            </div>
        </div>
    <?php endif;?>


    <!-- EduWind 主要内容 -->
    <?php echo $content; ?>


    <!-- EduWind 底部 -->
    <div class="clearfix"></div>
    <div class="light-green-background">
        <div class="container">
            <div class="row">
                        <?php
                            $footer = SystemSetting::model()->find('name="footer"');
                            if (isset($footer->value)) {
                                $footer = json_decode($footer->value, true);
                                echo $footer['html'];
                            }
                        ?>
            </div>
        </div>
    </div>

    <div class="green-background">
        <div class="container">
            <div class="row">
                <div class="col-sm-11 col-sm-offset-1">
                    <div style="padding:15px 0;color:white;">
                        Powered by
                        <strong>
                            <?php if(isset($sysSettings['site']['poweredBy'])){
                                echo CHtml::link($sysSettings['site']['poweredBy'],$sysSettings['site']['poweredByUrl'],array('style'=>'color:white;'));
                            }else{
                                echo CHtml::link("EduWind","http://eduwind.com",array('style'=>'color:white;'));
                            } ?>
                        </strong>
                        &nbsp;&nbsp;<?php echo Yii::app()->params['settings']['site']['icp'];?>
                        &nbsp;&nbsp;&nbsp; Copyright &copy; <?php echo "2013-".date('Y'); ?>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- 代码统计 -->
    <div class="section-analytic">
        <?php if(isset(Yii::app()->params['settings']['site']['analytic'])) echo Yii::app()->params['settings']['site']['analytic']; ?>
    </div>


    <!-- 激活一些页面中可能需要使用的功能小部件 -->
    <?php $this->widget('ext.hoverCard.HoverCard',array('target'=>'.dxd-username,.dxd-userface','config'=>array('url'=>Yii::app()->createUrl('u/hovercard'))));?>
    <?php if(!Yii::app()->user->isGuest) $this->widget('ext.hoverCard.HoverCard',array('target'=>'.dxd-notice','config'=>array('url'=>Yii::app()->createUrl('notice/hovercard'))));?>
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
