<?php

/*
 * EFancyBox widget class file.
 * @author Thiago Otaviani Vidal <thiagovidal@othys.com>
 * @link http://www.othys.com
 * Copyright (c) 2010 Thiago Otaviani Vidal
 * MADE IN BRAZIL
 
 * Permission is hereby granted, free of charge, to any person
 * obtaining a copy of this software and associated documentation
 * files (the "Software"), to deal in the Software without
 * restriction, including without limitation the rights to use,
 * copy, modify, merge, publish, distribute, sublicense, and/or sell
 * copies of the Software, and to permit persons to whom the
 * Software is furnished to do so, subject to the following
 * conditions:

 * The above copyright notice and this permission notice shall be
 * included in all copies or substantial portions of the Software.

 * THE SOFTWARE IS PROVIDED "AS IS", WITHOUT WARRANTY OF ANY KIND,
 * EXPRESS OR IMPLIED, INCLUDING BUT NOT LIMITED TO THE WARRANTIES
 * OF MERCHANTABILITY, FITNESS FOR A PARTICULAR PURPOSE AND
 * NONINFRINGEMENT. IN NO EVENT SHALL THE AUTHORS OR COPYRIGHT
 * HOLDERS BE LIABLE FOR ANY CLAIM, DAMAGES OR OTHER LIABILITY,
 * WHETHER IN AN ACTION OF CONTRACT, TORT OR OTHERWISE, ARISING
 * FROM, OUT OF OR IN CONNECTION WITH THE SOFTWARE OR THE USE OR
 * OTHER DEALINGS IN THE SOFTWARE.

 * EFancyBox extends CWidget and implements a base class for a fancybox widget.
 * more about fancybox can be found at http://fancybox.net/.
 * @version: 1.6
 */
class HoverCard extends CWidget
{
	// @ string the id of the widget, since version 1.6
	public $id;
	// @ string the taget element on DOM
	public $target;
//	public $loading;
//	public $url;
	// @ boolean whether to enable the easing functions. You must set the eansing on $config.
//	public $easingEnabled=false;
	// @ boolean whether to enable mouse interaction
//	public $mouseEnabled=true;
	// @ array of config settings for fancybox
	public $config=array();
	
	// function to init the widget
	public function init()
	{
		// if not informed will generate Yii defaut generated id, since version 1.6
		if(!isset($this->id))
			$this->id=$this->getId();
		// publish the required assets
		$this->publishAssets();
		$assets = dirname(__FILE__).'/assets';
		$baseUrl = Yii::app()->assetManager->publish($assets);
		$this->config['placeHolder'] = $baseUrl."/loading.gif";
	}
	
	// function to run the widget
    public function run()
    {
		$config = CJavaScript::encode($this->config);
		Yii::app()->clientScript->registerScript($this->getId(), "
			$('$this->target').hoverCard($config);
		");
	}
	
	// function to publish and register assets on page 
	public function publishAssets()
	{
		$assets = dirname(__FILE__).'/assets';
		$baseUrl = Yii::app()->assetManager->publish($assets);
		if(is_dir($assets)){
			Yii::app()->clientScript->registerCoreScript('jquery');
			Yii::app()->clientScript->registerScriptFile($baseUrl . '/hoverCard.js');
			Yii::app()->clientScript->registerCssFile($baseUrl . '/main.css');
		} else {
			throw new Exception('HoverCard - Error: Couldn\'t find assets to publish.');
		}
	}
}