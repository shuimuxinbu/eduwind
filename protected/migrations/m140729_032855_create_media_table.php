<?php

class m140729_032855_create_media_table extends CDbMigration
{
	public function up()
	{
        $this->createTable('{{media}}', array(
            'id'        =>  "int(11) NOT NULL AUTO_INCREMENT COMMENT '课时id'",
            'title'     =>  "char(255) NOT NULL DEFAULT '' COMMENT '标题'",
            'url'       =>  "char(255) NOT NULL DEFAULT '' COMMENT '链接'",
            'userId'    =>  "int(11) NOT NULL COMMENT '用户id'",
            'weight'    =>  "int(11) NOT NULL DEFAULT '0' COMMENT '重量，用于课时排序，weight小的在前'",
            'addTime'   =>  "int(11) NOT NULL DEFAULT '0' COMMENT '添加时间'",
            'upTime'    =>  "int(11) NOT NULL DEFAULT '0' COMMENT '最新修改时间'",
            'introduction'  =>  "text COMMENT '视频介绍'",
            'type'      =>  "char(32) NOT NULL DEFAULT 'link' COMMENT '课时内容类型'",
            'viewNum'   =>  "int(11) NOT NULL DEFAULT '0' COMMENT '课时点击次数'",
            "PRIMARY KEY (`id`)",
            "KEY `userId` (`userId`)",
        ), "ENGINE=MyISAM DEFAULT CHARSET=utf8 COMMENT='课时表'");
	}

	public function down()
	{
        $this->dropTable('{{media}}');
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
