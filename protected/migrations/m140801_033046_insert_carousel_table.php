<?php

class m140801_033046_insert_carousel_table extends CDbMigration
{
	public function up()
	{
        $this->insert('{{carousel}}', array(
            'id'        =>  5,
            'addTime'   =>  time(),
            'path'      =>  'uploads/carousel/path/5.jpg',
            'url'       =>  '',
            'weight'    =>  0,
        ));

        $this->insert('{{carousel}}', array(
            'id'        =>  6,
            'addTime'   =>  time(),
            'path'      =>  'uploads/carousel/path/6.jpg',
            'url'       =>  '',
            'weight'    =>  1,
        ));
	}

	public function down()
	{
        $this->delete('{{carousel}}', 'id=:id', array('id'=>5));
        $this->delete('{{carousel}}', 'id=:id', array('id'=>6));
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
