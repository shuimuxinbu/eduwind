<?php

class m140808_015801_create_article_table extends CDbMigration
{
	public function up()
	{
        $this->createTable('{{article}}', array(
            'id'            =>  'int(11) NOT NULL AUTO_INCREMENT COMMENT "ID"',
            'uid'           =>  'int(11) NOT NULL COMMENT "用户ID"',
            'entityId'      =>  'int(11) NOT NULL DEFAULT 0 COMMENT "EntityId"',
            'categoryId'    =>  "int(11) NOT NULL DEFAULT '0' COMMENT '分类表Id'",
            'title'         =>  'varchar(255) NOT NULL DEFAULT "" COMMENT "标题"',
            "face"          =>  "varchar(255) COLLATE utf8_unicode_ci NOT NULL DEFAULT 'http://placehold.it/210x140' COMMENT '封面'",
            'content'       =>  'text COLLATE utf8_unicode_ci COMMENT "内容"',
            'addTime'       =>  'int(10) NOT NULL DEFAULT 0 COMMENT "添加时间"',
            'upTime'        =>  'int(10) NOT NULL DEFAULT 0 COMMENT "更新时间"',
            'keyWord'       =>  'varchar(255) DEFAULT "" COMMENT "关键字"',
            'commentNum'    =>  'int(11) NOT NULL DEFAULT 0 COMMENT "评论数"',
            'viewNum'       =>  "int(11) NOT NULL DEFAULT '0' COMMENT '阅读数'",
            'status'        =>  "int(11) NOT NULL DEFAULT '0' COMMENT '状态'",
            'isTop'         =>  "tinyint(1) NOT NULL DEFAULT '0' COMMENT '是否置顶'",
            'PRIMARY KEY (`id`)',
        ), 'ENGINE=MyISAM DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci');
	}

	public function down()
	{
        $this->dropTable('{{article}}');
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
