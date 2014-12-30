/*
 * 元素飘浮
 * @auhtor Rod
 */
$(document).ready(function(){
    // 定义导航栏元素初始position.top值
    var mainNavV = $('.main-nav').position().top;
    // 开始对滚动条改变的监听
    $(window).scroll(function(){
        fixedMainNav(mainNavV);
    });
});

// 主要导航栏飘浮处理函数
function fixedMainNav(mainNavV) {
    var scrollV = $(document).scrollTop();
    if (scrollV > mainNavV) {
        $('.main-nav').addClass('fixed-main-nav');
    } else {
        $('.main-nav').removeClass('fixed-main-nav');
    }
}


/**
 * Next
 */
