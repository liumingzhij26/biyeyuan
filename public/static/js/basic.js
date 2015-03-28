$(function () {

	$('a').bind("focus", function(){
		$(this).blur();
	})

	$.scrollUp({
		scrollName: 'scrollUp', // Element ID
		topDistance: '300', // Distance from top before showing element (px)
		topSpeed: 300, // Speed back to top (ms)
		animation: 'fade', // Fade, slide, none
		animationInSpeed: 200, // Animation in speed (ms)
		animationOutSpeed: 200, // Animation out speed (ms)
		scrollText: '', // Text for element
		activeOverlay: false  // Set CSS color to display scrollUp active point, e.g '#00FFFF'
	});
	
	$('.modal').on('hide', function () {
		$("html,body").animate({scrollTop: $(".thumbnails:first").offset().top}, 10);
	});
	
	var x = -300;
	var y = 20;
	$("img.img-rounded").click(function(e){
		Modal_Info("#Modal_Info",'<img class="img-rounded" src="'+this.src+'" alt="'+this.alt+'">');
	});
	/*
	
		this.myTitle = this.alt;
		//alert(this.myTitle);
		this.title = "";	
		var imgTitle = this.myTitle ? "<br/>" + this.myTitle : "";
		var tooltip = "<div id='tooltip'><img src='"+ this.src +"' width='600px' alt='"+this.myTitle+"'/>"+imgTitle+"<\/div>"; //创建 div 元素
		$("body").append(tooltip);	//把它追加到文档中	
		var _width = $("#tooltip").width();
		var _height = $("#tooltip").height();
		var t_x = (getInner().width - _width) / 2;
		var t_y = (getInner().height - _height) / 2;
		$("#tooltip")
			.css({
				"top": t_x + "px",
				"left":  t_y  + "px"
			}).show("fast");	  //设置x坐标和y坐标，并且显示
		//console.info(_width+" "+_height);
	
    }).mouseout(function(){
		this.title = this.myTitle;	
		$("#tooltip").remove();	 //移除 
    }).mousemove(function(e){
		$("#tooltip")
			.css({
				"top": (e.pageY+y) + "px",
				"left":  (e.pageX+x)  + "px"
			});
	});*/
	
	//Modal_Info("#Modal_Info",'<img class="img-rounded" src="img/j2ee_v1.png" alt="条码管理系统开发">');
	
});

function getObjPoint(x, y) {
	var _x = (getInner().width - x) / 2;
	var _y = (getInner().height - y) / 2;
	return {
		top : _y,
		left : _x
	};
}

function Modal_Info(_Modal_Info,mess) {
	var m_info = $(_Modal_Info);
	//$("html,body").animate({scrollTop: $("body").offset().top}, 10);
	$(".info_s").html(mess);// 先加入消息
	var Point = getObjPoint(750, 375);// 获得居中的坐标
	m_info.css( {
		'position' : 'absolute',
		'top' : Point.top,
		'left' : Point.left,
		'z-index' : '9999'
	});
	m_info.modal( {
		keyboard : true
	});// 不允许关闭模态当退出键被按下
	//为一个提示窗口，一秒钟之后关闭,谷歌浏览器没有问题，但是会报错，不影响运行
}


//判断浏览器大小
function getInner(){
	if(typeof window.innerWidth != 'undefined'){
		return {
			width : window.innerWidth,
			height : window.innerHeight
		}	
	}else{
		return {
			width : document.documentElement.clientWidth,
			height : document.documentElement.clientHeight
		}
	}
}