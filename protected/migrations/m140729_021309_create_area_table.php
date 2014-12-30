<?php

class m140729_021309_create_area_table extends CDbMigration
{
	public function up()
	{
        $this->createTable('{{area}}', array(
            'id'        =>  "int(11) NOT NULL AUTO_INCREMENT",
            'code'      =>  "varchar(6) NOT NULL",
            'name'      =>  "varchar(20) NOT NULL",
            'cityCode'  =>  "varchar(6) NOT NULL",
            "PRIMARY KEY (`id`)"
        ), "ENGINE=MyISAM  DEFAULT CHARSET=utf8");
	}

	public function down()
	{
        $this->dropTable('{{area}}');
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
