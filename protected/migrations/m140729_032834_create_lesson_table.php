<?php

class m140729_032834_create_lesson_table extends CDbMigration
{
	public function up()
	{
        $this->createTable('{{lesson}}', array(
            'id'        =>  "int(11) NOT NULL AUTO_INCREMENT COMMENT '课时id'",
            'title'     =>  "char(255) NOT NULL DEFAULT '' COMMENT '标题'",
            'courseId'  =>  "int(11) NOT NULL COMMENT '所属课程id'",
            'weight'    =>  "int(11) NOT NULL DEFAULT '0' COMMENT '重量，用于课时排序，weight小的在前'",
            'addTime'   =>  "int(11) NOT NULL DEFAULT '0' COMMENT '添加时间'",
            'upTime'    =>  "int(11) NOT NULL DEFAULT '0' COMMENT '最新修改时间'",
            'mediaId'   =>  "int(11) NOT NULL DEFAULT '0'",
            'mediaSource'   =>  "char(32) NOT NULL DEFAULT '' COMMENT '课时来源'",
            'mediaUri'  =>  "char(255) NOT NULL DEFAULT ''",
            'mediaName' =>  "char(255) NOT NULL DEFAULT ''",
            'viewNum'   =>  "int(11) NOT NULL DEFAULT '0' COMMENT '点击'",
            'introduction'  =>  "text COMMENT '简介'",
            'entityId'  =>  "int(11) NOT NULL DEFAULT '0'",
            'userId'    =>  "int(11) NOT NULL DEFAULT '0' COMMENT '用户id'",
            'mediaType' =>  "char(32) NOT NULL DEFAULT 'video'",
            'status'    =>  "int(11) NOT NULL DEFAULT '0'",
            'isFree'    =>  "tinyint(1) NOT NULL DEFAULT '0'",
            'number'    =>  "int(11) NOT NULL DEFAULT '0'",
            'chapterId' =>  "int(11) NOT NULL DEFAULT '0'",
            "PRIMARY KEY (`id`)",
            "KEY `courseId` (`courseId`)",
        ), "ENGINE=MyISAM  DEFAULT CHARSET=utf8 COMMENT='课时表'");
	}

	public function down()
	{
        $this->dropTable('{{lesson}}');
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
