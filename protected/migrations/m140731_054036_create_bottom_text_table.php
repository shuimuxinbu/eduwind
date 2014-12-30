<?php

class m140731_054036_create_bottom_text_table extends CDbMigration
{
	public function up()
	{
        $this->createTable('{{bottom_text}}', array(
            'id'        =>  "int(11) COLLATE utf8_unicode_ci NOT NULL AUTO_INCREMENT COMMENT 'Id'",
            'weight'    =>  "int(11) NOT NULL DEFAULT '0' COMMENT '排序'",
            'content'   =>  "text NOT NULL",
            'PRIMARY KEY (`id`)',
        ), "ENGINE=MyISAM DEFAULT CHARSET=utf8 COMMENT='静态页面'");
	}

	public function down()
	{
        $this->dropTable('{{bottom_text}}');
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
