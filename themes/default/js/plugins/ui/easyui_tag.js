
var easyUi = new Object();

//按钮操作 start
/**
 * 
 */
var easyUiButtons;
var linkButtons = new Array();
linkButtons["add"] = {text: '添加',iconCls: 'icon-add',handler: function () {addFun();},plain:true};
linkButtons["edit"] = {text: '修改',iconCls: 'icon-edit',handler: function () {editFun();},plain:true};
linkButtons["remove"] = {text: '删除',iconCls: 'icon-remove',handler: function () {removeFun();},plain:true};
linkButtons["refresh"] = {text: '刷新',iconCls: 'icon-refresh',handler: function () {removeFun();},plain:true};
linkButtons["cancell"] = {text: '注销',iconCls: 'icon-no',handler: function () {saveFun();},plain:true};
linkButtons["save"] = {text: '保存',iconCls: 'icon-save',handler: function () {saveFun();},plain:true};
linkButtons["rest"] = {text: '重置',iconCls: 'icon-save',handler: function () {removeFun();},plain:true};


linkButtons["setting"] = {text: '编辑',iconCls: 'icon-i-edit',handler: function () {removeFun();},plain:true};

function getLinkButtons (buttons) {
	
	var result = new Array();
	
	
	for (var i=0;i<buttons.length;i++) {
		
		var button = linkButtons[buttons[i].name];
		if (buttons[i].handler!=undefined) {
			button.handler= buttons[i].handler;
		}
		if (buttons[i].text!=undefined) {
			button.text= buttons[i].text;
		}
		if(buttons[i].iconCls!=undefined) {
			button.iconCls= buttons[i].iconCls;
		}
		result[i] = button;
	}
	
	return result;
}

easyUi.getButton = function (panel,button,func) {
	
	linkButtons[button].handler=func;
	$('#'+panel).linkbutton(linkButtons[button]);
};

easyUi.initButton = function (buttons) {
	
	easyUiButtons = getLinkButtons(buttons);
	for (var i in easyUiButtons) {
		var id = 'b_'+easyUiButtons[i].id+i;
		easyUiButtons[i].id = id;
	}
	return easyUiButtons;
};

easyUi.initButtonBar = function (panel,buttons) {
	
	var result = new Array();
	easyUiButtons = getLinkButtons(buttons);

	for (var i in easyUiButtons) {
		var id = 'bb_'+easyUiButtons[i].id+i;
		$('#'+panel).html($('#'+panel).html()+'<a id="'+id+'"></a>');
		easyUiButtons[i].id = id;
		result[i]=easyUiButtons[i];
	}
	$.each (result,function (i){
		
		$('#'+result[i].id).linkbutton(result[i]);
		$('#'+result[i].id).click(eval(result[i].handler));
	});
	
};
easyUi.buttonBar = function () {
	
	alert("buttonBar");
};

easyUi.filterBar = function () {
	
	alert("buttonBar");
};
//按钮操作 end


easyUi.grid = function (page,panel,buttons){

};

easyUi.selectDatagrid = function (dataGridId){
	return $(dataGridId).datagrid('getSelected');
};

easyUi.selectsDatagrid = function (dataGridId,fields) {
	
	var rows = $(dataGridId).datagrid('getSelections');
	var result = [];
	if (isEmpty(fields)) {
		var fs = fields.split(",");
		for (var j in rows) {
			var row = rows[j];
			var r = {};
			for (var i in fs) {
				r[fs[i]]=row[fs[i]];
			}
			result.push(r);
		}
	}else {
		result = rows;
	}
	return result;
};

easyUi.getData =function (dataGridId) {
	return $(dataGridId).getData();
};

// form 操作 -- start
easyUi.dataGridToForm = function (dataGridId,formId,prefix) {
	
	var selected = $(dataGridId).datagrid('getSelected');
	
	easyUi.loadForm(formId,selected,prefix);
};

/**
 * row 如果是datagridId 那么就有验证row 是否有选择的值
 */
easyUi.loadForm = function (formid,row,prefix) {
	var data = {};
	
	if (isString(row)){
		row = easyUi.selectsDatagrid(row);
		if (!row || row.length < 1 ) {
			msgAlertWarning("您没有选择数据，请选择一条数据");
			return false;
		}else if (row.length>1){
			msgAlertWarning("您选择数据过多，请只选择一条记录");
			return false;
		}
		
		row = row[0]; 
		
	}
	
	if (prefix == undefined) {
		$(formid).form("load", row);
	}else {
		
		$.each(row, function(name, value) {
			data[prefix + name] = value;
		});
//		for (var i in data) {
//			alert("pp-->"+i+"-->"+data[i]);
//		}
		$(formid).form("load", data);
	};
	
	return true;
};



easyUi.valid = function (id) {
	
//	var flag = false;
//	$('#input').each(function () {
//	    if ($(this).attr('required') || $(this).attr('validType')) {
//	    if (!$(this).validatebox('isValid')) {
//	        flag = false;
//	        return;
//	    }
//	    }
//	});
	return $(id).form('validate');
};
//form 操作 -- end
// 提示信息---start -----
//弹出信息窗口 title:标题 msgString:提示信息 msgType:信息类型 [error,info,question,warning]

function msgSuccess (data) {

	
	var msgString = data.msg;
	var result = data.result;
//	for (var i in data) {
//		alert(i+"-->"+data[i]);
//	}
	var title = "操作失败";
	if (!result) {
//		title = "";
	}else {
		if (result == "1") {
			title = "操作成功";
		}else {
			
		}
	}
	msgShow(title, msgString, "show",5000);
}

function msgShow(title, msgString, msgType,timeout) {
	$.messager.show({
		title:title,
		msg:msgString,
		timeout:timeout,
		showType:msgType,
	});
}

function msgAlert(title, msgString, msgType){
	if (!msgString) {
		msgString = title;
		arguments[0] = "系统提示"; 
	}
	$.messager.alert(title, msgString, msgType);
}
function msgAlertError(title, msgString){
	msgAlert (title,msgString,"error"); 
}
function msgAlertInfo(title, msgString){
	msgAlert (title,msgString,"info"); 
}
/**
 * 
 * @param [title]    
 * @param msgString
 */
function msgAlertWarning(title, msgString){
	
	msgAlert (title,msgString,"warning"); 
}

// 提示信息---end\ -----
//-------------------------
//初始化菜单 -- start 
easyUi.menu = function (_menus) {
	 $(".easyui-accordion").empty();
//	 alert(0);
	 $.each(_menus.menus, function(i, n) {
		 var menulist = "";
//		 alert(1);
		 menulist += '<ul>';
		 	var r = n.children;
	        $.each(r, function(j, o) {
//	        	alert(2+">"+o.url+"-->"+o.icon+"==>"+o.name);
//				menulist += '<li><div><a target="mainFrame'+i+j+'" href="' + o.url + '"  onclick="onclickMenu(this)" ><span class="icon '+o.icon+'" ></span>' + o.menuname + '</a></div></li> ';
				menulist += '<li><div><a target="mainFrame'+i+j+'" href="' + o.url + '"  onclick="onclickMenu(this)" ><span class="icon '+o.icon+'" ></span>' + o.name + '</a></div></li> ';
			    
	        });
	     menulist += '</ul>';
	
	     $(".easyui-accordion").accordion('add',{
			title:n.name,
			content:menulist,
			collapsible: true,
		 }).accordion('select',0);
	 });
};
//
function onclickMenu (obj) {
	var target = obj.target;
	var txt = obj.text;
	easyUi.addTab("#tabs",txt,createFrame(target));
}
//初始化菜单 -- end 
function createFrame(target){
	var s = '<iframe name="'+target+'" scrolling="auto" frameborder="0" style="width:100%;height:100%;"></iframe>';
	return s;
}

var index = 0 ;

/**
 * 添加一个tab页
 */
easyUi.addTab = function (id,title,context) {
	if(!$(id).tabs('exists',title)){
		$(id).tabs('add',{
			title: title,
//			content: '<div style="padding:10px">'+context+'</div>',
			content: context,
			closable: true,
			width:$(id).width()-10,
			height:$(id).height()-26
		});
	}else {
		$(id).tabs('select',title);
	}
	
};

/**
 * 右键的菜单 按钮项格式{ text: 'New Item', iconCls: 'icon-ok', onclick: function(){alert('New Item')} }
 */
easyUi.contextMenu = function (e,menuId,buttons) {
	e.preventDefault();
	var _menu =$('#' + menuId);
//	alert(_menu.length);
	if (_menu.length) {
		_menu.remove();
	}
	_menu=$("<div id='"+menuId+"'>").appendTo('body').menu({});
	for (var i in buttons) {
		_menu.menu('appendItem', buttons[i]);
	}
	_menu.menu('show', {
		left: e.pageX,
		top: e.pageY
	});
};

// --- 删除的功能    datagridId ;key id,name;url 删除的url----
easyUi.del = function (datagridId,key,url,success) {
	var rows = easyUi.selectsDatagrid(datagridId, "id");
	if (!rows||rows=="") {
		msgAlertWarning("请先选择一条记录");
		return ;
	}
	
	var ks = key.split(",");
	var re = {};
	for (var j in ks) {
		var rs = "";
		for (var i in rows){
			rs += rows[i].id+",";
		}
		if (rs.length>0) {
			rs = rs.substring(0, rs.length-1);
		}
		re[ks[j]]=rs;
	}
	
	ajaxSubmit(url, re, function(data){
		//$(datagridId).datagrid("reload");
		if (success) {
			success(data,rows);
		}else {
			msgSuccess(data);
		}
	});
};


function ajaxSubmit(url,params,success,isFormat){
	
	var data = {};
	if (isFormat){
		data={"params":JSON.stringify(params)};
	}else{
		data = params;
	}
	
	$.ajax({
        url: url,
        type: "POST",
        dataType: "json",
//        contentType: "application/json",
        data: data,
        cache: false,
        traditional:true,
        error: function (jqXHR) {
            alert(jqXHR.statusText);
        },
        
        success: function (d){
        	success($.extend(data,d));
        },
        complete: function () {
//            alert("complete");
        }
    });
}

// -------------------------------using----------------

// form start -------------


/**
 * form 表单提交
 * obj={formId,success,submit,params}
 * formId *
 */
easyUi.formSubmit = function (obj) {
	
//	formId,success,submit
	
	var formId = obj.formId;	

	var _obj = {
		submit :function() {},
		success:function(data) {},
		prefix:"",
		params:{}
	};
	
	obj = $.extend(_obj,obj);
	
	var form = $(formId);
	var action = form.attr("action");
	var _action = action;
	if (action == undefined || action == "") {
		var id = form.attr("id");
		if (id==undefined) {
			msgAlert("页面错误","调用easyUi.formSubmit时使用了无效id:"+formId,"error");
		} else {
			msgAlert("页面错误","id 为"+id+"的form标签没有填写action属性。","error");
		}
		return ;
	}
	var pars = "";
	$.each(obj.params,function (i , value){
		pars += i +"="+ value+"&";
	});
	
	action += "?"+pars;

	form.form("submit", {
		url:action,
		onSubmit : function() {
			easyUi.valid(form);
			// 可以验证
			obj.submit();
		},
		success : function(data) {
			data = jQuery.parseJSON(data);
			obj.success(data);
		},
	});
	form.attr("action",_action);
};

// form end -------------




