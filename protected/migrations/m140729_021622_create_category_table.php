<?php

class m140729_021622_create_category_table extends CDbMigration
{
	public function up()
	{
        $this->createTable('{{category}}', array(
            'id'            =>  "int(11) NOT NULL AUTO_INCREMENT COMMENT '笔记id'",
            'name'          =>  "char(64) NOT NULL DEFAULT '' COMMENT '类型'",
            'parentId'      =>  "int(11) NOT NULL DEFAULT '0' COMMENT '父级分类'",
            'type'          =>  "char(64) NOT NULL DEFAULT '' COMMENT '类型,book,course等'",
            'weight'        =>  "int(11) NOT NULL DEFAULT '0' COMMENT '排序'",
            'userId'        =>  "int(11) NOT NULL DEFAULT '0' COMMENT '创建者'",
            'description'   =>  "text",
            "PRIMARY KEY (`id`)",
        ), "ENGINE=MyISAM  DEFAULT CHARSET=utf8");
	}

	public function down()
	{
        $this->dropTable('{{category}}');
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
