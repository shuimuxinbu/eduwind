<?php

/**
 * UserIdentity represents the data needed to identity a user.
 * It contains the authentication method that checks if the provided
 * data can identity the user.
 */
class JiaThis extends CWidget
{
    public $picSize = 16;
    public $line = 1;

    /**
     * Run widget.
     */
    public function run()
    {
        echo '
            <div class="bdsharebuttonbox">
                <span style="font-size:16px;">分享到：</span>
                ';

        if ($this->line===2) echo '<br>';

        echo '
                <a title="分享到人人网" href="#" class="bds_renren" data-cmd="renren"></a>
                <a title="分享到新浪微博" href="#" class="bds_tsina" data-cmd="tsina"></a>
                <a title="分享到微信" href="#" class="bds_weixin" data-cmd="weixin"></a><a title="分享到豆瓣网" href="#" class="bds_douban" data-cmd="douban"></a>
                <a title="分享到QQ空间" href="#" class="bds_qzone" data-cmd="qzone"></a>
                <a href="#" class="bds_more" data-cmd="more"></a>
            </div>
        ';

        echo '
            <script>
            window._bd_share_config = {
                "common":{"bdSnsKey":{},"bdText":"","bdMini":"2","bdMiniList":false,"bdPic":"","bdStyle":"0","bdSize":"' . $this->picSize . '"},
                "share":{}
            };
            with(document)0[(getElementsByTagName(\'head\')[0]||body).appendChild(createElement(\'script\')).src=\'http://bdimg.share.baidu.com/static/api/js/share.js?v=89860593.js?cdnversion=\'+~(-new Date()/36e5)];
            </script>
        ';
    }

}
