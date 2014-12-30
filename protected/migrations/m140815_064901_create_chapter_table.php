<?php

class m140815_064901_create_chapter_table extends CDbMigration
{
	public function up()
	{
        $this->createTable(
            '{{chapter}}',
            array(
                'id'        =>  "int(11) NOT NULL AUTO_INCREMENT",
                'courseId'  =>  "int(11) NOT NULL",
                'userId'    =>  "int(11) NOT NULL",
                'weight'    =>  "int(11) NOT NULL DEFAULT '0'",
                'number'    =>  "int(11) NOT NULL DEFAULT '0'",
                'lessonNum' =>  "int(11) NOT NULL DEFAULT '0'",
                'title'     =>  "char(255) COLLATE utf8_unicode_ci NOT NULL",
                'addTime'   =>  "int(11) NOT NULL DEFAULT '0'",
                "PRIMARY KEY (`id`)",
            ),
            "ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci"
        );
	}

	public function down()
	{
        $this->dropTable('{{chapter}}');
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
