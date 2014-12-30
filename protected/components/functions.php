<?php 
if(false===function_exists('lcfirst')){
	function lcfirst($str){
		$newStr = strtolower( substr($str,0,1) ) . substr($str,1);
		return $newStr;		
	}
}