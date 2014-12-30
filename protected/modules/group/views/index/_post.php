<div class="main-content group-discuss">
    <!-- 小组讨论区 -->
    <?php
        // 页面跳转HTML代码
 /*       $summaryData = '
            <form action="./" method="get" class="pull-right page-jump">
                <input type="hidden" name="r" value="'. $_GET['r'] .'">
                <input type="hidden" name="id" value="'. $_GET['id'] .'">
                共 {page} 页 &nbsp;&nbsp;&nbsp;
                到 <input class="input" type="text" name="Post_page"> 页 &nbsp;&nbsp;&nbsp;
                <input class="btn" type="submit" value="确定">
            </form>
        ';*/

        $data = $this->widget('booster.widgets.TbListView', array(
            'dataProvider'  =>  $dataProvider,
            'itemView'      =>  '_post_item',
            'template'      =>  '{items}{pager}',
            'pagerCssClass' =>  'pagination',
            'pager' =>  array(
                'class'         =>  'booster.widgets.TbPager',
                'header'        =>  '',
                'nextPageLabel' =>  Yii::t('app','下一页'),
                'prevPageLabel' =>  Yii::t('app','上一页'),
                'maxButtonCount'=>  5,
            ),
        ));
    ?>

    <!-- JS控制内容行颜色效果-->
    <script type="text/javascript">
        $(document).ready(function(){
            $('.item:even').addClass('even');
        });
        $(document).ajaxSuccess(function(){
            $('.item:even').addClass('even');
        });
    </script>
</div>
