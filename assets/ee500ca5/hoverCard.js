(function($){
	//显示队列，删除队列，名片名字（对应用CSS文件中的类名）
	var _showQueue=null,_removeQueue=null,_cardName="bm_hover_card";
	
	$.fn.hoverCard=function(options){
		var opts = $.extend({}, $.fn.hoverCard.defaults, options); 
		return $(this).each(function() {
			var hoverObject = $(this);			
			
			hoverObject.live("mouseenter",function(e){
				//清除所有显示的名片
				removeShowedCard();				
				//显示名片
				showCard(hoverObject,opts);
				e.stopPropagation();
				
			}).live("mouseleave",function(e){
				
				if(!$(this).data("current")){
					clearQueue(_showQueue);
				}else{
					removeCard(opts.removeTimeout);
					//鼠标移动到名片上
					$(".bm_hover_card").hover(function(){
						clearQueue(_removeQueue);
					},function(){
						removeCard(opts.removeTimeout);
					});
				}
				$(this).removeData("current");
				e.stopPropagation();
			});
        });
	};
	//构造名片
	hoverCardBuilder=function(hoverObject,opts){
		//设置名片显示位置nTop,nLeft
		var nTop=hoverObject.offset().top + hoverObject.height()-6,nLeft=hoverObject.offset().left-120+ hoverObject.width()/2;
		
		var bmHoverCard = $("<div>").addClass(_cardName).css({"top": nTop,"left": nLeft});		
		var bmHoverCardArrow = $("<div>").addClass(_cardName+"_arrow");
		var bmHoverCardBorder = $("<div>").addClass(_cardName+"_border");
			opts.borederRadius && bmHoverCardBorder.addClass(_cardName+"_radius");
		
		var bmLoading = $("<img>").attr({"src": opts.placeHolder}).addClass("loading");
		var bmHoverCardBefore = $("<div>").addClass(_cardName+"_before").html(bmLoading);
		var bmHoverCardContainer = $("<div>").addClass(_cardName+"_container").html(bmHoverCardBefore);		
		/**加入DOM**/
		bmHoverCard.append(bmHoverCardArrow).append(bmHoverCardBorder).append(bmHoverCardContainer);			
		return bmHoverCard;
	};
	//显示名片
	showCard=function(hoverObject,opts){
		if(hoverObject && !hoverObject.data("current")){
			var sContent=hoverCardBuilder(hoverObject,opts);
				_showQueue=setTimeout(function(){
										  $("body").prepend(sContent);
										  hoverObject.data("current",true);
										  
										  getCardData(hoverObject,opts);
										  										  
									  }, opts.showTimeout);
		}
	};
	//移除名片
	removeCard=function(removeTimeout){
		_removeQueue = setTimeout(function () { removeShowedCard() }, removeTimeout);
	};
	//清除队列
	clearQueue=function(queue){
		!!queue && clearTimeout(queue);
	}
	//清除所有队列及已显示的名片
	removeShowedCard=function(){
		clearQueue(_showQueue);
		clearQueue(_removeQueue);
		$("."+_cardName).remove();
	};
	//获取名片数据
	getCardData=function(hoverObject,opts){		
		if(!!opts.url){
			$.ajax({
				url:opts.url,
				type:opts.type,
				data:{"userid":hoverObject.attr("data-userid")},
				dataType:opts.dataType,
				timeout:8000,
				success:function(data){
					$("."+_cardName+"_container").html(data);
				},
				error:function(){
					$("."+_cardName+"_before").text(opts.errorText);
				}
			});			
		}else{
			$("."+_cardName+"_before").text(opts.errorText);
		}
	};
	//默认设置
	$.fn.hoverCard.defaults={
		url:null,
		type:"post",
		dataType:"html",
		showTimeout:400,
		removeTimeout:300,
		borederRadius:true,
		errorText:"读取错误"
//		placeHolder:siteUrl+"public/js/hovercard/loading.gif"
	};
})(jQuery);