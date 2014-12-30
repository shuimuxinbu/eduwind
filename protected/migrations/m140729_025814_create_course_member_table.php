<?php

class m140729_025814_create_course_member_table extends CDbMigration
{
	public function up()
	{
        $this->createTable('{{course_member}}', array(
            'id'        =>  "int(11) NOT NULL AUTO_INCREMENT COMMENT '主键'",
            'orderId'   =>  "int(11) NOT NULL DEFAULT '0'",
            'startTime' =>  "int(11) NOT NULL",
            'endTime'   =>  "int(11) NOT NULL DEFAULT '0'",
            'courseId'  =>  "int(11) NOT NULL DEFAULT '0'",
            'userId'    =>  "int(11) NOT NULL DEFAULT '0'",
            'roles'     =>  "char(64) NOT NULL DEFAULT '0'",
            "PRIMARY KEY (`id`)",
            "UNIQUE KEY `courseId` (`courseId`,`userId`)",
        ), "ENGINE=MyISAM DEFAULT CHARSET=utf8 COMMENT='选课成员'");
	}

	public function down()
	{
        $this->dropTable('{{course_member}}');
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
