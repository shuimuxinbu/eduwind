<?php

class m140729_032927_create_nav_table extends CDbMigration
{
	public function up()
	{
        $this->createTable('{{nav}}', array(
            'id'        =>  "int(11) NOT NULL AUTO_INCREMENT COMMENT '主键'",
            'title'     =>  "char(32) NOT NULL DEFAULT ''",
            'activeRule'=>  "char(255) NOT NULL DEFAULT ''",
            'weight'    =>  "int(11) NOT NULL DEFAULT '0'",
            'url'       =>  "char(255) NOT NULL DEFAULT ''",
            'location'  =>  "char(32) NOT NULL DEFAULT 'top'",
            "PRIMARY KEY (`id`)",
        ), "ENGINE=InnoDB  DEFAULT CHARSET=utf8");
	}

	public function down()
	{
        $this->dropTable('{{nav}}');
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
