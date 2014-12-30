<?php

/**
 * Jcrop Yii extension
 * 
 * Select a cropping area fro an image using the Jcrop jQuery tool and crop
 * it using PHP's GD functions.
 *
 * @copyright © Digitick <www.digitick.net> 2011
 * @license GNU Lesser General Public License v3.0
 * @author Jacques Basseck
 * @author Ianaré Sévi
 *
 */
Yii::import('zii.widgets.jui.CJuiWidget');

/**
 * Base class.
 */
class EJcrop extends CJuiWidget
{
	/**
	 * @var string URL of the picture to crop.
	 */
	public $url;
	/**
	 * @var type Alternate text for the full size image image.
	 */
	public $alt;
	
	public $boxWidth=0;
	public $boxHeight;
	
	public $setSelect=array();
	
	/**
	 * @var array to set buttons options
	 */
	public $buttons = array();
	/**
	 * @var string URL for the AJAX request
	 */
	public $ajaxUrl;
	/**
	 * @var array Extra parameters to send with the AJAX request.
	 */
	public $ajaxParams = array();

	public function init()
	{
		$assets = Yii::app()->getAssetManager()->publish(dirname(__FILE__) . '/assets');

		if (!isset($this->htmlOptions['id'])) {
			$this->htmlOptions['id'] = $this->getId();
		}
		$this->id = $id = $this->htmlOptions['id'];

		echo CHtml::image($this->url, $this->alt, $this->htmlOptions);
		
		if (!empty($this->buttons)) {
			echo '<div class="jcrop-buttons">' .
			CHtml::button($this->buttons['start']['label'], $this->getHtmlOptions('start', 'inline'));
			echo CHtml::button($this->buttons['crop']['label'], $this->getHtmlOptions('crop'));
			echo CHtml::button($this->buttons['cancel']['label'], $this->getHtmlOptions('cancel')) .
			'</div>';
		}
		echo CHtml::hiddenField($id . '_x', 0, array('class' => 'coords'));
		echo CHtml::hiddenField($id . '_y', 0, array('class' => 'coords'));
		echo CHtml::hiddenField($id . '_w', 0, array('class' => 'coords'));
		echo CHtml::hiddenField($id . '_h', 0, array('class' => 'coords'));
		echo CHtml::hiddenField($id . '_x2', 0, array('class' => 'coords'));
		echo CHtml::hiddenField($id . '_y2', 0, array('class' => 'coords'));
		
		$cls = Yii::app()->getClientScript();
		$cls->registerScriptFile($assets . '/js/jquery.Jcrop.js');
		$cls->registerScriptFile($assets . '/js/ejcrop.js', CClientScript::POS_HEAD);
		$cls->registerCssFile($assets . '/css/jquery.Jcrop.min.css');

		$this->options['onChange'] = "js:function(c) {ejcrop_getCoords(c,'{$id}'); ejcrop_showThumb(c,'{$id}');}";
		$this->options['ajaxUrl'] = $this->ajaxUrl;
		$this->options['ajaxParams'] = $this->ajaxParams;
		$this->options['boxHeight'] = $this->boxHeight;
		$this->options['boxWeight'] = $this->boxWidth;
		$this->options['setSelect'] = $this->setSelect;

		$options = CJavaScript::encode($this->options);

		if (!empty($this->buttons)) {
			$js = "ejcrop_initWithButtons('{$id}', {$options});";
		}
		else {
			$js = "jQuery('#{$id}').Jcrop({$options});";
		}
		$cls->registerScript(__CLASS__ . '#' . $id, $js, CClientScript::POS_READY);
	}

	/**
	 * Get the HTML options for the buttons.
	 * 
	 * @param string $name button name
	 * @return array HTML options 
	 */
	protected function getHtmlOptions($name, $display='none')
	{
		if (isset($this->buttons[$name]['htmlOptions'])) {
			if (isset($this->buttons[$name]['htmlOptions']['id'])) {
				throw new CException("id for jcrop '{$name}' button may not be set manually.");
			}
			$options = $this->buttons[$name]['htmlOptions'];

			if (isset($options['class'])) {
				$options['class'] = $options['class'] . " jcrop-{$name}";
			}
			else {
				$options['class'] = "jcrop-{$name}";
			}
			if (isset($options['style'])) {
				$options['style'] = $options['style'] . " display:{$display};";
			}
			else {
				$options['style'] = "display:{$display};";
			}
			$options['id'] = $name . '_' . $this->id;
		}
		else {
			$options = array('id' => $name . '_' . $this->id, 'style' => "display:{$display};", 'class' => "jcrop-{$name}");
		}
		return $options;
	}

}
