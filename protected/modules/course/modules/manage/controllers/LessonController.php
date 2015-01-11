<?php

class LessonController extends CaController
{
	/**
	 * @var string the default layout for the views. Defaults to '//layouts/column2', meaning
	 * using two-column layout. See 'protected/views/layouts/column2.php'.
	 */
	public $layout='//layouts/column1';

	/**
	 * @return array action filters
	 */
	public function filters()
	{
		return array(
			'accessControl', // perform access control for CRUD operations
		//			'postOnly + delete', // we only allow deletion via POST request
		);
	}

	public function init(){
		if(isset($_POST['SESSION_ID'])){
			$session=Yii::app()->getSession();
			$session->close();
			$session->sessionID = $_POST['SESSION_ID'];
			$session->open();
		}
	}

	/**
	 * Specifies the access control rules.
	 * This method is used by the 'accessControl' filter.
	 * @return array access control rules
	 */
	public function accessRules()
	{
		return array(
		array('allow', // allow authenticated user to perform 'create' and 'update' actions
				'actions'=>array('index','update','togglePublished','publishAll','hideAll','view','create',
								'createMany','delete','upload','link','setMedia','addQuiz','addLecture','order'),
				'expression'=>array($this,'allowOnlyAdmin'),
		),
		array('allow',
			  'actions'=>array('convert'),
			  'users'=>array('*')),
		array('deny',  // deny all users
				'users'=>array('*'),
		),
		);
	}
	/**
	 * 上传课时视频
	 * Enter description here ...
	 */
	public function actionUpload($lessonId) {
		$model = $this->loadModel($lessonId);

		if(isset($_FILES['file']['name'])){
			$fileTypes = array('mp4','flv'); // File extensions
			$fileParts = pathinfo($_FILES['file']['name']);

			if (in_array(strtolower($fileParts['extension']),$fileTypes)) {
				$tempFile = $_FILES['file']['tmp_name'];
				//向uploadfile表中插入记录
				$uploadFile = new UploadFile();
				$uploadFile->userId = Yii::app()->user->id;
				$uploadFile->addTime = time();
				$uploadFile->mime = (CFileHelper::getMimeType($tempFile)?CFileHelper::getMimeType($tempFile):"video/mp4");
				$uploadFile->name = $_FILES['file']['name'];
				$uploadFile->size = $_FILES['file']['size'];
				$uploadFile->storage = 'local';
				$uploadFile->save();
				//得到id，并以此为文件名保存视频文件
				$id = $uploadFile->id;
				$path = 'uploads/uploadFile/Lesson/mediaId';
				if(!is_dir($path))
				mkdir($path,0777,true);
				$path .= '/'.$id.".".$fileParts['extension'];
				move_uploaded_file($tempFile,$path);
				$uploadFile->path = $path;
				$uploadFile->save();
				//清除旧数据
				$model->deleteMedia();
				$model->mediaType = "video";
				$model->mediaId = $uploadFile->getPrimaryKey();
				$model->save();
				//返回mediaId
				//	echo json_encode(array('id'=>$id,'status'=>'success'));
				//echo json_encode($uploadFile->name);
				echo true;
			} else {
				//echo json_encode(array('status'=>'fail'));
				//	echo json_encode(null);
				echo false;
			}
		}
		$this->layout = "/layouts/nonav_column1";
		$this->render('upload_fancy',array('model'=>$model));
	}

	public function actionSetMedia($lessonId){
		$lesson = $this->loadModel($lessonId);
		if(isset($_POST['mediaId'])){
			$name = $_POST['name'];

			$lesson->deleteMedia();
			$lesson->mediaType = "video";
			$lesson->mediaId = $_POST['mediaId'];
			if($lesson->save()) {
				echo true;
				exit;
			}

		}
		echo false;
		exit;
	}
	/**
	 * 添加课程
	 * @param unknown_type $id
	 */
	public function actionCreate($courseId){
		$course = Course::model()->findByPk($courseId);
		$lesson = new Lesson;
		if(isset($_POST['Lesson'])){
			$lesson->attributes = $_POST['Lesson'];
            // 课程时长处理
            if (preg_match('/\d{1,}h\d{1,2}m\d{1,2}s/i', $lesson->duration)) {
                $duration   =   substr($lesson->duration, 0, stripos($lesson->duration, 'h')) * 60 * 60;
                $duration   +=  substr($lesson->duration, stripos($lesson->duration, 'h') + 1, stripos($lesson->duration, 'm') - stripos($lesson->duration, 'h') - 1) * 60;
                $duration   +=  substr($lesson->duration, stripos($lesson->duration, 'm') + 1, stripos($lesson->duration, 's') - stripos($lesson->duration, 'm') - 1);
                $lesson->duration = $duration;
            } else {
                $lesson->duration = 0;
            }
			if($course->addLesson($lesson)){
			Lesson::model()->refreshAllChapterIds($courseId);
				Yii::app()->user->setFlash('success',Yii::t('app','添加成功！'));
			}else{
				Yii::app()->user->setFlash('error',Yii::t('app','添加失败！'));
			}
			$this->redirect(array('index','courseId'=>$lesson->courseId));
		}
		$lesson->courseId = $courseId;
		$this->layout = "/layouts/nonav_column1";
		$this->renderPartial('create_fancy',array('course'=>$course,'lesson'=>$lesson),false,true);
	}

	/**
	 * 修改课时信息
	 * @param unknown_type $id
	 */
	public function actionUpdate($id){
		$lesson =$this->loadModel($id);
		$course = $lesson->course;
        // 处理课程时长
        $duration = $lesson->duration;
        $lesson->duration   =   floor($duration / (60 * 60)) . 'h';
        $lesson->duration   .=  floor($duration % (60 * 60) / 60) . 'm';
        $lesson->duration   .=  floor($duration % (60 * 60) % 60) . 's';
		if(isset($_POST['Lesson'])){
			$lesson->attributes = $_POST['Lesson'];
            // 课程时长处理
            if (preg_match('/\d{1,}h\d{1,2}m\d{1,2}s/i', $lesson->duration)) {
                $duration   =   substr($lesson->duration, 0, stripos($lesson->duration, 'h')) * 60 * 60;
                $duration   +=  substr($lesson->duration, stripos($lesson->duration, 'h') + 1, stripos($lesson->duration, 'm') - stripos($lesson->duration, 'h') - 1) * 60;
                $duration   +=  substr($lesson->duration, stripos($lesson->duration, 'm') + 1, stripos($lesson->duration, 's') - stripos($lesson->duration, 'm') - 1);
                $lesson->duration = $duration;
            } else {
                $lesson->duration = 0;
            }
			if($lesson->save()){
				Lesson::model()->refreshAllChapterIds($course->id);
				Yii::app()->user->setFlash('success',Yii::t('app','保存成功！'));
			}else{
				Yii::app()->user->setFlash('error',Yii::t('app','抱歉！保存失败！'));
			}
			$this->redirect(array('index','courseId'=>$lesson->courseId));
		}
		$this->layout = "/layouts/nonav_column1";
		$this->renderPartial('update_fancy',array('course'=>$course,'lesson'=>$lesson),false,true);
	}
	/**
	 * 修改课时信息
	 * @param unknown_type $id
	 */
	public function actionLink($lessonId){
		$lesson =$this->loadModel($lessonId);
		$mediaLink = $lesson->mediaLink ? $lesson->mediaLink : new MediaLink;

		if(isset($_POST['MediaLink'])){
			$mediaLink->attributes = $_POST['MediaLink'];
			$mediaLink->save();
			$lesson->deleteMedia();
			$lesson->mediaType = "link";
			$lesson->mediaId = $mediaLink->getPrimaryKey();
			if($lesson->save()){
				Yii::app()->user->setFlash('success',Yii::t('app','保存成功！'));
			}else{
				Yii::app()->user->setFlash('error',Yii::t('app','保存失败！'));
			}
			$this->redirect(array('link','lessonId'=>$lessonId));

		}
		$this->layout = "//layouts/nonav_column1";
		$this->render('link_fancy',array('lesson'=>$lesson,'mediaLink'=>$mediaLink));
	}

	/**
	 * 添加多个课时
	 * @param unknown_type $id
	 */
	public function actionIndex($courseId){
		$course = $this->loadCourse($courseId);
		//$lessonDataProvider = $course->getLessonDataProvider(array('pagination'=>array('pageSize'=>200)),false);
		$lessons = Lesson::model()->findAllByAttributes(array('courseId'=>$courseId));
		$chapters = Chapter::model()->findAllByAttributes(array('courseId'=>$courseId));
		$items = array_merge($lessons,$chapters);
		usort($items, array(new LessonSorter,'sortByWeight'));
		//		var_dump($lessonDataProvider->getData());



		$this->render('index',array('course'=>$course,
									  'items'=>$items));
	}

	public function actionOrder($courseId){
		$course = $this->loadCourse($courseId);
		if(isset($_POST['order'])){
			//			$course->orderLessons($_POST['order']);
			$ids = explode(",",$_POST['order']);
			for($i=0;$i<count($ids);$i++){
				if(DxdUtil::startWith($ids[$i], 'lesson-')){
					$id = substr($ids[$i], 7);
					$lesson = Lesson::model()->findbyPk($id);
					$lesson->updateByPk( $id,array("weight"=>$i+1));
				}else{
					$id = substr($ids[$i], 8);
					$chapter= Chapter::model()->findbyPk($id);
					$chapter->updateByPk( $id,array("weight"=>$i+1));
				}
			}
			Chapter::model()->refreshAllNumbers($courseId);
			Lesson::model()->refreshAllNumbers($courseId);
			Lesson::model()->refreshAllChapterIds($courseId);
			Yii::app()->end();
		}
	}

	public function actionCreateMany($courseId){
		$course = $this->loadCourse($courseId);
		if(isset($_POST['playList'])){
			Yii::import('ext.videolink.VideoList');
			$videolist = new VideoList();
			$videos = $videolist->parse($_POST['playList']);
			$result = false;
			foreach($videos as $item){
				$mediaLink = new MediaLink;
				$mediaLink->title = $item['title'];
				$mediaLink->url = $item['url'];
				if($mediaLink->save()){
					$lesson = new Lesson;
					$lesson->title = $mediaLink->title ?  $mediaLink->title :Yii::t('app', "未设置");
					$lesson->mediaType = "link";
					$lesson->mediaId = $mediaLink->id;
					$lesson->courseId = $courseId;
					$result = $lesson->save();
				}
			}
			if($result) Yii::app()->user->setFlash('success',Yii::t('app','操作成功！'));
			else Yii::app()->user->setFlash('error',Yii::t('app','操作失败！'));
		}

		$this->layout = "/layouts/nonav_column1";
		$this->render('create_many_fancy',array('course'=>$course));
	}
	/**
	 * 发布/取消发布 课时
	 * Enter description here ...
	 * @param unknown_type $id
	 */
	public function actionTogglePublished($id){
		$lesson = Lesson::model()->findByPk($id);
		$lesson->status = $lesson->status==Lesson::STATUS_HIDDEN ? Lesson::STATUS_PUBLIC :Lesson::STATUS_HIDDEN;
		if($lesson->save()){
			if($lesson->status==Lesson::STATUS_PUBLIC)
			Yii::app()->user->setFlash('success',Yii::t('app','发布成功'));
			else
			Yii::app()->user->setFlash('success',Yii::t('app','取消发布成功'));
		};
		$this->redirect(array('index','courseId'=>$lesson->courseId));

	}

	public function actionDelete($id){
		$lesson = $this->loadModel($id);
		if($lesson->delete())
		Yii::app()->user->setFlash('success',Yii::t('app','删除成功！'));
		else
		Yii::app()->user->setFlash('error',Yii::t('app','删除失败！'));
		$this->redirect(array('index','courseId'=>$lesson->courseId));
	}

	public function actionView($id){
		$this->redirect(array('//lesson/view','id'=>$id));
	}

	public function actionConvert(){
		$files = UploadFile::model()->findAllByAttributes(array('storage'=>'cloud'));
		$cloud = CloudService::getInstance();
		foreach($files as $file){
			if(!$file->convertKey){
				echo $file->path;
				echo $cloud->convert($file->path);
				echo "\n";
			}
		}
	}

	public function actionPublishAll($courseId){
		$course = $this->loadCourse($courseId);
		$result = true;
		$lessons = Lesson::model()->findAll(array('condition'=>'status='.Lesson::STATUS_HIDDEN));
		foreach($lessons as $lesson){
			if(!$lesson->saveAttributes(array('status'=>Lesson::STATUS_PUBLIC)))
			$result = false;
		}
		if($result)
		Yii::app()->user->setFlash('success',Yii::t('app','操作成功！'));
		else
		Yii::app()->user->setFlash('error',Yii::t('app','操作失败！'));
		$this->redirect(array('index','courseId'=>$course->id));
	}
	public function actionHideAll($courseId){
		$course = $this->loadCourse($courseId);
		$result = true;
		$lessons = Lesson::model()->findAll(array('condition'=>'status='.Lesson::STATUS_PUBLIC));
		foreach($lessons as $lesson){
			if(!$lesson->saveAttributes(array('status'=>Lesson::STATUS_HIDDEN)))
			$result = false;
		}
		if($result)
		Yii::app()->user->setFlash('success',Yii::t('app','操作成功！'));
		else
		Yii::app()->user->setFlash('error',Yii::t('app','操作失败！'));
		$this->redirect(array('index','courseId'=>$course->id));
	}

	public function actionUpdateQuiz($id){
		$lesson = $this->loadModel($id);
		if(!$lesson->quiz){
			$quiz = new Quiz;
			$quiz->save();
			$lesson->deleteMedia();
			$lesson->mediaId = $quiz->getPrimaryKey();
			$lesson->save();
		}
		$this->redirect(array('quiz/view','id'=>$quiz->id));

	}
	/**
	 * Returns the data model based on the primary key given in the GET variable.
	 * If the data model is not found, an HTTP exception will be raised.
	 * @param integer $id the ID of the model to be loaded
	 * @return Lesson the loaded model
	 * @throws CHttpException
	 */
	public function loadModel($id)
	{
		$model=Lesson::model()->findByPk($id);
		if($model===null)
		throw new CHttpException(404,'The requested page does not exist.');
		return $model;
	}


	/**
	 * Performs the AJAX validation.
	 * @param Lesson $model the model to be validated
	 */
	protected function performAjaxValidation($model)
	{
		if(isset($_POST['ajax']) && $_POST['ajax']==='lesson-form')
		{
			echo CActiveForm::validate($model);
			Yii::app()->end();
		}
	}


	/**
	 * 检查权限
	 */
	public function allowOnlyAdmin(){
		if(Yii::app()->user->checkAccess('admin')) return true;
		if(isset($_GET['id']) ) {
			$lesson = $this->loadModel(intval($_GET['id']));
			$course = $lesson->course;
		}elseif(isset($_GET['lessonId']) ) {
			$lesson = $this->loadModel(intval($_GET['lessonId']));
			$course = $lesson->course;
		}else if(isset($_GET['courseId'])){
			$course = $this->loadCourse(intval($_GET['courseId']));
		}
		$member = $course->findMember(array('userId'=>Yii::app()->user->id));
		if($member && $member->inRoles(array('admin','superAdmin'))) return true;
		return false;
	}

}
