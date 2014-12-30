<?php
	
/**
 * EjwPlayer
 * Generates a JWPlayer based on V.6
 * @see http://www.longtailvideo.com for full documentation.
 * @author Paul Szczesmy
 * @version 1.0
 * @license New BSD License
 */
class EJwPlayer extends CWidget {
	
	//Primary Confuration
	public $id;
	public $filepath;
	public $streampath = '';
	public $image;
	public $title;
	public $div = 'media';
	
	//Layout Configuration
	public $controls='true'; //Whether to display player controls
	public $width = '100%';
	public $height = 480;
	public $skin;
	public $stretching='uniform'; //Options: none, exactfit, uniform, fill
	
	//Playback Configuration
	public $autostart = 'false';
	public $fallback = 'true'; //Download link if HTML5 and Flash not support
	public $primary="flash"; // html5 (default) or flash
	public $mute = 'false';
	public $repeat = 'false';
	
	//Advanced Configuration
	public $plugins;
	public $playlist;
	public $listbar;
	public $rtmp;
	public $captions;
	
	public $logo=false; //Watermark config
	public $ga; //Google Analytics block
	public $key; //Key for JW Ads
		
	private $file; //Generated depending upon existence of stream
	private $_path;
	private $options = '';

		
	public function init(){
		if(!isset($this->id)) $this->id=$this->getId();	
		$this->publishAssets();
		$this->file = (!empty($this->streampath)) ? $this->streampath.'_definst_'.$this->filepath : $this->filepath;
		parent::init();
	}
		
	// function to publish and register assets on page
	public function publishAssets() {
		$assets = dirname(__FILE__).'/assets';
		$baseUrl = Yii::app()->assetManager->publish($assets);
		if(is_dir($assets)){
			$this->_path =  $baseUrl;
			Yii::app()->clientScript->registerScriptFile($baseUrl . '/jwplayer.js', CClientScript::POS_HEAD);
			if(!empty($this->key)) Yii::app()->clientScript->registerScript('jwplayerkey', 'jwplayer.key="'.$this->key.'";', CClientScript::POS_HEAD);
		} else {
			throw new Exception('EjwPlayer - Error: Couldn\'t find assets to publish.');
		}
	}
		
	public function run(){
		$this->addOption('file');
		$this->addOption('flashplayer', $this->_path.'/jwplayer.flash.swf');
		$this->addOption('image');
		$this->addOption('title');
		$this->addOption('primary');
		$this->addOption('skin');
		$this->addOption('height');
		$this->addOption('controls');
		$this->addOption('stretching');
		$this->addOption('autostart');
		$this->addOption('mute');
		$this->addOption('repeat');
		$this->addOption('logo');
		$this->addOption('ga');
		$this->addOption('plugins');
		$this->addOption('playlist');
		$this->addOption('listbar');
		$this->addOption('rtmp');
		$this->addOption('captions');
		$this->addOption('width');
		$this->options = rtrim($this->options, ',');
		echo '<div id="'.$this->div.'"></div>
			<script type="text/javascript">
				jwplayer("'.$this->div.'").setup({'.$this->options.'});
			</script>';
	}
	
	/**
	 * Add an option to the global option string
	 * @param String $name The name of the option to add.
	 * @param String $var (optional) The value of the option.
	 */
	private function addOption($name, $var=null) {
		if(isset($this->$name) && is_array($this->$name))  {
			$this->recursiveOptions($name, $this->$name);
		}
		elseif(!empty($var)) $this->options .= ''.$name.': "'.$var.'",';
		elseif(empty($var) && !empty($this->$name)) $this->options .= ''.$name.': "'.$this->$name.'",';
	}
	
	/**
	 * Adds options recursivley to the global option string. Up to 3 options deep. 
	 * @param String $name The name of the top-level option
	 * @param Array $array An array of corresponding keys and values. See usage doc.
	 */
	private function recursiveOptions($name, $array) {
		$this->options .= $name.': [';
		foreach($array as $key => $value) {
			$this->options .= '{';
			if(!is_array($value)) $this->options .= $key.': "'.$value.'",';
			else {
				foreach($value as $k => $v) {
					if(!is_array($v)) $this->options .= $k.': "'.$v.'",';
					else {
						$this->options .= $k.': [';
						foreach($v as $k2 => $v2) {
							$this->options .= '{';
							foreach($v2 as $k3 => $v3) $this->options .= $k3.': "'.$v3.'",';
							$this->options = substr($this->options, 0, -1);
							$this->options .= '},';
						}
						$this->options = substr($this->options, 0, -1);
						$this->options .= '],';
					}
				}
				$this->options = substr($this->options, 0, -1);
			}
			$this->options .= '},';
		}
		$this->options = rtrim($this->options, ',');
		$this->options .= '],';
	}
	
	private function generateSmil() {
		
	}
		
}