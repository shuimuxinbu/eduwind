<?php

class m140815_064649_create_quiz_report_table extends CDbMigration
{
	public function up()
	{
        $this->createTable(
            '{{quiz_report}}',
            array(
                'id'            =>  "int(11) NOT NULL AUTO_INCREMENT",
                'quizId'        =>  "int(11) NOT NULL",
                'userId'        =>  "int(11) NOT NULL",
                'score'         =>  "decimal(7,2) NOT NULL DEFAULT '0.00' COMMENT '得分'",
                'correctNum'    =>  "int(11) NOT NULL DEFAULT '0'",
                'wrongNum'      =>  "int(11) NOT NULL DEFAULT '0'",
                'partialCorrectNum' =>  "int(11) NOT NULL DEFAULT '0'",
                'teacherRemark'     =>  "text COLLATE utf8_unicode_ci",
                'remarkTime'    =>  "int(11) NOT NULL DEFAULT '0'",
                'addTime'       =>  "int(11) NOT NULL DEFAULT '0'",
                "PRIMARY KEY (`id`)",
            ),
            "ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci"
        );
	}

	public function down()
	{
        $this->dropTable('{{quiz_report}}');
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
