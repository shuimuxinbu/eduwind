<?php

class m140729_060304_create_AuthAssignment_table extends CDbMigration
{
	public function up()
	{
        $this->createTable('AuthAssignment', array(
            'itemname'  =>  "varchar(64) NOT NULL",
            'userid'    =>  "varchar(64) NOT NULL",
            'bizrule'   =>  "text",
            'data'      =>  "text",
            "PRIMARY KEY (`itemname`,`userid`)",
        ), "ENGINE=MyISAM DEFAULT CHARSET=utf8");

        $this->insert(
            'AuthAssignment',
            array(
                'itemname'  =>  'admin',
                'userid'    =>  1,
            )
        );
	}

	public function down()
	{
        $this->dropTable('AuthAssignment');
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
