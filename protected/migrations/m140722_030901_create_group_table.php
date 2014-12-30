<?php

class m140722_030901_create_group_table extends CDbMigration
{
	public function up()
	{
        $this->createTable('{{group}}', array(
            'id'                =>  "int(11) NOT NULL AUTO_INCREMENT COMMENT 'id'",
            'name'              =>  "char(64) NOT NULL COMMENT '名称'",
            'face'              =>  "char(255) NOT NULL DEFAULT '' COMMENT '头像存放位置'",
            'userId'            =>  "int(11) NOT NULL COMMENT '小组创建人id'",
            'addTime'           =>  "int(11) NOT NULL DEFAULT '0' COMMENT '添加时间'",
            'introduction'      =>  "text COMMENT '课程简介'",
            'status'            =>  "char(32) NOT NULL DEFAULT '' COMMENT '状态，ok,applied,created'",
            'memberNum'         =>  "int(11) NOT NULL DEFAULT '0' COMMENT '人数'",
            'viewNum'           =>  "int(11) NOT NULL DEFAULT '0' COMMENT '点击量'",
            'postableEntityId'  =>  "int(11) DEFAULT NULL COMMENT '发帖对象id'",
            'joinType'          =>  "char(32) NOT NULL DEFAULT 'free' COMMENT '加入方式：apply,free'",
            'entityId'          =>  "int(11) NOT NULL DEFAULT '0' COMMENT 'Entity对象Id'",
            'isTop'             =>  "tinyint(4) NOT NULL DEFAULT '0' COMMENT '是否推荐'",
            'categoryId'        =>  "int(11) NOT NULL DEFAULT '0' COMMENT '分类'",
            'deleted'           =>  "tinyint(1) NOT NULL DEFAULT '0'",
            'deleteTime'        =>  "int(11) NOT NULL DEFAULT '0'",
            'leaderTitle'       =>  "char(32) NOT NULL DEFAULT '组长'",
            'memberTitle'       =>  "char(32) NOT NULL DEFAULT '成员'",
            'adminTitle'        =>  "char(32) NOT NULL DEFAULT '管理员'",
            "PRIMARY KEY (`id`)",
            "UNIQUE KEY `postableEntityId` (`postableEntityId`)",
            "KEY `userId` (`userId`)",
        ), "ENGINE=MyISAM DEFAULT CHARSET=utf8 COMMENT='小组表'");
	}

	public function down()
	{
        $this->dropTable('{{group}}');
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
