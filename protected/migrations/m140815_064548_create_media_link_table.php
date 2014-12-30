<?php

class m140815_064548_create_media_link_table extends CDbMigration
{
	public function up()
	{
        $this->createTable(
            '{{media_link}}',
            array(
                'id'        =>  "int(11) NOT NULL AUTO_INCREMENT",
                'url'       =>  "char(255) COLLATE utf8_unicode_ci DEFAULT NULL",
                'source'    =>  "char(32) COLLATE utf8_unicode_ci DEFAULT NULL",
                'duration'  =>  "int(11) NOT NULL DEFAULT '0'",
                'title'     =>  "char(255) COLLATE utf8_unicode_ci NOT NULL DEFAULT ''",
                "PRIMARY KEY (`id`)",
            ),
            "ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci"
        );

	}

	public function down()
	{
        $this->dropTable('{{media_link}}');
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
