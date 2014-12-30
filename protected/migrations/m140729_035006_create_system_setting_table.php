<?php

class m140729_035006_create_system_setting_table extends CDbMigration
{
	public function up()
	{
        $this->createTable('{{system_setting}}', array(
            'id'            =>  "int(11) NOT NULL AUTO_INCREMENT COMMENT 'id'",
            'name'          =>  "char(64) NOT NULL COMMENT '名称'",
            'value'         =>  "text NOT NULL COMMENT '值'",
            'description'   =>  "text COMMENT '描述'",
            "PRIMARY KEY (`id`)",
        ), "ENGINE=MyISAM  DEFAULT CHARSET=utf8 COMMENT='系统设置值表'");
	}

	public function down()
	{
        $this->dropTable('{{system_setting}}');
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
