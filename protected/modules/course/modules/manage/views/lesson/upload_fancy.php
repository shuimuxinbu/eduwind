<h3 class="dxd-fancybox-header"><?php echo Yii::t('app','上传文件');?></h3>
<div class="dxd-fancybox-body">

<?php
$cloudStorageForm = new CloudStorageForm();
$cloudStorageForm->getSetting();
$storage = $cloudStorageForm->storage;
?>

	<br />

	<div id="dxd-for-self"
		class="dxd-media-source <?php if($model->mediaSource!="self") echo 'dxd-hidden';?>">

		<?php
		if ($storage == 'cloud') {
			//$assetUrl = Yii::app()->getAssetManager()->publish(Yii::getPathOfAlias('ext.EWcloudjs.assets'));

			$cloudService = CloudService::getInstance("uploads/uploadFile/lesson/mediaId/".DxdUtil::randCode(32));

			if ($cloudService->authBucket()) {
				$this->widget('ext.ewplupload.ewplupload',array(
					'sourceUrl'=>$cloudService->getSourceUrl(),
					'uploadToken'=>$cloudService->makeUploadToken(),
					'key'=>$cloudService->getKey(),
					'mediaUrl'=>$this->createAbsoluteUrl('setMedia',array('lessonId'=>$model->id)),
					'modelId'=>$model->id,
					'chunk_size'=>'4mb',
				));

				
			}else {
				echo Yii::t('app',"请通过EduWind官网申请并配置您的云存储。");
			}
			
		}
		else {
			$this->widget('ext.ewplupload.ewplupload',array(
				'modelId'=>$model->id,
				'url'=>$this->createUrl('upload',array('lessonId'=>$model->id)),
			));

		}
		//	echo $form->hiddenField($model,'mediaId',array('id'=>'mediaId'));
		?>
		<!-- 
    <div><pre><p id="uploadFileName" class="text-center text-info">还没有选择文件</p></pre></div>
     -->
		<br /> <em id='uploaded-file-<?php echo $model->id;?>'> <?php if($model->file): echo Yii::t('app',"已上传文件: ").$model->file->name;?>
		<?php else: echo Yii::t('app',"暂无上传文件");
		endif;
		?> </em>
	</div>

</div>

<div class="dxd-fancybox-footer"></div>
