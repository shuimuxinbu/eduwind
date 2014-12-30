<?php

class m140729_025843_create_follow_table extends CDbMigration
{
    public function up()
    {
        $this->createTable('{{follow}}', array(
            'id'        =>  "int(11) NOT NULL AUTO_INCREMENT COMMENT '主id'",
            'userId'    =>  "int(11) NOT NULL DEFAULT '0' COMMENT '关注者id'",
            'followableEntityId'    =>  "int(11) NOT NULL DEFAULT '0' COMMENT '被关注者'",
            'addTime'   =>  "int(11) NOT NULL DEFAULT '0' COMMENT '关注时间'",
            "PRIMARY KEY (`id`)",
            "KEY `userId` (`userId`)",
        ), "ENGINE=MyISAM  DEFAULT CHARSET=utf8 COMMENT='关注表'");
	}

	public function down()
	{
        $this->dropTable('{{follow}}');
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
