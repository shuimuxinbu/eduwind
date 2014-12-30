<?php

class m140729_060314_create_AuthItem_table extends CDbMigration
{
	public function up()
	{
        $this->createTable('AuthItem', array(
            'name'          =>  "varchar(64) NOT NULL",
            'type'          =>  "int(11) NOT NULL",
            'description'   =>  "text",
            'bizrule'       =>  "text",
            'data'          =>  "text",
            "PRIMARY KEY (`name`)",
        ), "ENGINE=MyISAM DEFAULT CHARSET=utf8");

        $this->insert(
            'AuthItem',
            array(
                'name'      =>  'admin',
                'type'      =>  2,
                'description'   =>  '管理员',
            )
        );
        
        $this->insert(
            'AuthItem',
            array(
                'name'      =>  'teacher',
                'type'      =>  2,
                'description'   =>  '人员',
            )
        );
	}

	public function down()
	{
        $this->dropTable('AuthItem');
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
