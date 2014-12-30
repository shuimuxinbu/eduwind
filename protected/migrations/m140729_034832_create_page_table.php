<?php

class m140729_034832_create_page_table extends CDbMigration
{
	public function up()
	{
        $this->createTable('{{page}}', array(
            'id'        =>  "int(11) NOT NULL AUTO_INCREMENT COMMENT 'id'",
            'userId'    =>  "int(11) NOT NULL COMMENT '创建人id'",
            'addTime'   =>  "int(11) NOT NULL DEFAULT '0' COMMENT '创建时间'",
            'title'     =>  "char(255) NOT NULL DEFAULT '' COMMENT '标题'",
            'content'   =>  "text NOT NULL",
            'weight'    =>  "int(11) NOT NULL DEFAULT '0' COMMENT '排序'",
            'published' =>  "tinyint(10) NOT NULL DEFAULT '0'",
            "PRIMARY KEY (`id`)",
            "KEY `userId` (`userId`)",
        ), "ENGINE=MyISAM  DEFAULT CHARSET=utf8 COMMENT='静态页面'");
	}

	public function down()
	{
        $this->dropTable('{{page}}');
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
