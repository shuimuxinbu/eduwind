<?php

class m140729_020654_create_announcement_table extends CDbMigration
{
	public function up()
	{
        $this->createTable('{{announcement}}', array(
            'id'        =>  "int(11) NOT NULL AUTO_INCREMENT",
            'courseId'  =>  "int(11) NOT NULL",
            'content'   =>  "text NOT NULL",
            'addTime'   =>  "int(11) NOT NULL",
            'upTime'    =>  "int(11) DEFAULT NULL",
            "PRIMARY KEY (`id`)",
        ), "ENGINE=MyISAM DEFAULT CHARSET=utf8");
	}

	public function down()
	{
        $this->dropTable('{{announcement}}');
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
