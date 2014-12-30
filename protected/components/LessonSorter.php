<?php

class LessonSorter extends CComponent{
	public  function sortByWeight($a,$b){
		return $a->weight-$b->weight;
	}
}