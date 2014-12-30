<?php

class m140815_064830_create_course_post_table extends CDbMigration
{
	public function up()
	{
        $this->createTable(
            '{{course_post}}',
            array(
                'id'        =>  "int(11) NOT NULL AUTO_INCREMENT COMMENT '帖子id'",
                'courseId'  =>  "int(11) NOT NULL",
                'lessonId'  =>  "int(11) NOT NULL DEFAULT '0'",
                'title'     =>  "varchar(128) NOT NULL COMMENT '帖子标题'",
                'content'   =>  "text NOT NULL COMMENT '帖子内容'",
                'upTime'    =>  "int(11) DEFAULT NULL COMMENT '更新时间'",
                'addTime'   =>  "int(11) DEFAULT NULL COMMENT '添加时间'",
                'userId'    =>  "int(11) NOT NULL COMMENT '发表者id'",
                'commentNum'=>  "int(11) NOT NULL DEFAULT '0' COMMENT '回帖总数'",
                'viewNum'   =>  "int(11) NOT NULL DEFAULT '0' COMMENT '浏览总数'",
                'voteNum'   =>  "int(11) NOT NULL DEFAULT '0' COMMENT '投票总数'",
                'isTop'     =>  "tinyint(1) NOT NULL DEFAULT '0' COMMENT '是否置顶'",
                'isDigest'  =>  "tinyint(1) NOT NULL DEFAULT '0' COMMENT '是否精华帖'",
                'voteUpNum' =>  "int(11) NOT NULL DEFAULT '0' COMMENT '赞'",
                'voteDownNum'   =>  "int(11) NOT NULL DEFAULT '0' COMMENT '赞'",
                'commentableEntityId'   =>  "int(11) NOT NULL DEFAULT '0' COMMENT '评论对象id'",
                'entityId'  =>  "int(11) NOT NULL DEFAULT '0' COMMENT 'Entity对象Id'",
                'deleted'   =>  "tinyint(1) NOT NULL DEFAULT '0'",
                'deleteTime'=>  "int(11) NOT NULL DEFAULT '0'",
                "PRIMARY KEY (`id`)",
                "KEY `userId` (`userId`)",
            ),
            "ENGINE=MyISAM AUTO_INCREMENT=20 DEFAULT CHARSET=utf8 COMMENT='讨论区帖子'"
        );
	}

	public function down()
	{
        $this->dropTable('{{course_post}}');
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
