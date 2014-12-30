<?php

require('Environment.php');

/**
 * This is an example Environment, for when you want to use a custom $envVar
 * or $configDir, or want to use other than the predefined modes.
 *
 * If you use the extended class, don't forget to modify your bootstrap file as well
 * to call this class.
 */
class ExampleEnvironment extends Environment
{
	/**
	 * @var string name of env var to check
	 */
	protected $envVar = 'MY_ENVIRONMENT';

	/**
	 * @var string config dir, relative to Environment.php
	 */
	protected $configDir = '../../../config/';

	/**
	 * @var string path to file that might override environment variable
	 */
	protected $modeFile = '../../../config/mode.php';

	/**
	 * Extend Environment class and merge parent array if you want to modify/extend these
	 * @return array list of valid modes
	 */
	function getValidModes()
	{
		return array_merge(parent::getValidModes(), array(
			250 => 'QUALITY_ASSURANCE',
		));
	}
}