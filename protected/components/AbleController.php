<?php
/**
*给post，comment，vote等controller使用，用于定义默认的跳转action。
 */
class AbleController extends Controller
{

	public function getType(){
		$class=get_class($this);
		return lcfirst(substr($class, 0,strpos($class,"Controller")));
	}
	/**
	 * 跳转到owner下显示model
	 * @param integer $id the ID of the model to be displayed
	 */
	public function actionView($id)
	{
		$model = $this->loadModel($id);
		$this->redirect(array($model->{$this->getType()."ableEntity"}->type."/".$this->getType(),'id'=>$id));
	}
	
	/**
	 * 跳转到owner下显示更新model
	 * If update is successful, the browser will be redirected to the 'view' page.
	 * @param integer $id the ID of the model to be updated
	 */
	public function actionUpdate($id)
	{
		$model = $this->loadModel($id);
		$this->redirect(array($model->{$this->getType()."ableEntity"}->type."/update".lcfirst($this->getType()),'id'=>$id));
	}
}