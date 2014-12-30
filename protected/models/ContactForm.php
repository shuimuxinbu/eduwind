<?php

/**
 * LoginForm class.
 * LoginForm is the data structure for keeping
 * user login form data. It is used by the 'login' action of 'SiteController'.
 */
class ContactForm extends CFormModel
{
	public $text;

	/**
	 * Declares the validation rules.
	 * The rules status that username and password are required,
	 * and password needs to be authenticated.
	 */
	public function rules()
	{
		return array(
		// username and password are required
		array('text', 'required'),
		);
	}

	/**
	 * Declares attribute labels.
	 */
	public function attributeLabels()
	{
		return array(
			'text'=>Yii::t('app','邮箱地址'),
		);
	}

	public function parse(){
		$results = array();
		//检测vcard成分
		
		try{
			Yii::import('ext.vcardparser.vCard');
			$vcard = new vCard(false,$this->text);
			if(count($vcard) == 1){
			//	var_dump($vcard->n);
				$results[$vcard->email[0]['Value']] = array('name'=>$vcard->fn[0],'email'=>$vcard->email[0]['Value']);
			}else{
				foreach ($vcard as $item)
				{
		//			var_dump($item->fn);
					if(isset($item->email[0]['Value'])){
						$results[$item->email[0]['Value']] = array('email'=>$item->email[0]['Value']);
						$results[$item->email[0]['Value']]['name'] = isset($item->fn[0]) ? $item->fn[0] : "";
					}
				}
			}
		}catch(Exception $e){}

		//检测所有所有email
		$pattern = '/[A-Za-z0-9_-]+@[A-Za-z0-9_-]+(\.([A-Za-z0-9_-][A-Za-z0-9_]+)){1,5}/i'; //regex for pattern of e-mail address
		preg_match_all($pattern, $this->text, $matches);
		foreach($matches[0] as $item){
			if(!isset($results[$item]))
			$results[$item] = array('name'=>"",'email'=>$item);
		}
		return $results;

	}

}
