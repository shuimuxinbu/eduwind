<?php

class m140729_025805_create_course_table extends CDbMigration
{
	public function up()
	{
        $this->createTable('{{course}}', array(
            'id'            =>  "int(11) NOT NULL AUTO_INCREMENT COMMENT '课程id'",
            'name'          =>  "char(64) NOT NULL COMMENT '课程名称'",
            'userId'        =>  "int(11) NOT NULL COMMENT '课程创建人id'",
            'memberNum'     =>  "int(11) NOT NULL DEFAULT '0' COMMENT '修课人数'",
            'viewNum'       =>  "int(11) NOT NULL DEFAULT '0' COMMENT '点击量'",
            'fee'           =>  "decimal(7,2) NOT NULL DEFAULT '0.00' COMMENT '费用'",
            'entityId'      =>  "int(11) NOT NULL DEFAULT '0'",
            'categoryId'    =>  "int(11) NOT NULL DEFAULT '0' COMMENT '课程分类'",
            'face'          =>  "char(255) NOT NULL DEFAULT '' COMMENT '课程头像存放位置'",
            'introduction'  =>  "text COMMENT '课程简介'",
            'addTime'       =>  "int(11) NOT NULL DEFAULT '0' COMMENT '添加时间'",
            'status'        =>  "int(11) NOT NULL DEFAULT '0' COMMENT '状态，ok,applied,created'",
            'rateScore'     =>  "decimal(3,1) NOT NULL DEFAULT '0.0' COMMENT '平均得分'",
            'rateNum'       =>  "int(11) NOT NULL DEFAULT '0' COMMENT '评分人次'",
            'targetStudent' =>  "varchar(1024) NOT NULL DEFAULT '' COMMENT '目标学员'",
            'subTitle'      =>  "char(255) NOT NULL DEFAULT '' COMMENT '副标题'",
            'isTop'         =>  "tinyint(4) NOT NULL DEFAULT '0' COMMENT '是否推荐'",
            'deleted'       =>  "tinyint(1) NOT NULL DEFAULT '0'",
            'deleteTime'    =>  "int(11) NOT NULL DEFAULT '0'",
            'studentNum'    =>  "int(11) NOT NULL DEFAULT '0'",
            "PRIMARY KEY (`id`)",
            "KEY `userId` (`userId`)",
        ), "ENGINE=MyISAM  DEFAULT CHARSET=utf8 COMMENT='课程表'");
	}

	public function down()
	{
        $this->dropTable('{{course}}');
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
