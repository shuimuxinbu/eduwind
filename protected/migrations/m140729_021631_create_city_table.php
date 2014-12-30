<?php

class m140729_021631_create_city_table extends CDbMigration
{
	public function up()
	{
        $this->createTable('{{city}}', array(
            'id'            =>  "int(11) NOT NULL AUTO_INCREMENT",
            'code'          =>  "varchar(6) NOT NULL",
            'name'          =>  "varchar(20) NOT NULL",
            'provinceCode'  =>  "varchar(6) NOT NULL",
            "PRIMARY KEY (`id`)",
        ), "ENGINE=MyISAM  DEFAULT CHARSET=utf8");
	}

	public function down()
	{
        $this->dropTable('{{city}}');
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
