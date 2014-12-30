<?php

class m140729_033007_create_order_table extends CDbMigration
{
	public function up()
	{
        $this->createTable('{{order}}', array(
            'id'        =>  "int(11) NOT NULL AUTO_INCREMENT COMMENT '主键'",
            'status'    =>  "enum('created','paid','cancelled') NOT NULL",
            'subject'   =>  "char(255) NOT NULL",
            'produceEntityId'   =>  "int(11) NOT NULL",
            'userId'    =>  "int(11) NOT NULL",
            'meansOfPayment'    =>  "enum('none','alipay','tenpay','aliGuaran') DEFAULT NULL",
            'price'     =>  "float NOT NULL DEFAULT '0'",
            'addTime'   =>  "int(11) NOT NULL DEFAULT '0'",
            'paidTime'  =>  "int(11) NOT NULL DEFAULT '0'",
            'tradeNo'   =>  "char(32) NOT NULL DEFAULT ''",
            "PRIMARY KEY (`id`)",
        ), "ENGINE=MyISAM DEFAULT CHARSET=utf8 COMMENT='订单'");
	}

	public function down()
	{
        $this->dropTable('{{order}}');
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
