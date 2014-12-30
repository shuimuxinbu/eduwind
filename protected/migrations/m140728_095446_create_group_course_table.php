<?php

class m140728_095446_create_group_course_table extends CDbMigration
{
	public function up()
	{
        $this->createTable('{{group_course}}', array(
            'id'        =>  "int(11) NOT NULL AUTO_INCREMENT COMMENT '主键id'",
            'groupId'   =>  "int(11) NOT NULL DEFAULT '0' COMMENT '小组id'",
            'courseId'  =>  "int(11) NOT NULL DEFAULT '0' COMMENT '课程id'",
            'userId'    =>  "int(11) NOT NULL DEFAULT '0' COMMENT '收录者id'",
            'addTime'   =>  "int(11) NOT NULL DEFAULT '0' COMMENT '添加时间'",
            'PRIMARY KEY (`id`)',
            'KEY `groupId` (`groupId`)',
            'KEY `courseId` (`courseId`)',
            'KEY `userId` (`userId`)',
        ), "ENGINE=MyISAM DEFAULT CHARSET=utf8 COMMENT='小组收藏课程'");
	}

	public function down()
	{
        $this->dropTable('{{group_course}}');
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
