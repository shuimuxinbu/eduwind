<?php

class m140729_063431_create_event_table extends CDbMigration
{
	public function up()
	{
        $this->createTable('{{event}}', array(
            'id'            =>  "int(11) NOT NULL AUTO_INCREMENT",
            'title'         =>  "varchar(128) COLLATE utf8_unicode_ci NOT NULL",
            'content'       =>  "text COLLATE utf8_unicode_ci NOT NULL",
            'description'   =>  "varchar(255) COLLATE utf8_unicode_ci NOT NULL",
            'keyWork'       =>  "varchar(255) COLLATE utf8_unicode_ci NOT NULL DEFAULT ''",
            'addTime'       =>  "int(11) NOT NULL",
            'upTime'        =>  "int(11) NOT NULL",
            'userId'        =>  "int(11) NOT NULL",
            'viewNum'       =>  "int(11) NOT NULL DEFAULT '0'",
            "PRIMARY KEY (`id`)",
            "UNIQUE KEY `title_UNIQUE` (`title`)",
        ), "ENGINE=MyISAM DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci");
	}

	public function down()
	{
        $this->dropTable('{{event}}');
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
