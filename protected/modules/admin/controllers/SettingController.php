<?php

class SettingController extends RController
{
	/**
	 * @var string the default layout for the views. Defaults to '//layouts/column2', meaning
	 * using two-column layout. See 'protected/views/layouts/column2.php'.
	 */
	public $layout='//layouts/admin/nonav_column2';

	/**
	 * @return array action filters
	 */
	public function filters()
	{
		return array(
			'rights',
		);
	}

	public function actions(){
		return array(
			'carousel'=>array('class'=>'application.components.actions.UpdateSettingAction','viewFile'=>'carousel','className'=>'CarouselForm'),
			'openAuth'=>array('class'=>'application.components.actions.UpdateSettingAction','viewFile'=>'open_auth','className'=>'OpenAuthForm'),
			'payment'=>array('class'=>'application.components.actions.UpdateSettingAction','viewFile'=>'payment','className'=>'PaymentForm'),
			'register'=>array('class'=>'application.components.actions.UpdateSettingAction','viewFile'=>'register','className'=>'SRegisterForm'),
		    'upgrade'=>array('class'=>'application.components.actions.UpdateSettingAction','viewFile'=>'upgrade','className'=>'UpgradeForm'),
			'mailer'=>array('class'=>'application.components.actions.UpdateSettingAction','viewFile'=>'mailer','className'=>'MailerForm'),
			'cloudStorage'=>array('class'=>'application.components.actions.UpdateSettingAction','viewFile'=>'cloud_storage','className'=>'CloudStorageForm'),
			'theme'=>array('class'=>'application.components.actions.UpdateSettingAction','viewFile'=>'theme','className'=>'ThemeForm'),
		);
	}

	public function actionSite($power=false){
		$model = new SiteForm();
		$model->getSetting();

		if(isset($_POST['SiteForm'])){
			$logo = $model->logo;
			$model->attributes = $_POST['SiteForm'];

			$uploadFile = CUploadedFile::getInstance($model, 'logo');
			if($uploadFile !== null){
				$uploadFileName = "logo_".time() . '.' . $uploadFile->getExtensionName();
				if(file_exists($model->logo)) unlink(Yii::app()->basePath."/../".$model->logo);
				if(!is_dir(Yii::app()->basePath."/../uploads/setting/site")) DxdUtil::createFolders(Yii::app()->basePath."/../uploads/setting/site");
				$model->logo = 'uploads/setting/site/'.$uploadFileName;
				$uploadFile->saveAs(Yii::app()->basePath."/../".$model->logo);

			}else{
				$model->logo = $logo;
				// unset($model->logo);
			}
			//			var_dump($_POST['SiteForm']);
			if($model->saveSetting()){
				Yii::app()->user->setFlash('success','保存成功！');
			}else{
				Yii::app()->user->setFlash('error','保存失败！');
			}
		}
		if(!$power){
			$this->render('site',array('model'=>$model));
		}else{
			$this->render('power',array('model'=>$model));
		}
	}

	public function getThemes(){
		$themeRoot = Yii::app()->basePath."/../themes";
		$themes=array();
		$themes[] =array('name'=>'default');
		$dir = opendir($themeRoot);
		while(($file=readdir($dir))!==false){
			if($file!="." && $file!=".." && is_dir("$themeRoot/$file")){
				$infoFile = "$themeRoot/$file/info.php";
				if(is_file($infoFile)){
					//					Yii::import($moduleFile);
					$theme = include $infoFile;
					$theme['name'] = $file;
					$themes[] = $theme;
				}
			}
		}
		return $themes;
	}
	public function actionPartner(){
		$model = new PartnerForm();
		$model->getSetting();

		if(isset($_POST['PartnerForm'])){
			$model->attributes = $_POST['PartnerForm'];
			if($model->saveSetting()){
				if($model->config){
					Yii::import('ext.ucenter.MUcenter');
					$ucenter = new MUcenter();
					$ucenter->saveConfig($model->config);
				}
				Yii::app()->user->setFlash('success','保存成功！');
			}else{
				Yii::app()->user->setFlash('error','保存失败！');
			}
		}

			$this->render('partner',array('model'=>$model));
	}
}
