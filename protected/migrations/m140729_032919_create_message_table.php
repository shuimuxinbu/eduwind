<?php

class m140729_032919_create_message_table extends CDbMigration
{
	public function up()
	{
        $this->createTable('{{message}}', array(
            'id'        =>  "int(11) NOT NULL AUTO_INCREMENT COMMENT '消息id'",
            'fromUserId'=>  "int(11) NOT NULL COMMENT '发送者id'",
            'toUserId'  =>  "int(11) NOT NULL COMMENT '接收者id'",
            'content'   =>  "text NOT NULL COMMENT '内容'",
            'addTime'   =>  "int(11) NOT NULL DEFAULT '0' COMMENT '发送时间'",
            'isChecked' =>  "tinyint(4) NOT NULL DEFAULT '0' COMMENT '是否已读，0：未读，1已读'",
            "PRIMARY KEY (`id`)",
            "KEY `fromUserId` (`fromUserId`)",
            "KEY `toUserId` (`toUserId`)",
        ), "ENGINE=MyISAM  DEFAULT CHARSET=utf8 COMMENT='私信表'");
	}

	public function down()
	{
        $this->dropTable('{{message}}');
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
