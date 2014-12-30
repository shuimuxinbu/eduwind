<?php

class m140729_035018_create_upgrade_info_table extends CDbMigration
{
	public function up()
	{
        $this->createTable('{{upgrade_info}}', array(
            'id'            =>  "int(11) NOT NULL AUTO_INCREMENT COMMENT '主键'",
            'versionId'     =>  "int(11) NOT NULL COMMENT '记录服务器上升级包的id'",
            'version'       =>  "varchar(32) NOT NULL COMMENT '版本号'",
            'name'          =>  "varchar(256) NOT NULL COMMENT '包名称'",
            'description'   =>  "text COMMENT '包描述'",
            'addTime'       =>  "int(11) NOT NULL COMMENT '包添加时间'",
            'status'        =>  "varchar(32) NOT NULL DEFAULT 'not installed' COMMENT '包状态：not installed, installed'",
            "PRIMARY KEY (`id`)",
            "UNIQUE KEY `versionId` (`versionId`)",
        ), "ENGINE=MyISAM  DEFAULT CHARSET=utf8 COMMENT='用来记录网站升级包的信息'");
	}

	public function down()
	{
        $this->dropTable('{{upgrade_info}}');
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
