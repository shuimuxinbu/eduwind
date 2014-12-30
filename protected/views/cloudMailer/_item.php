<?php
if(is_a($item,'Notice')){
	echo strip_tags($this->renderPartial('/notice/_'.$item->type,array('data'=>$item->getData()),true));
}elseif(is_a($item,'Message'))
	echo $item->fromUser->name."给你发来了新的私信";