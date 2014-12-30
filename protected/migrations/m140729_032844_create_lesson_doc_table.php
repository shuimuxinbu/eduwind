<?php

class m140729_032844_create_lesson_doc_table extends CDbMigration
{
	public function up()
	{
        $this->createTable('{{lesson_doc}}', array(
            'id'            =>  "int(11) NOT NULL AUTO_INCREMENT COMMENT '文档id'",
            'lessonId'      =>  "int(11) NOT NULL DEFAULT '0' COMMENT '课时id'",
            'fileId'        =>  "int(11) NOT NULL DEFAULT '0' COMMENT '文件id，reference(upload_file)'",
            'description'   =>  "text COMMENT '文件描述'",
            'downloadNum'   =>  "int(11) NOT NULL DEFAULT '0' COMMENT '下载次数'",
            "PRIMARY KEY (`id`)",
        ), "ENGINE=MyISAM DEFAULT CHARSET=utf8 COMMENT='课时文档资料'");
	}

	public function down()
	{
        $this->dropTable('{{lesson_doc}}');
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
