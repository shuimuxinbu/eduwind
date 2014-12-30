<?php

class m140729_034948_create_rate_table extends CDbMigration
{
	public function up()
	{
        $this->createTable('{{rate}}', array(
            'id'        =>  "int(11) NOT NULL AUTO_INCREMENT COMMENT '评论id'",
            'userId'    =>  "int(11) NOT NULL DEFAULT '0' COMMENT '关注者id'",
            'title'     =>  "char(255) NOT NULL DEFAULT '' COMMENT '标题'",
            'content'   =>  "text NOT NULL COMMENT '内容'",
            'addTime'   =>  "int(11) DEFAULT '0' COMMENT '发表时间'",
            'upTime'    =>  "int(11) DEFAULT '0' COMMENT '修改时间'",
            'score'     =>  "int(11) NOT NULL DEFAULT '0' COMMENT '评分'",
            'rateableEntityId'  =>  "int(11) NOT NULL DEFAULT '0' COMMENT '被评价者'",
            "PRIMARY KEY (`id`)",
            "KEY `userId` (`userId`)",
        ), "ENGINE=MyISAM  DEFAULT CHARSET=utf8 COMMENT='评价表'");
	}

	public function down()
	{
        $this->dropTable('{{rate}}');
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
