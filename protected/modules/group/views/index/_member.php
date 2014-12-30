<!-- 小组成员 -->
<div class="main-content group-member">
    <!-- 小组管理员 -->
    <div class="admin">
        <div class="student-card">
            <?php
                if($group->user->face):
                    $pic = $group->user->face;
                else:
                    $pic = 'http://placehold.it/80x80';
                endif;

                echo CHtml::image($pic, $group->user->name, array('class'=>'pull-left avatar'));
            ?>
            <div class="info">
                <p class="name">
                    <?php echo CHtml::link($group->superAdmin->name, $group->superAdmin->pageUrl) ?>
                    <small><br><?php echo Yii::t('app','创建人')?></small>
                </p>
                <p class="de">
                    <?php echo $group->superAdmin->bio ?>
                </p>
                <div class="action">
                <?php
                    $user = $group->user;

                    // 私信按钮
                    echo Chtml::link(Yii::t('app','私信'), array('/message/create', 'toUserId'=>$user->id), array('onclick'=>'openFancyBox(this);return false;'));
                    
                    // 关注按钮
                    $isFan = $user->isFan(Yii::app()->user->id);
                    $follow = $isFan ? Yii::t('app','取消关注') : Yii::t('app','关注');
                    $btnClass = 'dxd-user-followed' . $user->id . ' ' . ($isFan ? '':'follow');
                    echo CHtml::link($follow, array('/u/toggleFollow', 'id'=>$user->id), array('onclick'=>'toggleFollow(this);return false;', 'id'=>'dxd-user-followed-'.$user->id, 'class'=>$btnClass));
                ?>
                </div>
            </div>
        </div>
        <div class="info">
            <p>
                <?php echo Yii::t('app','创建日期:')?> <br>
                <small>
                    <?php echo date('Y - m - d H:i A', $group->addTime) ?>
                </small>
            </p>
        </div>
        <div class="clearfix"></div>
    </div>
    
    <!-- 成员列表 -->
    <div class="students">
        <p class="t"><?php echo isset($group->memberTitle) ? $group->memberTitle : Yii::t('app','成员') ?>(<?php echo $group->memberNum ?><?php echo Yii::t('app','人');?>)</p>
        <?php
            $tab3 = $this->widget('booster.widgets.TbListView', array(
                'dataProvider'=>$dataProvider,
                'itemView'=>'_member_item',
                'summaryText'=>false,
                'template'=>'{items}',
                'emptyText'=>Yii::t('app','暂时还没有成员'),
                'pager' =>  array(
                    'class'         =>  'booster.widgets.TbPager',
                    'header'        =>  '',
                    'nextPageLabel' =>  Yii::t('app','下一页'),
                    'prevPageLabel' =>  Yii::t('app','上一页'),
                ),
            ));
        ?>
        <!-- JS控制内容排列-->
        <script type="text/javascript">
            $(document).ready(three());
            function three(){
                var len = $('.student-card').length;
                for(i=1; i<len; i++){
                    if(i%3 == 0){
                        $('.student-card').eq(i).addClass('three');
                    }
                }
            }
        </script>
        <div class="clearfix"></div>
    </div>
</div>
<!-- 分页 -->
<?php 
    $tab3->renderPager();
?>
