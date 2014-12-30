<?php

class m140729_035538_create_vote_table extends CDbMigration
{
	public function up()
	{
        $this->createTable('{{vote}}', array(
            'id'        =>  "int(11) NOT NULL AUTO_INCREMENT COMMENT 'id'",
            'value'     =>  "tinyint(4) NOT NULL DEFAULT '0' COMMENT '选票值，1为顶，0为踩'",
            'userId'    =>  "int(11) NOT NULL DEFAULT '0' COMMENT '评价者id'",
            'addTime'   =>  "int(11) NOT NULL DEFAULT '0' COMMENT '添加时间'",
            'voteableEntityId'  =>  "int(11) NOT NULL DEFAULT '0' COMMENT '评论对象id'",
            'upTime'    =>  "int(11) NOT NULL DEFAULT '0' COMMENT '修改时间'",
            "PRIMARY KEY (`id`)",
            "KEY `userId` (`userId`)"
        ), "ENGINE=MyISAM  DEFAULT CHARSET=utf8 COMMENT='记录一次对回答的投票评价'");
	}

	public function down()
	{
        $this->dropTable('{{vote}}');
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
