<?php
/* @var $this NoticeController */
/* @var $data Notice */
?>

<div>
<?php 
//$viewFile =  "_".$data->type;
/*$data->prepareRender();
if(file_exists($this->getViewFile($data->viewFile))){
	$this->renderPartial($data->viewFile,array("data"=>$data->viewData));
}*/
$this->renderPartial('_'.$data->type,array('data'=>$data->getData()));
?>
</div>
