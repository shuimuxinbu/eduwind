<?php

class m140815_064626_create_answer_table extends CDbMigration
{
	public function up()
	{
        $this->createTable(
            '{{answer}}',
            array(
                'id'            =>  "int(11) NOT NULL AUTO_INCREMENT",
                'userId'        =>  "int(11) NOT NULL",
                'questionId'    =>  "int(11) NOT NULL",
                'content'       =>  "text COLLATE utf8_unicode_ci",
                'addTime'       =>  "int(11) NOT NULL DEFAULT '0'",
                'weight'        =>  "int(11) NOT NULL DEFAULT '0'",
                "PRIMARY KEY (`id`)",
            ),
            "ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci"
        );
	}

	public function down()
	{
        $this->dropTable('{{answer}}');
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
