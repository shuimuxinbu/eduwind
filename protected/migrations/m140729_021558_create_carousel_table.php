<?php

class m140729_021558_create_carousel_table extends CDbMigration
{
	public function up()
	{
        $this->createTable('{{carousel}}', array(
            'id'        =>  "int(11) NOT NULL AUTO_INCREMENT COMMENT '笔记id'",
            'addTime'   =>  "int(11) NOT NULL DEFAULT '0' COMMENT '添加时间'",
            'path'      =>  "char(255) NOT NULL DEFAULT '' COMMENT '文件路径'",
            'url'       =>  "varchar(1024) NOT NULL DEFAULT '' COMMENT '对应链接'",
            'weight'    =>  "int(11) NOT NULL DEFAULT '0' COMMENT '排序'",
            'courseId'  =>  "int(11) NOT NULL DEFAULT '0'",
            "PRIMARY KEY (`id`)",
        ), "ENGINE=MyISAM  DEFAULT CHARSET=utf8 COMMENT='首页轮播图片'");
	}

	public function down()
	{
        $this->dropTable('{{carousel}}');
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
