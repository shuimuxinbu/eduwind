<?php

class m140729_025758_create_comment_table extends CDbMigration
{
	public function up()
	{
        $this->createTable('{{comment}}', array(
            'id'            =>  "int(11) NOT NULL AUTO_INCREMENT COMMENT '评论id'",
            'title'         =>  "char(255) NOT NULL DEFAULT '' COMMENT '标题'",
            'content'       =>  "text NOT NULL COMMENT '内容'",
            'addTime'       =>  "int(11) DEFAULT '0' COMMENT '发表时间'",
            'ew_rate'       =>  "int(11) NOT NULL DEFAULT '0' COMMENT '评分'",
            'userId'        =>  "int(11) NOT NULL COMMENT '发表者id'",
            'commentableEntityId'   =>  "int(11) NOT NULL DEFAULT '0' COMMENT '评论对象id'",
            'entityId'      =>  "int(11) NOT NULL DEFAULT '0' COMMENT 'Entity对象Id'",
            'referId'       =>  "int(11) NOT NULL DEFAULT '0' COMMENT '引用回复'",
            'voteUpNum'     =>  "int(11) NOT NULL DEFAULT '0'",
            'voteDownNum'   =>  "int(11) NOT NULL DEFAULT '0'",
            'deleted'       =>  "tinyint(1) NOT NULL DEFAULT '0'",
            'deleteTime'    =>  "int(11) NOT NULL DEFAULT '0'",
            "PRIMARY KEY (`id`)",
            "KEY `userId` (`userId`)",
        ), "ENGINE=MyISAM  DEFAULT CHARSET=utf8 COMMENT='评论'");
	}

	public function down()
	{
        $this->dropTable('{{comment}}');
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
