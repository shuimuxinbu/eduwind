<?php

/**
 * UserIdentity represents the data needed to identity a user.
 * It contains the authentication method that checks if the provided
 * data can identity the user.
 */
class JiaThis extends CWidget
{
    public $picSize = 16;
    public $line = 2;

    /**
     * Run widget.
     *
     * use: $this->widget('ext.jiathis.JiaThis', array('line'=>1, 'picSize'=>16));
     */
    public function run()
    {
        echo '<div class="bdsharebuttonbox">';
        if ($this->line===2) {
            echo '<span class="text" style="font-size:16px; display:block;">分享到：</span>';
        } else {
            echo '<span class="text" style="font-size:16px; float:left;">分享到：</span>';
        }

        // 分享按钮
        echo '
            <a title="分享到人人网" href="#" class="bds_renren" data-cmd="renren"></a>
            <a title="分享到新浪微博" href="#" class="bds_tsina" data-cmd="tsina"></a>
            <a title="分享到微信" href="#" class="bds_weixin" data-cmd="weixin"></a><a title="分享到豆瓣网" href="#" class="bds_douban" data-cmd="douban"></a>
            <a title="分享到QQ空间" href="#" class="bds_qzone" data-cmd="qzone"></a>
            <a href="#" class="bds_more" data-cmd="more"></a>
            <div style="clear:both"></div>
        ';

        echo '</div>';

        // JavaScript
        echo '
            <script>
            window._bd_share_config = {
                "common":{"bdSnsKey":{},"bdText":"","bdMini":"2","bdMiniList":false,"bdPic":"","bdStyle":"0","bdSize":"' . $this->picSize . '"},
                "share":{}
            };
            with(document)0[(getElementsByTagName(\'head\')[0]||body).appendChild(createElement(\'script\')).src=\'http://bdimg.share.baidu.com/static/api/js/share.js?v=89860593.js?cdnversion=\'+~(-new Date()/36e5)];
            </script>
        ';

        // 样式
        echo '<style>.bdsharebuttonbox a { margin:0 2px !important; }</style>';
    }

}
