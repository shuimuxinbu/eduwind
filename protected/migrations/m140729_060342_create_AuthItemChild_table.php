<?php

class m140729_060342_create_AuthItemChild_table extends CDbMigration
{
	public function up()
	{
        $this->createTable('AuthItemChild', array(
            'parent'    =>  "varchar(64) NOT NULL",
            'child'     =>  "varchar(64) NOT NULL",
            "PRIMARY KEY (`parent`,`child`)",
            "KEY `child` (`child`)",
        ), "ENGINE=MyISAM DEFAULT CHARSET=utf8");

        $this->insert(
            'AuthItemChild',
            array(
                'parent'    =>  'Authenticated',
                'child'     =>  'deleteOwnPost'
            )
        );

        $this->insert(
            'AuthItemChild',
            array(
                'parent'    =>  'Authenticated',
                'child'     =>  'updateOwnAnswer'
            )
        );

        $this->insert(
            'AuthItemChild',
            array(
                'parent'    =>  'Authenticated',
                'child'     =>  'updateOwnPost'
            )
        );

        $this->insert(
            'AuthItemChild',
            array(
                'parent'    =>  'Authenticated',
                'child'     =>  'updateOwnQuestion'
            )
        );

        $this->insert(
            'AuthItemChild',
            array(
                'parent'    =>  'updateOwnPost',
                'child'     =>  'updatePost'
            )
        );
	}

	public function down()
	{
        $this->dropTable('AuthItemChild');
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
