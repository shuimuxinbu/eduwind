<?php
/**
 * Controller is the customized base controller class.
 * All controller classes for this application should extend from this base class.
 */
class CaController extends Controller
{
	
	/**
	 * Returns the data model based on the primary key given in the GET variable.
	 * If the data model is not found, an HTTP exception will be raised.
	 * @param integer $id the ID of the model to be loaded
	 * @return Lesson the loaded model
	 * @throws CHttpException
	 */
	public function loadCourse($courseId)
	{
		$model=Course::model()->findByPk($courseId);
		if($model===null)
			throw new CHttpException(404,'The requested page does not exist.');
		return $model;
	}
}