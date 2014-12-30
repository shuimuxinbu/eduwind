<?php

class m140816_153557_create_teacher_table extends CDbMigration
{
	public function up()
	{
        $this->createTable(
            '{{teacher}}',
            array(
                'id'            =>  "INT NOT NULL AUTO_INCREMENT",
                'userId'        =>  "INT NOT NULL COMMENT '用户ID'",
                'categoryId'    =>  "INT NOT NULL DEFAULT '0' COMMENT '分类ID'",
                'face'          =>  "CHAR(255) NULL COMMENT '人员头像'",
                'name'          =>  "VARCHAR(45) NULL COMMENT '人员姓名'",
                'description'   =>  "VARCHAR(255) NULL COMMENT '人员简介'",
                "PRIMARY KEY (`id`)",
            ),
            "ENGINE=MyISAM DEFAULT CHARSET=utf8 COMMENT='人员表'"
        );
	}

	public function down()
	{
        $this->dropTable('{{teacher}}');
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
