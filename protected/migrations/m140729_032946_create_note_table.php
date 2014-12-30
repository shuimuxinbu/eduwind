<?php

class m140729_032946_create_note_table extends CDbMigration
{
	public function up()
	{
        $this->createTable('{{note}}', array(
            'id'        =>  "int(11) NOT NULL AUTO_INCREMENT COMMENT '笔记id'",
            'userId'    =>  "int(11) NOT NULL COMMENT '用户id'",
            'noteableEntityId'  =>  "int(11) NOT NULL DEFAULT '0'",
            'accessControl'     =>  "char(32) NOT NULL DEFAULT 'private'",
            'title'     =>  "char(255) DEFAULT '' COMMENT '标题'",
            'content'   =>  "text COMMENT '笔记内容'",
            'addTime'   =>  "int(11) NOT NULL DEFAULT '0' COMMENT '添加时间'",
            'upTime'    =>  "int(11) NOT NULL DEFAULT '0' COMMENT '更新时间'",
            'entityId'  =>  "int(11) NOT NULL DEFAULT '0' COMMENT '更新时间'",
            "PRIMARY KEY (`id`)",
            "KEY `userId` (`userId`)",
        ), "ENGINE=MyISAM  DEFAULT CHARSET=utf8 COMMENT='笔记表'");
	}

	public function down()
	{
        $this->dropTable('{{note}}');
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
