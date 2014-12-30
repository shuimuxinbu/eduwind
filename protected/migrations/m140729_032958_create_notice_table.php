<?php

class m140729_032958_create_notice_table extends CDbMigration
{
	public function up()
	{
        $this->createTable('{{notice}}', array(
            'id'        =>  "int(11) NOT NULL AUTO_INCREMENT COMMENT '通知id'",
            'userId'    =>  "int(11) NOT NULL COMMENT '用户id'",
            'data'      =>  "varchar(1024) DEFAULT '' COMMENT '数据'",
            'type'      =>  "char(255) NOT NULL DEFAULT '' COMMENT '通知类型'",
            'addTime'   =>  "int(11) NOT NULL DEFAULT '0' COMMENT '添加时间'",
            'isChecked' =>  "tinyint(1) NOT NULL DEFAULT '0' COMMENT '是否已读，1已读，0未读'",
            "PRIMARY KEY (`id`)",
            "KEY `userId` (`userId`)",
        ), "ENGINE=MyISAM  DEFAULT CHARSET=utf8 COMMENT='提醒，通知'");
	}

	public function down()
	{
        $this->dropTable('{{notice}}');
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
