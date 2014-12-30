<?php
/**
 * Controller is the customized base controller class.
 * All controller classes for this application should extend from this base class.
 */
class Controller extends RController
{
	/**
	 * @var string the default layout for the controller view. Defaults to '//layouts/column1',
	 * meaning using a single column layout. See 'protected/views/layouts/column1.php'.
	 */
	public $layout='/layouts/column1';
	/**
	 * @var array context menu items. This property will be assigned to {@link CMenu::items}.
	 */
	public $menu=array();
	/**
	 * @var array the breadcrumbs of the current page. The value of this property will
	 * be assigned to {@link CBreadcrumbs::links}. Please refer to {@link CBreadcrumbs::links}
	 * for more details on how to specify this property.
	 */
	public $breadcrumbs=array();
	
	public $activeMenu="";

	/**
	 * 默认计数器
	 * @param unknown_type $id
	 */
	public function actionCounter($id){
		$model = $this->loadModel($id);
		if(isset($model->viewNum)){
			$model->viewNum+=1;
			$model->save();
		}
	}

	public function init(){
		//设置theme
		if(isset($_GET['theme'])){
			Yii::app()->session['theme'] = $_GET['theme'];
		}			
		if(isset(Yii::app()->session['theme']))
			Yii::app()->theme = Yii::app()->session['theme'];
		//设置activeMenu
		$this->activeMenu = Yii::app()->getController()->id;
		parent::init();
	}
}