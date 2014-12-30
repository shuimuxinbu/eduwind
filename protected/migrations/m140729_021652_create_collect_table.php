<?php

class m140729_021652_create_collect_table extends CDbMigration
{
	public function up()
	{
        $this->createTable('{{collect}}', array(
            'id'        =>  "int(11) NOT NULL AUTO_INCREMENT COMMENT '主id'",
            'userId'    =>  "int(11) NOT NULL DEFAULT '0' COMMENT '关注者id'",
            'collectableEntityId'   =>  "int(11) NOT NULL DEFAULT '0' COMMENT '被收藏'",
            'addTime'   =>  "int(11) NOT NULL DEFAULT '0' COMMENT '关注时间'",
            "PRIMARY KEY (`id`)",
            "KEY `userId` (`userId`)",
        ), "ENGINE=MyISAM  DEFAULT CHARSET=utf8 COMMENT='关注表'");
	}

	public function down()
	{
        $this->dropTable('{{collect}}');
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
