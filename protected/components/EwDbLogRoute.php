<?php
//define('EW_LOGIN_MANUAL_MSG','手动登录网站');

//define('EW_LOGIN_AUTO','ew.userlogin.auto');
//define('EW_LOGIN_AUTO_MSG','自动登录网站');

class EwDbLogRoute extends CLogRoute
{
	
	const LOGIN_MANUAL = "ew.userlogin.manual";
	const LOGIN_AUTO = "ew.userlogin.auto";
	const LOGIN_MANUAL_MSG = "手动登录网站";
	const LOGIN_AUTO_MSG = "自动登录网站";
	
	
	/**
	 * @var string the ID of CDbConnection application component. If not set, a SQLite database
	 * will be automatically created and used. The SQLite database file is
	 * <code>protected/runtime/log-YiiVersion.db</code>.
	 */
	public $connectionID;
	/**
	 * @var string the name of the DB table that stores log content. Defaults to 'YiiLog'.
	 * If {@link autoCreateLogTable} is false and you want to create the DB table manually by yourself,
	 * you need to make sure the DB table is of the following structure:
	 * <pre>
	 *  (
	 *		id       INTEGER NOT NULL PRIMARY KEY,
	 *		level    VARCHAR(128),
	 *		category VARCHAR(128),
	 *		logtime  INTEGER,
	 *		message  TEXT
	 *   )
	 * </pre>
	 * Note, the 'id' column must be created as an auto-incremental column.
	 * In MySQL, this means it should be <code>id INTEGER NOT NULL AUTO_INCREMENT PRIMARY KEY</code>;
	 * In PostgreSQL, it is <code>id SERIAL PRIMARY KEY</code>.
	 * @see autoCreateLogTable
	 */
	public $logTableName='YiiLog';
	/**
	 * @var boolean whether the log DB table should be automatically created if not exists. Defaults to true.
	 * @see logTableName
	 */
	public $autoCreateLogTable=true;
	/**
	 * @var CDbConnection the DB connection instance
	 */
	private $_db;

	/**
	 * Initializes the route.
	 * This method is invoked after the route is created by the route manager.
	 */
	public function init()
	{
		parent::init();

		if($this->autoCreateLogTable)
		{
			$db=$this->getDbConnection();
			try
			{
				$db->createCommand()->delete($this->logTableName,'0=1');
			}
			catch(Exception $e)
			{
				$this->createLogTable($db,$this->logTableName);
			}
		}
	}

	/**
	 * Creates the DB table for storing log messages.
	 * @param CDbConnection $db the database connection
	 * @param string $tableName the name of the table to be created
	 */
	protected function createLogTable($db,$tableName)
	{
		$db->createCommand()->createTable($tableName, array(
			'id'=>'pk',
			'level'=>'varchar(128)',
			'category'=>'varchar(128)',
			'logtime'=>'integer',
			'message'=>'text',
			'ip'=>'varchar(128)',
		));
	}

	/**
	 * @return CDbConnection the DB connection instance
	 * @throws CException if {@link connectionID} does not point to a valid application component.
	 */
	protected function getDbConnection()
	{
		if($this->_db!==null)
			return $this->_db;
		elseif(($id=$this->connectionID)!==null)
		{
			if(($this->_db=Yii::app()->getComponent($id)) instanceof CDbConnection)
				return $this->_db;
			else
				throw new CException(Yii::t('yii','CDbLogRoute.connectionID "{id}" does not point to a valid CDbConnection application component.',
					array('{id}'=>$id)));
		}
		else
		{
			$dbFile=Yii::app()->getRuntimePath().DIRECTORY_SEPARATOR.'log-'.Yii::getVersion().'.db';
			return $this->_db=new CDbConnection('sqlite:'.$dbFile);
		}
	}

	/**
	 * Stores log messages into database.
	 * @param array $logs list of log messages
	 */
	protected function processLogs($logs)
	{
		$command=$this->getDbConnection()->createCommand();
		foreach($logs as $log)
		{
			$msg = $log[0];
			$endpos = strpos($msg,"\n");
			if ($endpos) {
				$msg = unserialize(substr($msg,0,$endpos));
			}else {
				$msg = unserialize($msg);
			}
			$command->insert($this->logTableName,array(
				'level'=>$log[1],
				'category'=>$log[2],
				'logtime'=>(int)$log[3],
				'message'=>$msg['message'],
                'userId'=>$msg['userId'],
				'ip'=>Yii::app()->request->userHostAddress,
			));
		}
	}
}
