<?php

class m140729_033049_create_order_log_table extends CDbMigration
{
	public function up()
	{
        $this->createTable('{{order_log}}', array(
            'id'        =>  "int(11) NOT NULL AUTO_INCREMENT COMMENT '主键'",
            'orderId'   =>  "int(11) NOT NULL",
            'note'      =>  "text NOT NULL",
            'addTime'   =>  "int(11) NOT NULL",
            'userId'    =>  "int(11) NOT NULL DEFAULT '0'",
            "PRIMARY KEY (`id`)",
        ), "ENGINE=MyISAM DEFAULT CHARSET=utf8 COMMENT='操作记录'");
	}

	public function down()
	{
        $this->dropTable('{{order_log}}');
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
