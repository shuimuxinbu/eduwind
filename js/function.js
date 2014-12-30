//打开fancybox，供发送私信使用
function openFancyBox(selector){
	 $.fancybox({
		 'type':'ajax',
	     'autoScale': true,
	     'autoDimensions': true,
	     'centerOnScroll': true,
		 'hideOnOverlayClick':false,
	     'href' : $(selector).attr('href')
	  });
}
//关注或取消关注的显示设置
function toggleFollow(obj){
	$.get($(obj).attr('href'),function(data){
		if(data)
			$(obj).text('取消关注').removeClass('btn-success');
		else
			$(obj).text('关注').addClass('btn-success');
	});
	return false;
}

//关注或取消关注的显示设置
function toggleCollect(obj){
	$.get($(obj).attr('href'),function(data){
		if(data){
			$(obj).text('取消收藏');
		}else{
			$(obj).text('收藏');
		}
	});
	return false;
}
//关注话题
/*
function questionFollow(obj){
	$.post($(obj).attr('href'),null,function(data){
		if(data)
			$(obj).text('取消关注').removeClass('btn-success');
		else
			$(obj).text('关注').addClass('btn-success');
	});
	return false;
}
*/

//关注话题
function groupCourseCollect(obj){
	$.post($(obj).attr('href'),null,function(data){
		if(data)
			$(obj).text('从课程区删除').removeClass('btn-success');
		else
			$(obj).text('加入课程区').addClass('btn-success');
	});
	return false;
}

//关注话题
function questionToggleTest(obj){
	$.post($(obj).attr('href'),null,function(data){
		if(data)
			$(obj).text('取消测试问题');
		else
			$(obj).text('设为测试问题');
	});
	return false;
}
//关注话题
function groupJoin(obj){
	$.post($(obj).attr('href'),null,function(data){
		if(data)
			$(obj).text('退出小组').removeClass('btn-success');
		else
			$(obj).text('加入小组').addClass('btn-success');
		window.location.reload();
	});
	return false;
}

//删除课程文件
function deleteCourseFile(obj){
	if(confirm("确定删除文件？")){
		var url=$(obj).attr('href');
		$.post(url,{},function(data){
			if(data)
				window.location.reload();
		});
	}	
}

//邀请回答问题
function questionInvite(elem){
	var url = $(elem).attr('href');
	$.get(url,function(data){
		if(data){
		$(elem).addClass("disable").removeClass("btn-success").text("已邀请");
		}else{
			$(elem).text("操作失败，重试");
		}
	});
}

//确定是否支持浏览器
function isBrowserSupport(){
	return !($.browser.msie && $.browser.version<9);
}
$(document).ready(function(){
	if($('a.dxd-fancy-elem')){
    $('a.dxd-fancy-elem').each(function(){
		if($(this).attr('href')){
	    	var width = $(this).attr('data-fancyWidth');
			var height = $(this).attr('data-fancyHeight');
	    	var config={'type':'iframe',
	    				'autoScale':true,
	    				'hideOnOverlayClick':false,
	    				'fitToView'  : false,
	    				'autoSize'   : true,
	    				 'closeClick' : false,
	    				'openEffect'  : 'none',
	    				 'closeEffect' :'none',
	    				'onClosed':function(){window.location.reload();
	    	
	    	}};
			if(width){
	    		config.width = parseInt(width);
	    	}
			if(height){
				config.height = parseInt(height);
			}else{
				 config.onComplete = function(){
					  $('#fancybox-frame').load(function() { // wait for frame to load and then gets it's height
					       $('#fancybox-content').height($(this).contents().find('body').height());
					     });
				 }
			}
			$(this).fancybox(config);
		}
   });
    
	}
//    $('iframe').iframeAutoHeight({debug: true});
	
});