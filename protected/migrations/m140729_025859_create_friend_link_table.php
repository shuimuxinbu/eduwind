<?php

class m140729_025859_create_friend_link_table extends CDbMigration
{
	public function up()
	{
        $this->createTable('{{friend_link}}', array(
            'id'        =>  "int(11) NOT NULL AUTO_INCREMENT COMMENT '主id'",
            'title'     =>  "char(128) NOT NULL DEFAULT '' COMMENT '文字'",
            'url'       =>  "char(255) NOT NULL DEFAULT '' COMMENT '链接地址'",
            'logo'      =>  "char(255) NOT NULL DEFAULT '' COMMENT 'logo图片'",
            'weight'    =>  "int(11) NOT NULL DEFAULT '0'",
            "PRIMARY KEY (`id`)",
        ), "ENGINE=MyISAM DEFAULT CHARSET=utf8 COMMENT='友情链接'");
	}

	public function down()
	{
        $this->dropTable('{{friend_link}}');
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
