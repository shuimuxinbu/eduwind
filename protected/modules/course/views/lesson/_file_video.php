<?php
/* @var $this LessonController */
/* @var $data Lesson */
?>




<div class="dxd-player">
	<div class="">
    <?php 
			$file = $lesson->file;
           if ($file && $file->storage == "local"){
            	$src = Yii::app()->baseUrl."/".$lesson->file->path;
   		 	 $this->widget('ext.ckplayer.MCKPlayer',array('flashvars'=>array('f'=>$src),'video'=>array($src)));
       //              $this->widget('ext.grindplayer.MGrindPlayer',array('flashvars'=>array('src'=>$src)));
//            	$this->widget('ext.ejwplayer.EJwPlayer',array(
//     'title' => $lesson->title,
//     'controls' => true,
//     'playlist' => array(
//         array(
//            // 'image' => '/sample-preview.jpg',
//             'sources' => array(
//                 array('file' => $src),
//             )
//         )
//     ),
// ));
           }
            elseif ($file && $file->storage == "cloud"){
            	$src= CloudService::getInstance()->getDownloadUrl($file->convertStatus=="success" ? $file->convertKey : $file->path);
   				 $this->widget('ext.grindplayer.MGrindPlayer',array('flashvars'=>array('src'=>$src)));
    }?>
    </div>

  </div> 
  
  <script type="text/javascript">

$('.dxd-player').on('contextmenu', function(e) {e.preventDefault();});
</script>
<div class="clearfix"></div>