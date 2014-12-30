<?php

class m140818_065712_insert_nav_table extends CDbMigration
{
	public function up()
	{
        $this->insert(
            '{{nav}}',
            array(
                'id'        =>  6,
                'title'     =>  '师资',
                'activeRule'=>  'return Yii::app()->controller->uniqueId=="course/teacher";',
                'weight'    =>  '5',
                'url'       =>  '/index.php?r=course/teacher',
                'location'  =>  'top',
            )
        );

        $this->update(
            '{{nav}}',
            array(
                'activeRule'    =>  'return Yii::app()->controller->activeMenu=="course" && Yii::app()->controller->uniqueId!="course/teacher";'
            ),
            'id=:id',
            array(':id'=>2)
        );
	}

	public function down()
	{
        $this->delete('{{nav}}', 'id=:id', array(':id'=>6));

        $this->update(
            '{{nav}}',
            array(
                'activeRule'    =>  'return Yii::app()->controller->activeMenu=="course";'
            ),
            'id=:id',
            array(':id'=>2)
        );
	}

	/*
	// Use safeUp/safeDown to do migration with transaction
	public function safeUp()
	{
	}

	public function safeDown()
	{
	}
	*/
}
