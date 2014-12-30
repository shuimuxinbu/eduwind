<?php

class m140815_064811_create_course_quiz_report_table extends CDbMigration
{
	public function up()
	{
        $this->createTable(
            '{{course_quiz_report}}',
            array(
                'id'        =>  "int(11) NOT NULL AUTO_INCREMENT",
                'userId'    =>  "int(11) NOT NULL",
                'courseId'  =>  "int(11) NOT NULL",
                'quizIds'   =>  "char(255) COLLATE utf8_unicode_ci NOT NULL DEFAULT ''",
                'avgScore'  =>  "decimal(5,2) DEFAULT NULL",
                'totalScore'=>  "decimal(5,2) DEFAULT NULL",
                'quizNum'   =>  "int(11) NOT NULL DEFAULT '0'",
                'correctNum'=>  "int(11) NOT NULL DEFAULT '0'",
                'partialCorrectNum' =>  "int(11) NOT NULL DEFAULT '0'",
                'wrongNum'  =>  "int(11) NOT NULL DEFAULT '0'",
                "PRIMARY KEY (`id`)",
            ),
            "ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci"
        );
	}

	public function down()
	{
        $this->dropTable('{{course_quiz_report}}');
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
