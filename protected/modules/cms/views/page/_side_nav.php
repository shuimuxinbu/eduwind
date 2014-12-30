<div class="col-sm-2">
    <div class="well">
        <ul class="nav nav-list">
            <?php
            $categorys = $model->getCategorys(array());
            foreach ($categorys as $category) {
                // Page 分类
                echo '<li class="nav-header" style="font-size:14px">' . $category->name . '</li>';

                // Page 项目
                $pages = $model->findAll('categoryId=' . $category->id);
                foreach ($pages as $page) {
                    $active = $page->id === $_GET['id'] ? 'active' : '';
                    echo '<li class="nav-header ' . $active . '">' . CHtml::link($page->title, array('//cms/page/view', 'id'=>$page->id)) . '</li>';
                }

                echo '<li class="divider"></li>';
            }
            ?>
        </ul>
    </div>
</div>
