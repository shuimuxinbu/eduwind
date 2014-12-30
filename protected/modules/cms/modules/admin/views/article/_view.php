<?php
?>
<tr>
    <td><?php echo $data->id; ?></td>
    <td>
        <?php echo CHtml::link($data->title, array('//trend/view', 'id'=>$data->id)); ?>
    </td>
    <td><?php echo date('Y-m-d', $data->postTime); ?></td>
    <td><?php echo date('Y-m-d', $data->addTime); ?></td>
    <td>
        <?php
        echo CHtml::link('更新封面图', array('updateCoverPic', 'id'=>$data->id), array('class'=>'btn btn-primary'));
        echo '&nbsp;&nbsp;&nbsp;';
        echo CHtml::link('编辑', array('update', 'id'=>$data->id), array('class'=>'btn btn-primary'));
        echo '&nbsp;&nbsp;&nbsp;';
        echo CHtml::link('删除', array('delete', 'id'=>$data->id), array('class'=>'btn btn-danger'));
        ?>
    </td>
</tr>
