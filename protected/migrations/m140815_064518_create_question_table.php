<?php

class m140815_064518_create_question_table extends CDbMigration
{
	public function up()
	{
        $this->createTable(
            '{{question}}',
            array(
                'id'        =>  "int(11) NOT NULL AUTO_INCREMENT",
                'stem'      =>  "text COLLATE utf8_unicode_ci",
                'quizId'    =>  "int(11) NOT NULL DEFAULT '0'",
                'type'      =>  "char(32) COLLATE utf8_unicode_ci NOT NULL DEFAULT 'multiple-choice'",
                'score'     =>  "decimal(7,1) NOT NULL DEFAULT '1.00' COMMENT '得分'",
                'solution'  =>  'text',
                'weight'    =>  "int(11) NOT NULL DEFAULT '0'",
                "PRIMARY KEY (`id`)",
            ), 
            "ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci"
        );
	}

	public function down()
	{
        $this->dropTable('{{question}}');
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
