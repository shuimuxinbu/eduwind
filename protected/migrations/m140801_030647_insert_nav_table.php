<?php

class m140801_030647_insert_nav_table extends CDbMigration
{
	public function up()
	{
        $this->insert('{{nav}}', array( 
            'id'        =>  '1', 
            'title'     =>  '首页', 
            'activeRule'=>  'return Yii::app()->controller->activeMenu=="site";', 
            'weight'    =>  '0',
            'url'       =>  '/',
            'location'  =>  'top'
        ));

        $this->insert('{{nav}}', array( 
            'id'        =>  '2', 
            'title'     =>  '全部课程', 
            'activeRule'=>  'return Yii::app()->controller->activeMenu=="course";', 
            'weight'    =>  '1',
            'url'       =>  '/index.php?r=course/index/index',
            'location'  =>  'top'
        ));

        $this->insert('{{nav}}', array( 
            'id'        =>  '3', 
            'title'     =>  '小组', 
            'activeRule'=>  'return Yii::app()->controller->activeMenu=="group";', 
            'weight'    =>  '2',
            'url'       =>  '/index.php?r=group/index/index',
            'location'  =>  'top'
        ));

        $this->insert('{{nav}}', array( 
            'id'        =>  '4', 
            'title'     =>  '我的课程', 
            'activeRule'=>  'return Yii::app()->controller->activeMenu=="me";', 
            'weight'    =>  '3',
            'url'       =>  '/index.php?r=course/me',
            'location'  =>  'top'
        ));

        $this->insert('{{nav}}', array( 
            'id'        =>  '5', 
            'title'     =>  '资讯', 
            'activeRule'=>  'return Yii::app()->controller->uniqueId=="article/index";', 
            'weight'    =>  '4',
            'url'       =>  '/index.php?r=article/index',
            'location'  =>  'top'
        ));
    }


	public function down()
	{
        $this->delete('{{nav}}', 'id=:id', array(':id'=>1));
        $this->delete('{{nav}}', 'id=:id', array(':id'=>2));
        $this->delete('{{nav}}', 'id=:id', array(':id'=>3));
        $this->delete('{{nav}}', 'id=:id', array(':id'=>4));
        $this->delete('{{nav}}', 'id=:id', array(':id'=>5));
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
