<?php

class m140729_035552_create_Rights_table extends CDbMigration
{
	public function up()
	{
        $this->createTable('Rights', array(
            'itemname'  =>  "varchar(64) NOT NULL",
            'type'      =>  "int(11) NOT NULL",
            'weight'    =>  "int(11) NOT NULL",
            "PRIMARY KEY (`itemname`)"
        ), "ENGINE=MyISAM DEFAULT CHARSET=utf8");
	}

	public function down()
	{
        $this->dropTable('Rights');
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
