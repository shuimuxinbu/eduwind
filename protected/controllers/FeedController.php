<?php

class FeedController extends Controller
{
	public function actionIndex()
	{
		$userId = Yii::app()->user->id;
		$sql = "(select f.* from dxd_course_learn cl inner join dxd_course_feed cf on cl.courseId=cf.courseId inner join dxd_feed f on cf.feedid=f.id where cl.userId=$userId)".
				"union (select f2.* from dxd_user_follow uf inner join dxd_user_feed ufd on uf.followed_userId=ufd.userId inner join dxd_feed f2 on ufd.feedid=f2.id where uf.follow_userId=$userId)".
				' order by addTime desc';
		$feeds = Feed::model()->findAllBySql($sql);
//		$count=Yii::app()->db->createCommand($sql)->queryScalar();
/*		$dataProvider =new  CSqlDataProvider($sql,array('keyField'=>'id',
														'totalItemCount'=>$count,
													    'pagination'=>array(
													        'pageSize'=>30,
													    )));*/
		$dataProvider = new CArrayDataProvider($feeds);
		$this->render('index',array('dataProvider'=>$dataProvider));
	}

	// Uncomment the following methods and override them if needed
	/*
	public function filters()
	{
		// return the filter configuration for this controller, e.g.:
		return array(
			'inlineFilterName',
			array(
				'class'=>'path.to.FilterClass',
				'propertyName'=>'propertyValue',
			),
		);
	}

	public function actions()
	{
		// return external action classes, e.g.:
		return array(
			'action1'=>'path.to.ActionClass',
			'action2'=>array(
				'class'=>'path.to.AnotherActionClass',
				'propertyName'=>'propertyValue',
			),
		);
	}
	*/
}