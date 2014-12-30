<?php

class m140729_034939_create_province_table extends CDbMigration
{
	public function up()
	{
        $this->createTable('{{province}}', array(
            'id'    =>  "int(11) NOT NULL AUTO_INCREMENT",
            'code'  =>  "varchar(6) NOT NULL",
            'name'  =>  "varchar(20) NOT NULL",
            "PRIMARY KEY (`id`)",
        ), "ENGINE=MyISAM  DEFAULT CHARSET=utf8");
	}

	public function down()
	{
        $this->dropTable('{{province}}');
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
