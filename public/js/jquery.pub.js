$(function(){
	my.user.start();
});

var my={
	disabled:false,
	user:{
		start:function(){
			$('body').delegate(".user_get_sign","click",function(){
				
			});
			$('body').delegate(".user_get_reg","click",function(){
				
			});
		}
	},
	getCode:function(a,callback){
		if(my.disabled==true){return false;}
		var obj={text:null,sec:60,dis:'已发送成功'};
		obj.text=a.text();my.disabled=true;
		a.text('('+obj.sec+'s) '+obj.dis);
		a.addClass('disabled');
		if($.isFunction(callback)==true){callback()};
		countSec();
		function countSec(){
			var sec=obj.sec;
			$int=setInterval(function(){
				sec=sec-1;
				if(sec<1){clearInterval($int);my.disabled=false;a.removeClass('disabled');return a.text(obj.text);}
				a.text('('+sec+'s) '+obj.dis);
			},1000);
		}
	},
	goUrl:function(a,options){
		var set={
			cache:false,
			reback:false,
			objhtml:'#ajax_display',
		};$.extend(set,options);
		var url=a.data('url'),type=a.data('type');
		switch(type){
			case 'ajax':
			$.ajax({
			type: "GET",
			url:url+='?'+(new Date()).valueOf(),
			data:{},
			dataType:"html",
			beforeSend:function(){
				my.loading();
			},
			success: function(data){
				$(set.objhtml).html(data);
			}
			});
			break;
			case 'url':
				url+='?'+(new Date()).valueOf();
				set.reback==false?$(window).attr('location',url):document.location.replace(url);
			break;
			case 'menu':$(url).animate({left:0},180);break;
		}
		return false;
	},
}
