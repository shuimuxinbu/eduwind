<?php
class AddCommentAction extends CAction{
	/**
	 * 更新一个markable对象的mark表记录
	 * @param $id:markable对象的id
	 */
	public function run($id){

		//得到当前的questionable对象
		$controller = $this->getController();
		$model = $controller->loadModel($id);
		$comment = new Comment();

		if(isset($_POST['Comment']))
		{
			$comment->attributes=$_POST['Comment'];

			if($model->addComment($comment)){
				$model->upTime = time();
				$model->save();

				//发送消息
				//$comment = $event->params['comment'];
				if($model->asa('followable')){
					$follows = $model->getAllFollows();
					foreach($follows as $follow){
						if($follow->userId!=$comment->userId && $follow->userId!=$comment->referId){
							Notice::send($follow->userId, $model->entity->type."_comment_added", array('commentId'=>$comment->id));
						}
					}
				}
				Yii::app()->user->setFlash('success','评论成功！');
			}else{
				Yii::app()->user->setFlash('error','抱歉，评论失败！');
			}

		}
		
		$controller->redirect(array('view','id'=>$model->id));

	}
}