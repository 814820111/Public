function Tree() {
	this.tree = null;
	this.treeId = "";
	this.codeId = "";
	this.nameId = "";
	this.optsDivId = "";
	this.initCallBack = null;
	this.checkCallBack = null;
	this.cancelCallBack = null;
	this.url = null;
	this.clickHide = null;
	this.downOverHide = null;
	this.showIcon = false;
	this.setting = null;
};

Tree.prototype.initTree = function() {
	var temp = this;
	$("#"+temp.optsDivId).hide();
	var setting = null;
	if (temp.setting != null) {
		setting = temp.setting;
	} else {
		setting = {
			data: {
				simpleData: {
					enable: true,
					rootPId: "0"
				}
			},
			callback: {
				onClick: onClick
			},
			view: {
				fontCss : setFontCss,
				selectedMulti: false,
				showIcon: this.showIcon,
				expandSpeed: (jQuery.browser.msie && parseInt(jQuery.browser.version)<=6)? "":"fast" 
			}
		};
	}
	
	function onClick(event, treeId, treeNode, clickFlag) {
		var code = "";
		var name = "";
		var codeObj = $("#"+temp.codeId);
		var nameObj = $("#"+temp.nameId);
		var nodes = temp.tree.getSelectedNodes();
		if (nodes != undefined && nodes != null && nodes.length > 0) {
			code = nodes[0].id;
			name = nodes[0].name;
		}
		
		codeObj.attr("value", code);
		nameObj.attr("value", name);
		// 改掉是否隐藏
		if (temp.clickHide == undefined || temp.clickHide == null) {
			temp.hideOptions();
		}
		if (temp.checkCallBack != undefined && temp.checkCallBack != null) {
			temp.checkCallBack();
		}
	};
	var zNodes = [];
	$.get(temp.url, null, function(data) {
		var json = data;
		if (json != null && json != "") {
			zNodes = eval(json);
		}
		temp.tree = $.fn.zTree.init($("#"+temp.treeId), setting, zNodes);
		// 默认展开第一层
		/*if (zNodes.length > 0) {
			var node = temp.tree.getNodes();
			temp.tree.expandNode(node[0]);
		}*/
		if (temp.initCallBack != undefined && temp.initCallBack != null) {
			temp.initCallBack();
		}
	});
};

Tree.prototype.showOptions = function() {
	var temp = this;
	if (temp.cancelCallBack != undefined && temp.cancelCallBack != null) {
		temp.cancelCallBack();
	}
	var valObj = $("#"+temp.nameId);
	var valObjOffset = valObj.offset();
	$("#" + temp.optsDivId).css({
		"left": valObjOffset.left+"px",
		"top": valObjOffset.top+valObj.outerHeight()+"px", 
		"min-width": valObj.outerWidth()+"px"
	}).slideDown("fast");
	$("body").bind("mousedown", {id:temp.optsDivId}, onBodyDown);
	function onBodyDown(event) {
		var id = event.data.id;
		if (!(event.target.id == (id) || event.target.id == (temp.optsDivId) 
				|| $(event.target).parents("#"+temp.optsDivId).length > 0)) {
			// 离开是否隐藏
			if (temp.downOverHide == undefined || temp.downOverHide == null) {
				temp.hideOptions();
			}
		}
	};
};

Tree.prototype.hideOptions = function() {
	var temp = this;
	$("#"+temp.optsDivId).fadeOut("fast");
	$("body").unbind("mousedown", "onBodyDown");
};

Tree.prototype.clearTree = function() {
	var temp = this;
	var zNodes = [];
	var setting = [];
	temp.tree = $.fn.zTree.init($("#"+temp.treeId), setting, zNodes);
};


function setFontCss(treeId, treeNode) {
	return treeNode.newcolor ? {'color':treeNode.newcolor} : {};
}