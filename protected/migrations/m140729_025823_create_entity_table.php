<?php

class m140729_025823_create_entity_table extends CDbMigration
{
	public function up()
	{
        $this->createTable('{{entity}}', array(
            'id'    =>  "int(11) NOT NULL AUTO_INCREMENT COMMENT 'id'",
            'type'  =>  "char(32) NOT NULL DEFAULT '' COMMENT 'user,group，post,comment'",
            "PRIMARY KEY (`id`)",
        ), "ENGINE=MyISAM  DEFAULT CHARSET=utf8 COMMENT='可挂载对象'");
	}

	public function down()
	{
        $this->dropTable('{{entity}}');
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
