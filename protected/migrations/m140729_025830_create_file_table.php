<?php

class m140729_025830_create_file_table extends CDbMigration
{
	public function up()
	{
        $this->createTable('{{file}}', array(
            'id'        =>  "int(11) NOT NULL AUTO_INCREMENT COMMENT '文档id'",
            'userId'    =>  "int(11) NOT NULL COMMENT '文件创建人id'",
            'addTime'   =>  "int(11) NOT NULL DEFAULT '0' COMMENT '创建时间'",
            'status'    =>  "char(32) NOT NULL DEFAULT '' COMMENT '状态,unpublished,ok'",
            'path'      =>  "char(255) NOT NULL DEFAULT '' COMMENT '文件路径'",
            'type'      =>  "char(64) NOT NULL DEFAULT '' COMMENT '文件类型'",
            'name'      =>  "char(255) NOT NULL DEFAULT '' COMMENT '文件名字'",
            'size'      =>  "int(11) NOT NULL DEFAULT '0' COMMENT '文件大小'",
            "PRIMARY KEY (`id`)",
            "KEY `userId` (`userId`)",
        ), "ENGINE=MyISAM  DEFAULT CHARSET=utf8 COMMENT='文件'");
	}

	public function down()
	{
        $this->dropTable('{{file}}');
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
