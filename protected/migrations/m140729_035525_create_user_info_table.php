<?php

class m140729_035525_create_user_info_table extends CDbMigration
{
	public function up()
	{
        $this->createTable('{{user_info}}', array(
            'id'        =>  "int(11) NOT NULL",
            'email'     =>  "char(64) NOT NULL COMMENT '用户email'",
            'name'      =>  "char(64) NOT NULL COMMENT '用户名'",
            'isAdmin'   =>  "tinyint(1) NOT NULL DEFAULT '0' COMMENT '是否系统管理员'",
            'addTime'   =>  "int(11) NOT NULL DEFAULT '0' COMMENT '加入时间'",
            'upTime'    =>  "int(11) NOT NULL DEFAULT '0' COMMENT '上次登录时间'",
            'face'      =>  "char(255) NOT NULL DEFAULT '' COMMENT '个人头像'",
            'status'    =>  "char(32) NOT NULL DEFAULT '' COMMENT '用户状态，creted，verifying,ok'",
            'introduction'  =>  "text COMMENT '详细介绍'",
            'verifyCode'    =>  "char(32) NOT NULL DEFAULT '' COMMENT '邮箱验证码'",
            'fanNum'        =>  "int(11) NOT NULL DEFAULT '0' COMMENT '粉丝数'",
            'answerNum'     =>  "int(11) NOT NULL DEFAULT '0' COMMENT '回答数'",
            'answerVoteupNum'   =>  "int(11) NOT NULL DEFAULT '0' COMMENT '赞成数'",
            'sex'       =>  "char(8) NOT NULL DEFAULT '' COMMENT '性别'",
            'entityId'  =>  "int(11) NOT NULL DEFAULT '0' COMMENT 'Entity对象Id'",
            'isTeacher' =>  "tinyint(1) NOT NULL DEFAULT '0' COMMENT '是否老师'",
            'teacherIntroduction'   =>  "varchar(2048) NOT NULL DEFAULT ''",
            'bio'       =>  "char(255) NOT NULL DEFAULT '' COMMENT '一句话自我介绍'",
            'rennId'    =>  "char(64) NOT NULL DEFAULT ''",
            'deleted'   =>  "tinyint(1) NOT NULL DEFAULT '0'",
            'deleteTime'=>  "int(11) NOT NULL DEFAULT '0'",
            "PRIMARY KEY (`id`)",
            "UNIQUE KEY `email` (`email`)",
        ), "ENGINE=MyISAM DEFAULT CHARSET=utf8 COMMENT='用户信息表'");

        $this->insert(
            '{{user_info}}',
            array(
                'id'        =>  1,
                'email'     =>  'admin@eduwind.com',
                'name'      =>  'aadmin',
                'isAdmin'   =>  '1',
                'addTime'   =>  '1408093102',
                'upTime'    =>  '0',
                'face'      =>  '',
                'status'    =>  'ok',
                'introduction'  =>  '',
                'verifyCode'    =>  'LoAf4GYRhyqSYeEBHUGJD9ORgrFHBudz',
                'fanNum'    =>  '0',
                'answerNum' =>  '0',
                'answerVoteupNum'   =>  '0',
                'sex'       =>  '',
                'entityId'  =>  '1',
                'isTeacher' =>  '0',
                'teacherIntroduction'   =>  '',
                'bio'       =>  'aadmin',
                'rennId'    =>  '',
                'deleted'   =>  '0',
                'deleteTime'=>  '0'
            )
        );
	}

	public function down()
	{
        $this->dropTable('{{user_info}}');
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
