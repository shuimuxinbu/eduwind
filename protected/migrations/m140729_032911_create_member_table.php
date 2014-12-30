<?php

class m140729_032911_create_member_table extends CDbMigration
{
    public function up()
    {
        $this->createTable('{{member}}', array(
            'id'        =>  "int(11) NOT NULL AUTO_INCREMENT COMMENT '主键id'",
            'userId'    =>  "int(11) NOT NULL COMMENT '发表者id'",
            'memberableEntityId'    =>  "int(11) NOT NULL DEFAULT '0' COMMENT '拥有成员的entity'",
            'addTime'   =>  "int(11) DEFAULT '0' COMMENT '加入时间'",
            'upTime'    =>  "int(11) DEFAULT '0' COMMENT '更新时间'",
            'roles'     =>  "char(64) NOT NULL DEFAULT '' COMMENT '角色组'",
            "PRIMARY KEY (`id`)",
            "KEY `userId` (`userId`)",
        ), "ENGINE=MyISAM  DEFAULT CHARSET=utf8 COMMENT='用户从属关系表'");
	}

	public function down()
	{
        $this->dropTable('{{member}}');
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
