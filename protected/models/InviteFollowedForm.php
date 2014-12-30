
<?php

/**
 * LoginForm class.
 * LoginForm is the data structure for keeping
 * user login form data. It is used by the 'login' action of 'SiteController'.
 */
class InviteFollowedForm extends CFormModel
{
	public $userIds = array();
	public function rules()
	{
		return array(
		array('userIds','type','type'=>'array','allowEmpty'=>true),
		);
	}
}