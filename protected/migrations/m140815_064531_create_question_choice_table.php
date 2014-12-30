<?php

class m140815_064531_create_question_choice_table extends CDbMigration
{
	public function up()
	{
        $this->createTable(
            '{{question_choice}}',
            array(
                'id'            =>  "int(11) NOT NULL AUTO_INCREMENT",
                'questionId'    =>  "int(11) NOT NULL",
                'isCorrect'     =>  "tinyint(1) NOT NULL DEFAULT '0'",
                'content'       =>  "text COLLATE utf8_unicode_ci",
                "PRIMARY KEY (`id`)",
            ),
            "ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci COMMENT='选项'"
        );
	}

	public function down()
	{
        $this->dropTable('{{question_choice}}');
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
