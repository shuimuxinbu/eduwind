<?php

/**
 * UserIdentity represents the data needed to identity a user.
 * It contains the authentication method that checks if the provided
 * data can identity the user.
 */
class Jiathis extends CWidget

{
	
	/**
	 * Run widget.
	 */
	public function run()
	{
		echo '<div class="jiathis_style"><span class="jiathis_txt">分享到：</span>
<a class="jiathis_button_renren"></a>
<a class="jiathis_button_douban"></a>
<a class="jiathis_button_qzone"></a>
<a class="jiathis_button_tsina"></a>
<a class="jiathis_button_weixin"></a>

<a href="http://www.jiathis.com/share" class="jiathis jiathis_txt jiathis_separator jtico jtico_jiathis" target="_blank"></a>
</div>
<script type="text/javascript" >
var jiathis_config={
	summary:"",
	shortUrl:false,
	hideMore:false
}
</script>
<script type="text/javascript" src="http://v3.jiathis.com/code/jia.js" charset="utf-8"></script>
';
	}

}