<?php

class m140815_064848_create_lesson_learn_table extends CDbMigration
{
	public function up()
	{
        $this->createTable(
            '{{lesson_learn}}',
            array(
                'id'        =>  "int(11) NOT NULL AUTO_INCREMENT",
                'lessonId'  =>  "int(11) NOT NULL",
                'userId'    =>  "int(11) NOT NULL",
                'startTime' =>  "int(11) NOT NULL DEFAULT '0'",
                'finishTime'=>  "int(11) NOT NULL DEFAULT '0'",
                'status'    =>  "int(4) NOT NULL DEFAULT '0'",
                "PRIMARY KEY (`id`)",
            ),
            "ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci"
        );
	}

	public function down()
	{
        $this->dropTable('{{lesson_learn}}');
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
