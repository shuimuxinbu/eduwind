<?php
class AddPostAction extends CAction{
	/**
	 * 更新一个markable对象的mark表记录
	 * @param $id:markable对象的id
	 */
	public function run($id){
		
		//得到当前的postable对象
		$controller = $this->getController();
		$model = $controller->loadModel($id);
		$post = new Post;
		
		if(isset($_POST['Post'])){
			$post->attributes = $_POST['Post'];
			if($model->addPost($post)){
				Yii::app()->user->setFlash('success','发表成功！');
				$controller->redirect(array('post','id'=>$post->getPrimaryKey()));
				Yii::app()->end();
			}
		}
		$controller->render('add_post',array('post'=>$post,'model'=>$model));
		
	}
}