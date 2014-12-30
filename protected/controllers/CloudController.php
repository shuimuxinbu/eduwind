<?php
class CloudController extends Controller
{
	public $layout='//layouts/column1';

	/**
	 * @return array action filters
	 */
	public function filters()
	{
		return array(
			'accessControl', // perform access control for CRUD operations
		);
	}
	public function accessRules()
	{
		return array(
		array('allow',  // allow all users to perform 'index' and 'view' actions
					'actions'=>array('uploadCallback','persistentNotify'),
					'users'=>array('*'),
		),
		array('allow',
				'actions'=>array('uploadUrl'),
				'users'=>array('@'),
		),
		array('deny',  // deny all users
					'users'=>array('*'),
		),
		);
	}

	public function actionUploadCallback(){
		//接收到文件名和key，向upload_file表中插入一条数据
		//echo json_encode(array('name'=>$_POST['name'],'key'=>$_POST['key']));
		$uploadFile = UploadFile::model()->findByAttributes(array('path'=>$_POST['key']));
		if(!$uploadFile){
			$uploadFile = new UploadFile();
		}
		$uploadFile->userId = $_POST['userId'];
		$uploadFile->addTime = time();
		$uploadFile->path = $_POST['key'];
		$uploadFile->mime = $_POST['mime'];
		$uploadFile->name = $_POST['name'];
		$uploadFile->size = $_POST['size'];
		$uploadFile->storage = 'cloud';
		$uploadFile->save();

		echo json_encode(array('id'=>$uploadFile->id));
		//返回插入后的Id。
	}
	public function actionUploadUrl(){
		//首先应该判断是否有上传资格，如果没有，不返回
		//改为从CloudService取得，并从home取得
		echo json_encode(array('url'=>CloudService::getInstance()->getUploadUrl()));
	}

	public function actionPersistentNotify(){
		$result = json_decode(file_get_contents("php://input"));
		foreach($result->items as $item){
			$key = substr($item->key,0,strlen($item->key)-5);
			$uploadFile = UploadFile::model()->findByAttributes(array('path'=>$key));
				
			if($uploadFile){
					
				if($item->code==0) {
					$uploadFile->convertStatus = "success";
				}else if($item->code==1){
					$uploadFile->convertStatus = "waiting";
				} else if($item->code==2){
					$uploadFile->convertStatus = "doing";
				} else if($item->code==3 || $item->code==4) {
					$uploadFile->convertStatus="error";
					error_log(print_r($item,true));
				}
				$uploadFile->convertKey = "$key.m3u8";

				//	error_log(print_r($uploadFile,true));

				if($uploadFile->save()){
					//		error_log('s');
				}else{
					error_log('fail in persistentNotify');
				}


			}
		}
	}
}