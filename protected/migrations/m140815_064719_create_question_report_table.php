<?php

class m140815_064719_create_question_report_table extends CDbMigration
{
	public function up()
	{
        $this->createTable(
            '{{question_report}}',
            array(
                'id'            =>  "int(11) NOT NULL AUTO_INCREMENT",
                'questionId'    =>  "int(11) NOT NULL",
                'memberNum'     =>  "int(11) NOT NULL DEFAULT '0'",
                'partialCorrectRate'    =>  "decimal(5,4) DEFAULT '0.0000'",
                'wrongRate'     =>  "decimal(5,4) DEFAULT '0.0000'",
                'correctRate'   =>  "decimal(5,4) DEFAULT '0.0000'",
                'aNum'          =>  "int(11) NOT NULL DEFAULT '0'",
                'bNum'          =>  "int(11) NOT NULL DEFAULT '0'",
                'cNum'          =>  "int(11) NOT NULL DEFAULT '0'",
                'dNum'          =>  "int(11) NOT NULL DEFAULT '0'",
                'eNum'          =>  "int(11) NOT NULL DEFAULT '0'",
                'fNum'          =>  "int(11) NOT NULL DEFAULT '0'",
                "PRIMARY KEY (`id`)",
            ),
            "ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci"
        );
	}

	public function down()
	{
        $this->dropTable('{{question_report}}');
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
