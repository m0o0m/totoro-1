
/**
 * 绑定回车键到指定button
 * @param buttonId
 * @return
 */
function bindEnterToButton(buttonId){
	document.onkeydown = function(e){
		var e = e || window.event ;
		if(e.keyCode == 13){
			$("#" + buttonId).click();
		};
	};
}
/**
 * 刷新
 */
function refresh () {
	
	location.replace(location.href);
}

/**
 * 后退
 */
function back () {
	
	location.replace(location.href);
}


/**
 * 自适应高度的IFRAME
 * @param id
 */
function iFrameHeight(id) {
	var ifm= document.getElementById(id); 
	var subWeb = document.frames ? document.frames[id].document : ifm.contentDocument;
	if(ifm != null && subWeb != null) { 
		ifm.height = subWeb.body.scrollHeight; 
	}
} 

function downloadAttachment(attId){
	var ajaxurl = $("#ajaxurl").attr("value");
	$.ajax({
		type: "post",
		url: ajaxurl + "!downloadAttachment.do",
		data: {'attid':attId},
		async: true,
		success: function(data){
			alert(data);
		}
	});
}

function showImage(url){
	window.open(url,"_blank","toolbar=no, location=no, directories=no, status=no, menubar=no, scrollbars=yes, resizable=yes, copyhistory=no, width=800, height=600");
};
/**
 * 扩展Date对象 增加format方法 用于格式化日期
 * @param {String} format 格式化字符串 如yyyy-MM-dd
 * @return {String}
 */
Date.prototype.format = function(format) {
	var o = {
		"M+" : this.getMonth() + 1, // month
		"d+" : this.getDate(), // day
		"h+" : this.getHours(), // hour
		"m+" : this.getMinutes(), // minute
		"s+" : this.getSeconds(), // second
		"q+" : Math.floor((this.getMonth() + 3) / 3), // quarter
		"S" : this.getMilliseconds()
		// millisecond
	}
	if (/(y+)/.test(format)){
		format = format.replace(RegExp.$1, (this.getFullYear() + "").substr(4 - RegExp.$1.length));
	}
	for (var k in o){
		if (new RegExp("(" + k + ")").test(format)){
			format = format.replace(RegExp.$1, RegExp.$1.length == 1 ? o[k] : ("00" + o[k]).substr(("" + o[k]).length));
		}
	}
	return format;
};

/**
 * 
 * @return
 */
function leftInfoControl(){
	var $leftarea = $("#leftarea");
	var isShow = $leftarea.css('display');
	if (isShow == 'none') {
		$leftarea.show("slide", { direction: "left" }, 1000);
		$("#cbtn").text("◄");
	} else{
		$leftarea.hide("slide", { direction: "left" }, 1000);
		$("#cbtn").text("►");
	}
};


/**
 * 可以自定义分隔符、分割长度，最终返回的格式化后的字符串。
 * $.format(2000000010, 3, ',');		//result:	2,000,000,010
 * $.format('abcdefghijklmnopqrstuvwxyz', 6, '-');	//result:	ab-cdefgh-ijklmn-opqrst-uvwxyz
 */
(function($) {
	
	
	$.chenty={
		
		root:"${ctx}",
		findDic:function (key){
			
		},
		findDicValue:function (key,value){
			
		}
		
	};
	
	
	
	
	$.extend({
		format : function(str, step, splitor) {
			str = str.toString();
			var len = str.length;
 
			if(len > step) {
				 var l1 = len%step, 
					 l2 = parseInt(len/step),
					 arr = [],
					 first = str.substr(0, l1);
				 if(first != '') {
					 arr.push(first);
				 };
				 for(var i=0; i<l2 ; i++) {
					 arr.push(str.substr(l1 + i*step, step));									 
				 };
				 str = arr.join(splitor);
			 };
			 return str;
		}
	});
})(jQuery);



/// -------------------2014-10-20 after add start 

//---- 判断是否为空 ---
function isEmpty (v) {
	if (v !=undefined && v!=null&&v.length>0) {
		return true;
	}
	return false;
}

/**
 * 判断是不是json对象
 * @param val
 * @returns
 */
function isJson (val) {
	if (val) {
		return val.match("^\{(.+:.+,*){1,}\}$");
	}
	return false;
}

function isString (val) {
//	alert("$.isType(val)-->"+$.type(val)) ;
	return $.type(val) == "string";
	
}
/// -------------------2014-10-20 after add end