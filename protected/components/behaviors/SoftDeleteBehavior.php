<?php
class SoftDeleteBehavior extends CActiveRecordBehavior {

public $relations = array();

	/**

	* @see CActiveRecordbehavior::beforeDelete()

	*/

	public function beforeDelete ($event) {

		$model = $this->getOwner();

		$model->setAttribute('deleted', true);

		$model->setAttribute('deleteTime', time());

		if($model->save() && is_array($model->relations)){
            // 如果有relation
			foreach($model->relations as $relation)
			{
				$objects = $this->owner->getRelated($relation);

				if($objects !== null)
				{
					if(is_array($objects))
					{
						foreach($objects as $object)
						{
							$object->delete();
						}
					}
					else
					{
						$objects->delete();
					}
				}
			}
		}

		$event->isValid = false;

	}

	public function beforeFind($event)
	{
		$criteria = new CDbCriteria;
		$criteria->condition = $this->owner->getTableAlias(FALSE, FALSE).".deleted = 0";
		$this->owner->dbCriteria->mergeWith($criteria);
	}
}
