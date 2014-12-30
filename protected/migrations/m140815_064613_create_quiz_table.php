<?php

class m140815_064613_create_quiz_table extends CDbMigration
{
	public function up()
	{
        $this->createTable(
            '{{quiz}}',
            array(
                'id'            =>  "int(11) NOT NULL AUTO_INCREMENT",
                'title'         =>  "char(255) COLLATE utf8_unicode_ci NOT NULL DEFAULT ''",
                'description'   =>  "text COLLATE utf8_unicode_ci",
                'reportNum'     =>  "int(11) NOT NULL DEFAULT '0'",
                'questionNum'   =>  "int(11) NOT NULL DEFAULT '0'",
                "PRIMARY KEY (`id`)",
            ), 
            "ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci"
        );
	}

	public function down()
	{
        $this->dropTable('{{quiz}}');
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
