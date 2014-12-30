
            <h2>上传人员头像</h2>
            <hr/>
            <div class="col-sm-6 center dxd-set-face">
                <p>请上传文章封面</p>
                <ul>
                <li>支持图片格式为*.png,*.jpg,*.jpeg，大小不能超过2MB；</li>
                </ul>
                <p></p>

                <?php

                $form=$this->beginWidget('booster.widgets.TbActiveForm', array(
                    'id'=>'course-form',
                    'enableAjaxValidation'=>false,
                    'htmlOptions' => array(
                        'enctype' => 'multipart/form-data'
                    )
                ));
                $this->widget('ext.jcrop.EJcrop', array(
                    //
                    // Image URL
                //    'url' => $this->createAbsoluteUrl('/path/to/full/image.jpg'),
                    'url'=>Yii::app()->baseUrl."/".$model->face,
                    //
                    // ALT text for the image
                    'alt' => 'Crop This Image',
                    'boxHeight'=>200,
                    //
                    // options for the IMG element
                    'htmlOptions' => array('id' => 'imageId'),
                    //
                    'options' => array(
                        'minSize' => array(50, 50),
                        'aspectRatio' => 1,
                        'onRelease' => "js:function() {ejcrop_cancelCrop(this);}",
                    ),
                    'setSelect'=>array(0,0,120,120),
                ));

                ?>
                <div class="pull-right">
                <?php $this->widget('booster.widgets.TbButton',array('label'=>'完成','buttonType'=>'submit','context'=>'success'));?>

                <?php //echo CHtml::link('跳过',Yii::app()->baseUrl);?>&nbsp;
                <?php //echo CHtml::link('完成',Yii::app()->baseUrl,array('class'=>'btn btn-success ml10'));?>

                </div>
                <?php $this->endWidget();?>
            </div>

