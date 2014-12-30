<?php

class m140729_035511_create_user_table extends CDbMigration
{
	public function up()
	{
        $this->createTable('{{user}}', array(
            'id'            =>  "int(11) NOT NULL AUTO_INCREMENT COMMENT '用户id'",
            'email'         =>  "char(64) NOT NULL COMMENT '用户email'",
            'password'      =>  "char(32) NOT NULL COMMENT '密码密文'",
            'salt'          =>  "char(32) NOT NULL COMMENT '与明文密码一起生成passwd'",
            'resetPassword' =>  "char(64) NOT NULL DEFAULT '' COMMENT '重设密码用'",
            'deleted'       =>  "tinyint(1) NOT NULL DEFAULT '0'",
            'deleteTime'    =>  "int(11) NOT NULL DEFAULT '0'",
            "PRIMARY KEY (`id`)",
            "UNIQUE KEY `email` (`email`)",
        ), "ENGINE=MyISAM  DEFAULT CHARSET=utf8 COMMENT='用户表'");


        $this->insert(
            '{{user}}',
            array(
                'id'        =>  1,
                'email'     =>  'admin@eduwind.com',
                'password'  =>  '8f6094196ffce76a8b71ce52808afa01',
                'salt'      =>  'edd7051ad5fb1b62fa9daf5ad02b46cc',
                'resetPassword' =>  '',
                'deleted'   =>  '0',
                'deleteTime'=>  '0'
            )
        );
	}

	public function down()
	{
        $this->dropTable('{{user}}');
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
