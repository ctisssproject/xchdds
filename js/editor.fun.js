/*
	[Discuz!] (C)2001-2009 Comsenz Inc.
	This is NOT a freeware, use is subject to license terms

	$Id: common.js 20560 2009-10-09 05:29:36Z monkey $
*/

var BROWSER = {};
var USERAGENT = navigator.userAgent.toLowerCase();
BROWSER.ie = window.ActiveXObject && USERAGENT.indexOf('msie') != -1 && USERAGENT.substr(USERAGENT.indexOf('msie') + 5, 3);
BROWSER.firefox = document.getBoxObjectFor && USERAGENT.indexOf('firefox') != -1 && USERAGENT.substr(USERAGENT.indexOf('firefox') + 8, 3);
BROWSER.chrome = window.MessageEvent && !document.getBoxObjectFor && USERAGENT.indexOf('chrome') != -1 && USERAGENT.substr(USERAGENT.indexOf('chrome') + 7, 10);
BROWSER.opera = window.opera && opera.version();
BROWSER.safari = window.openDatabase && USERAGENT.indexOf('safari') != -1 && USERAGENT.substr(USERAGENT.indexOf('safari') + 7, 8);
BROWSER.other = !BROWSER.ie && !BROWSER.firefox && !BROWSER.chrome && !BROWSER.opera && !BROWSER.safari;
BROWSER.firefox = BROWSER.chrome ? 1 : BROWSER.firefox;

var DISCUZCODE = [];
DISCUZCODE['num'] = '-1';
DISCUZCODE['html'] = [];
var CSSLOADED = [];
var JSMENU = [];
JSMENU['active'] = [];
JSMENU['timer'] = [];
JSMENU['drag'] = [];
JSMENU['layer'] = 0;
JSMENU['zIndex'] = {'win':200,'menu':300,'prompt':400,'dialog':500};
JSMENU['float'] = '';
var AJAX = [];
AJAX['debug'] = 0;
AJAX['url'] = [];
AJAX['stack'] = [0, 0, 0, 0, 0, 0, 0, 0, 0, 0];
var clipboardswfdata = '';
var CURRENTSTYPE = null;
var discuz_uid = isUndefined(discuz_uid) ? 0 : discuz_uid;
var creditnotice = isUndefined(creditnotice) ? '' : creditnotice;
var cookiedomain = isUndefined(cookiedomain) ? '' : cookiedomain;
var cookiepath = isUndefined(cookiepath) ? '' : cookiepath;

if(BROWSER.firefox && window.HTMLElement) {
	HTMLElement.prototype.__defineSetter__('outerHTML', function(sHTML) {
        	var r = this.ownerDocument.createRange();
		r.setStartBefore(this);
		var df = r.createContextualFragment(sHTML);
		this.parentNode.replaceChild(df,this);
		return sHTML;
	});

	HTMLElement.prototype.__defineGetter__('outerHTML', function() {
		var attr;
		var attrs = this.attributes;
		var str = '<' + this.tagName.toLowerCase();
		for(var i = 0;i < attrs.length;i++){
			attr = attrs[i];
			if(attr.specified)
			str += ' ' + attr.name + '="' + attr.value + '"';
		}
		if(!this.canHaveChildren) {
			return str + '>';
		}
		return str + '>' + this.innerHTML + '</' + this.tagName.toLowerCase() + '>';
        });

	HTMLElement.prototype.__defineGetter__('canHaveChildren', function() {
		switch(this.tagName.toLowerCase()) {
			case 'area':case 'base':case 'basefont':case 'col':case 'frame':case 'hr':case 'img':case 'br':case 'input':case 'isindex':case 'link':case 'meta':case 'param':
			return false;
        	}
		return true;
	});
	HTMLElement.prototype.click = function(){
		var evt = this.ownerDocument.createEvent('MouseEvents');
		evt.initMouseEvent('click', true, true, this.ownerDocument.defaultView, 1, 0, 0, 0, 0, false, false, false, false, 0, null);
		this.dispatchEvent(evt);
	};
}

function DocumentElementById(id) {
	return document.getElementById(id);
}

function display(id) {
	DocumentElementById(id).style.display = DocumentElementById(id).style.display == '' ? 'none' : '';
}

function isUndefined(variable) {
	return typeof variable == 'undefined' ? true : false;
}

function in_array(needle, haystack) {
	if(typeof needle == 'string' || typeof needle == 'number') {
		for(var i in haystack) {
			if(haystack[i] == needle) {
					return true;
			}
		}
	}
	return false;
}

function trim(str) {
	return (str + '').replace(/(\s+)$/g, '').replace(/^\s+/g, '');
}

function strlen(str) {
	return (BROWSER.ie && str.indexOf('\n') != -1) ? str.replace(/\r?\n/g, '_').length : str.length;
}

function mb_strlen(str) {
	var len = 0;
	for(var i = 0; i < str.length; i++) {
		len += str.charCodeAt(i) < 0 || str.charCodeAt(i) > 255 ? (charset == 'utf-8' ? 3 : 2) : 1;
	}
	return len;
}

function mb_cutstr(str, maxlen, dot) {
	var len = 0;
	var ret = '';
	var dot = !dot ? '...' : '';
	maxlen = maxlen - dot.length;
	for(var i = 0; i < str.length; i++) {
		len += str.charCodeAt(i) < 0 || str.charCodeAt(i) > 255 ? (charset == 'utf-8' ? 3 : 2) : 1;
		if(len > maxlen) {
			ret += dot;
			break;
		}
		ret += str.substr(i, 1);
	}
	return ret;
}

function checkall(form, prefix, checkall) {
	var checkall = checkall ? checkall : 'chkall';
	count = 0;
	for(var i = 0; i < form.elements.length; i++) {
		var e = form.elements[i];
		if(e.name && e.name != checkall && (!prefix || (prefix && e.name.match(prefix)))) {
			e.checked = form.elements[checkall].checked;
			if(e.checked) {
				count++;
			}
		}
	}
	return count;
}

function doane(event) {
	e = event ? event : window.event;
	if(!e) return;
	if(BROWSER.ie) {
		e.returnValue = false;
		e.cancelBubble = true;
	} else if(e) {
		e.stopPropagation();
		e.preventDefault();
	}
}

function _attachEvent(obj, evt, func, eventobj) {
	eventobj = !eventobj ? obj : eventobj;
	if(obj.addEventListener) {
		obj.addEventListener(evt, func, false);
	} else if(eventobj.attachEvent) {
		obj.attachEvent('on' + evt, func);
	}
}

function _detachEvent(obj, evt, func, eventobj) {
	eventobj = !eventobj ? obj : eventobj;
	if(obj.removeEventListener) {
		obj.removeEventListener(evt, func, false);
	} else if(eventobj.detachEvent) {
		obj.detachEvent('on' + evt, func);
	}
}

function setcookie(cookieName, cookieValue, seconds, path, domain, secure) {
	var expires = new Date();
	expires.setTime(expires.getTime() + seconds * 1000);
	domain = !domain ? cookiedomain : domain;
	path = !path ? cookiepath : path;
	document.cookie = escape(cookieName) + '=' + escape(cookieValue)
		+ (expires ? '; expires=' + expires.toGMTString() : '')
		+ (path ? '; path=' + path : '/')
		+ (domain ? '; domain=' + domain : '')
		+ (secure ? '; secure' : '');
}

function getcookie(name) {
	var cookie_start = document.cookie.indexOf(name);
	var cookie_end = document.cookie.indexOf(";", cookie_start);
	return cookie_start == -1 ? '' : unescape(document.cookie.substring(cookie_start + name.length + 1, (cookie_end > cookie_start ? cookie_end : document.cookie.length)));
}

function thumbImg(obj, method) {
	if(!obj) {
		return;
	}
	obj.onload = null;
	file = obj.src;
	zw = obj.offsetWidth;
	zh = obj.offsetHeight;
	if(zw < 2) {
		if(!obj.id) {
			obj.id = 'img_' + Math.random();
		}
		setTimeout("thumbImg(DocumentElementById('" + obj.id + "'), " + method + ")", 100);
		return;
	}
	zr = zw / zh;
	method = !method ? 0 : 1;
	if(method) {
		fixw = obj.getAttribute('_width');
		fixh = obj.getAttribute('_height');
		if(zw > fixw) {
			zw = fixw;
			zh = zw / zr;
		}
		if(zh > fixh) {
			zh = fixh;
			zw = zh * zr;
		}
	} else {
		var widthary = imagemaxwidth.split('%');
		if(widthary.length > 1) {
			fixw = DocumentElementById('wrap').clientWidth - 200;
			if(widthary[0]) {
				fixw = fixw * widthary[0] / 100;
			} else if(widthary[1]) {
				fixw = fixw < widthary[1] ? fixw : widthary[1];
			}
		} else {
			fixw = widthary[0];
		}
		if(zw > fixw) {
			zw = fixw;
			zh = zw / zr;
			obj.style.cursor = 'pointer';
			if(!obj.onclick) {
				obj.onclick = function() {
					zoom(obj, obj.src);
				};
			}
		}
	}
	obj.width = zw;
	obj.height = zh;
}

function imgzoom() {}
function attachimg() {}

function setCopy(text, msg){
	if(BROWSER.ie) {
		clipboardData.setData('Text', text);
		if(msg) {
			showDialog(msg, 'notice');
		}
	} else {
		var msg = '<div style="text-decoration:underline;">点此复制到剪贴板</div>' +
			AC_FL_RunContent('id', 'clipboardswf', 'name', 'clipboardswf', 'devicefont', 'false', 'width', '120', 'height', '40', 'src', 'images/common/clipboard.swf', 'menu', 'false',  'allowScriptAccess', 'sameDomain', 'swLiveConnect', 'true', 'wmode', 'transparent', 'style' , 'margin-top:-20px');
		showDialog(msg, 'info');
		text = text.replace(/[\xA0]/g, ' ');
		clipboardswfdata = text;
	}
}

function getClipboardData() {
	window.document.clipboardswf.SetVariable('str', clipboardswfdata);
}

function saveData() {
	var obj = DocumentElementById('postform') && ((DocumentElementById('fwin_newthread') && DocumentElementById('fwin_newthread').style.display == '') || (DocumentElementById('fwin_reply') && DocumentElementById('fwin_reply').style.display == '')) ? DocumentElementById('postform') : (DocumentElementById('fastpostform') ? DocumentElementById('fastpostform') : DocumentElementById('postform'));
	if(!obj) return;
	var data = subject = message = '';
	for(var i = 0; i < obj.elements.length; i++) {
		var el = obj.elements[i];
		if(el.name != '' && (el.tagName == 'TEXTAREA' || el.tagName == 'INPUT' && (el.type == 'text' || el.type == 'checkbox' || el.type == 'radio')) && el.name.substr(0, 6) != 'attach') {
			var elvalue = el.value;
			if(el.name == 'subject') {
				subject = trim(elvalue);
			} else if(el.name == 'message') {
				if(typeof wysiwyg != 'undefined' && wysiwyg == 1) {
					elvalue = html2bbcode(editdoc.body.innerHTML);
				}
				message = trim(elvalue);
			}
			if((el.type == 'checkbox' || el.type == 'radio') && !el.checked) {
				continue;
			}
			if(trim(elvalue)) {
				data += el.name + String.fromCharCode(9) + el.tagName + String.fromCharCode(9) + el.type + String.fromCharCode(9) + elvalue + String.fromCharCode(9, 9);
			}
		}
	}

	if(!subject && !message) {
		return;
	}

	if(BROWSER.ie){
		with(document.documentElement) {
			setAttribute("value", data);
			save('Discuz');
		}
	} else if(window.sessionStorage){
		sessionStorage.setItem('Discuz', data);
        }
}

function switchAdvanceMode(url) {
	var obj = DocumentElementById('postform') && ((DocumentElementById('fwin_newthread') && DocumentElementById('fwin_newthread').style.display == '') || (DocumentElementById('fwin_reply') && DocumentElementById('fwin_reply').style.display == '')) ? DocumentElementById('postform') : DocumentElementById('fastpostform');
	if(obj && obj.message.value != '') {
		saveData();
		url += '&cedit=yes';
	}
	location.href = url;
	return false;
}

function updatestring(str1, str2, clear) {
	str2 = '_' + str2 + '_';
	return clear ? str1.replace(str2, '') : (str1.indexOf(str2) == -1 ? str1 + str2 : str1);
}

function toggle_collapse(objname, noimg, complex, lang) {
	var obj = DocumentElementById(objname);
	if(obj) {
		obj.style.display = obj.style.display == '' ? 'none' : '';
		var collapsed = getcookie('discuz_collapse');
		collapsed = updatestring(collapsed, objname, !obj.style.display);
		setcookie('discuz_collapse', collapsed, (collapsed ? 2592000 : -2592000));
	}
	if(!noimg) {
		var img = DocumentElementById(objname + '_img');
		if(img.tagName != 'IMG') {
			if(img.className.indexOf('_yes') == -1) {
				img.className = img.className.replace(/_no/, '_yes');
				if(lang) {
					img.innerHTML = lang[0];
				}
			} else {
				img.className = img.className.replace(/_yes/, '_no');
				if(lang) {
					img.innerHTML = lang[1];
				}
			}
		} else {
			img.src = img.src.indexOf('_yes.gif') == -1 ? img.src.replace(/_no\.gif/, '_yes\.gif') : img.src.replace(/_yes\.gif/, '_no\.gif');
		}
		img.blur();
	}
	if(complex) {
		var objc = DocumentElementById(objname + '_c');
		if(objc) {
			objc.className = objc.className == 'c_header' ? 'c_header closenode' : 'c_header';
		}
	}

}

function sidebar_collapse(lang) {
	if(lang[0]) {
		toggle_collapse('sidebar', null, null, lang);
		DocumentElementById('wrap').className = DocumentElementById('wrap').className == 'wrap with_side s_clear' ? 'wrap s_clear' : 'wrap with_side s_clear';
	} else {
		var collapsed = getcookie('discuz_collapse');
		collapsed = updatestring(collapsed, 'sidebar', 1);
		setcookie('discuz_collapse', collapsed, (collapsed ? 2592000 : -2592000));
		location.reload();
	}
}

function loadcss(cssname) {
	if(!CSSLOADED[cssname]) {
		css = document.createElement('link');
		css.type = 'text/css';
		css.rel = 'stylesheet';
		css.href = 'forumdata/cache/style_' + STYLEID + '_' + cssname + '.css?' + VERHASH;
		var headNode = document.getElementsByTagName("head")[0];
		headNode.appendChild(css);
		CSSLOADED[cssname] = 1;
	}
}

function showMenu(v) {
	var ctrlid = isUndefined(v['ctrlid']) ? v : v['ctrlid'];
	var showid = isUndefined(v['showid']) ? ctrlid : v['showid'];
	var menuid = isUndefined(v['menuid']) ? showid + '_menu' : v['menuid'];
	var ctrlObj = DocumentElementById(ctrlid);
	var menuObj = DocumentElementById(menuid);
	if(!menuObj) return;
	var mtype = isUndefined(v['mtype']) ? 'menu' : v['mtype'];
	var evt = isUndefined(v['evt']) ? 'mouseover' : v['evt'];
	var pos = isUndefined(v['pos']) ? '43' : v['pos'];
	var layer = isUndefined(v['layer']) ? 1 : v['layer'];
	var duration = isUndefined(v['duration']) ? 2 : v['duration'];
	var timeout = isUndefined(v['timeout']) ? 250 : v['timeout'];
	var maxh = isUndefined(v['maxh']) ? 500 : v['maxh'];
	var cache = isUndefined(v['cache']) ? 1 : v['cache'];
	var drag = isUndefined(v['drag']) ? '' : v['drag'];
	var dragobj = drag && DocumentElementById(drag) ? DocumentElementById(drag) : menuObj;
	var fade = isUndefined(v['fade']) ? 0 : v['fade'];
	var cover = isUndefined(v['cover']) ? 0 : v['cover'];
	var zindex = isUndefined(v['zindex']) ? JSMENU['zIndex']['menu'] : v['zindex'];
	if(typeof JSMENU['active'][layer] == 'undefined') {
		JSMENU['active'][layer] = [];
	}

	if(evt == 'click' && in_array(menuid, JSMENU['active'][layer]) && mtype != 'win') {
		hideMenu(menuid, mtype);
		return;
	}
	if(mtype == 'menu') {
		hideMenu(layer, mtype);
	}

	if(ctrlObj) {
		if(!ctrlObj.initialized) {
			ctrlObj.initialized = true;
			ctrlObj.unselectable = true;

			ctrlObj.outfunc = typeof ctrlObj.onmouseout == 'function' ? ctrlObj.onmouseout : null;
			ctrlObj.onmouseout = function() {
				if(this.outfunc) this.outfunc();
				if(duration < 3 && !JSMENU['timer'][menuid]) JSMENU['timer'][menuid] = setTimeout('hideMenu(\'' + menuid + '\', \'' + mtype + '\')', timeout);
			};

			ctrlObj.overfunc = typeof ctrlObj.onmouseover == 'function' ? ctrlObj.onmouseover : null;
			ctrlObj.onmouseover = function(e) {
				doane(e);
				if(this.overfunc) this.overfunc();
				if(evt == 'click') {
					clearTimeout(JSMENU['timer'][menuid]);
					JSMENU['timer'][menuid] = null;
				} else {
					for(var i in JSMENU['timer']) {
						if(JSMENU['timer'][i]) {
							clearTimeout(JSMENU['timer'][i]);
							JSMENU['timer'][i] = null;
						}
					}
				}
			};
		}
	}

	var dragMenu = function(menuObj, e, op) {
		e = e ? e : window.event;
		if(op == 1) {
			if(in_array(BROWSER.ie ? e.srcElement.tagName : e.target.tagName, ['TEXTAREA', 'INPUT', 'BUTTON', 'SELECT'])) {
				return;
			}
			JSMENU['drag'] = [e.clientX, e.clientY];
			JSMENU['drag'][2] = parseInt(menuObj.style.left);
			JSMENU['drag'][3] = parseInt(menuObj.style.top);
			document.onmousemove = function(e) {try{dragMenu(menuObj, e, 2);}catch(err){}};
			document.onmouseup = function(e) {try{dragMenu(menuObj, e, 3);}catch(err){}};
			doane(e);
		} else if(op == 2 && JSMENU['drag'][0]) {
			var menudragnow = [e.clientX, e.clientY];
			menuObj.style.left = (JSMENU['drag'][2] + menudragnow[0] - JSMENU['drag'][0]) + 'px';
			menuObj.style.top = (JSMENU['drag'][3] + menudragnow[1] - JSMENU['drag'][1]) + 'px';
			doane(e);
		} else if(op == 3) {
			JSMENU['drag'] = [];
			document.onmousemove = null;
			document.onmouseup = null;
		}
	};

	if(!menuObj.initialized) {
		menuObj.initialized = true;
		menuObj.ctrlkey = ctrlid;
		menuObj.mtype = mtype;
		menuObj.layer = layer;
		menuObj.cover = cover;
		if(ctrlObj && ctrlObj.getAttribute('fwin')) {menuObj.scrolly = true;}
		menuObj.style.position = 'absolute';
		menuObj.style.zIndex = zindex + layer;
		menuObj.onclick = function(e) {
			if(!e || BROWSER.ie) {
				window.event.cancelBubble = true;
				return window.event;
			} else {
				e.stopPropagation();
				return e;
			}
		};
		if(duration < 3) {
			if(duration > 1) {
				menuObj.onmouseover = function() {
					clearTimeout(JSMENU['timer'][menuid]);
					JSMENU['timer'][menuid] = null;
				};
			}
			if(duration != 1) {
				menuObj.onmouseout = function() {
					JSMENU['timer'][menuid] = setTimeout('hideMenu(\'' + menuid + '\', \'' + mtype + '\')', timeout);
				};
			}
		}
		if(drag) {
			dragobj.style.cursor = 'move';
			dragobj.onmousedown = function(event) {try{dragMenu(menuObj, event, 1);}catch(e){}};
		}
		if(cover) {
			var coverObj = document.createElement('div');
			coverObj.id = menuid + '_cover';
			coverObj.style.position = 'absolute';
			coverObj.style.zIndex = menuObj.style.zIndex - 1;
			coverObj.style.left = coverObj.style.top = '0px';
			coverObj.style.width = '100%';
			coverObj.style.height = document.body.scrollHeight + 'px';
			coverObj.style.backgroundColor = '#000';
			coverObj.style.filter = 'progid:DXImageTransform.Microsoft.Alpha(opacity=50)';
			coverObj.style.opacity = 0.5;
			DocumentElementById('append_parent').appendChild(coverObj);
		}
	}
	menuObj.style.display = '';
	if(cover) DocumentElementById(menuid + '_cover').style.display = '';
	if(fade) {
		var O = 0;
		var fadeIn = function(O) {
			if(O == 100) {
				clearTimeout(fadeInTimer);
				return;
			}
			menuObj.style.filter = 'progid:DXImageTransform.Microsoft.Alpha(opacity=' + O + ')';
			menuObj.style.opacity = O / 100;
			O += 10;
			var fadeInTimer = setTimeout(function () {
				fadeIn(O);
			}, 50);
		};
		fadeIn(O);
		menuObj.fade = true;
	} else {
		menuObj.style.filter = 'progid:DXImageTransform.Microsoft.Alpha(opacity=100)';
		menuObj.style.opacity = 1;
		menuObj.fade = false;
	}
	setMenuPosition(showid, menuid, pos);
	if(maxh && menuObj.scrollHeight > maxh) {
		menuObj.style.height = maxh + 'px';
		if(BROWSER.opera) {
			menuObj.style.overflow = 'auto';
		} else {
			menuObj.style.overflowY = 'auto';
		}
	}

	if(!duration) {
		setTimeout('hideMenu(\'' + menuid + '\', \'' + mtype + '\')', timeout);
	}

	if(!in_array(menuid, JSMENU['active'][layer])) JSMENU['active'][layer].push(menuid);
	menuObj.cache = cache;
	if(layer > JSMENU['layer']) {
		JSMENU['layer'] = layer;
	}
}

function setMenuPosition(showid, menuid, pos) {
	var showObj = DocumentElementById(showid);
	var menuObj = menuid ? DocumentElementById(menuid) : DocumentElementById(showid + '_menu');
	if(isUndefined(pos)) pos = '43';
	var basePoint = parseInt(pos.substr(0, 1));
	var direction = parseInt(pos.substr(1, 1));
	var sxy = sx = sy = sw = sh = ml = mt = mw = mcw = mh = mch = bpl = bpt = 0;

	if(!menuObj || (basePoint > 0 && !showObj)) return;
	if(showObj) {
		sxy = fetchOffset(showObj);
		sx = sxy['left'];
		sy = sxy['top'];
		sw = showObj.offsetWidth;
		sh = showObj.offsetHeight;
	}
	mw = menuObj.offsetWidth;
	mcw = menuObj.clientWidth;
	mh = menuObj.offsetHeight;
	mch = menuObj.clientHeight;

	switch(basePoint) {
		case 1:
			bpl = sx;
			bpt = sy;
			break;
		case 2:
			bpl = sx + sw;
			bpt = sy;
			break;
		case 3:
			bpl = sx + sw;
			bpt = sy + sh;
			break;
		case 4:
			bpl = sx;
			bpt = sy + sh;
			break;
	}
	switch(direction) {
		case 0:
			menuObj.style.left = (document.body.clientWidth - menuObj.clientWidth) / 2 + 'px';
			mt = (document.documentElement.clientHeight - menuObj.clientHeight) / 2;
			break;
		case 1:
			ml = bpl - mw;
			mt = bpt - mh;
			break;
		case 2:
			ml = bpl;
			mt = bpt - mh;
			break;
		case 3:
			ml = bpl;
			mt = bpt;
			break;
		case 4:
			ml = bpl - mw;
			mt = bpt;
			break;
	}
	if(in_array(direction, [1, 4]) && ml < 0) {
		ml = bpl;
		if(in_array(basePoint, [1, 4])) ml += sw;
	} else if(ml + mw > document.documentElement.scrollLeft + document.body.clientWidth && sx >= mw) {
		ml = bpl - mw;
		if(in_array(basePoint, [2, 3])) ml -= sw;
	}
	if(in_array(direction, [1, 2]) && mt < 0) {
		mt = bpt;
		if(in_array(basePoint, [1, 2])) mt += sh;
	} else if(mt + mh > document.documentElement.scrollTop + document.documentElement.clientHeight && sy >= mh) {
		mt = bpt - mh;
		if(in_array(basePoint, [3, 4])) mt -= sh;
	}
	if(pos == '210') {
		ml += 69 - sw / 2;
		mt -= 5;
		if(showObj.tagName == 'TEXTAREA') {
			ml -= sw / 2;
			mt += sh / 2;
		}
	}
	if(direction == 0 || menuObj.scrolly) {
		if(BROWSER.ie && BROWSER.ie < 7) {
			if(direction == 0) mt += Math.max(document.documentElement.scrollTop, document.body.scrollTop);
		} else {
			if(menuObj.scrolly) mt -= Math.max(document.documentElement.scrollTop, document.body.scrollTop);
			menuObj.style.position = 'fixed';
		}
	}
	if(ml) menuObj.style.left = ml + 'px';
	if(mt) menuObj.style.top = mt + 'px';
	if(direction == 0 && BROWSER.ie && !document.documentElement.clientHeight) {
		menuObj.style.position = 'absolute';
		menuObj.style.top = (document.body.clientHeight - menuObj.clientHeight) / 2 + 'px';
	}
	if(menuObj.style.clip && !BROWSER.opera) {
		menuObj.style.clip = 'rect(auto, auto, auto, auto)';
	}
}

function fetchOffset(obj) {
	var left_offset = 0, top_offset = 0;

	if(obj.getBoundingClientRect){
		var rect = obj.getBoundingClientRect();
		var scrollTop = Math.max(document.documentElement.scrollTop, document.body.scrollTop);
		var scrollLeft = Math.max(document.documentElement.scrollLeft, document.body.scrollLeft);
		if(document.documentElement.dir == 'rtl') {
			scrollLeft = scrollLeft + document.documentElement.clientWidth - document.documentElement.scrollWidth;
		}
		left_offset = rect.left + scrollLeft - document.documentElement.clientLeft;
		top_offset = rect.top + scrollTop - document.documentElement.clientTop;
	}
	if(left_offset <= 0 || top_offset <= 0) {
		left_offset = obj.offsetLeft;
		top_offset = obj.offsetTop;
		while((obj = obj.offsetParent) != null) {
			left_offset += obj.offsetLeft;
			top_offset += obj.offsetTop;
		}
	}
	return { 'left' : left_offset, 'top' : top_offset };
}

function hideMenu(attr, mtype) {
	attr = isUndefined(attr) ? '' : attr;
	mtype = isUndefined(mtype) ? 'menu' : mtype;
	if(attr == '') {
		for(var i = 1; i <= JSMENU['layer']; i++) {
			hideMenu(i, mtype);
		}
		return;
	} else if(typeof attr == 'number') {
		for(var j in JSMENU['active'][attr]) {
			hideMenu(JSMENU['active'][attr][j], mtype);
		}
		return;
	} else if(typeof attr == 'string') {
		var menuObj = DocumentElementById(attr);
		if(!menuObj || (mtype && menuObj.mtype != mtype)) return;
		clearTimeout(JSMENU['timer'][attr]);
		var hide = function() {
			if(menuObj.cache) {
				menuObj.style.display = 'none';
				if(menuObj.cover) DocumentElementById(attr + '_cover').style.display = 'none';
			} else {
				menuObj.parentNode.removeChild(menuObj);
				if(menuObj.cover) DocumentElementById(attr + '_cover').parentNode.removeChild(DocumentElementById(attr + '_cover'));
			}
			var tmp = [];
			for(var k in JSMENU['active'][menuObj.layer]) {
				if(attr != JSMENU['active'][menuObj.layer][k]) tmp.push(JSMENU['active'][menuObj.layer][k]);
			}
			JSMENU['active'][menuObj.layer] = tmp;
		};
		if(menuObj.fade) {
			var O = 100;
			var fadeOut = function(O) {
				if(O == 0) {
					clearTimeout(fadeOutTimer);
					hide();
					return;
				}
				menuObj.style.filter = 'progid:DXImageTransform.Microsoft.Alpha(opacity=' + O + ')';
				menuObj.style.opacity = O / 100;
				O -= 10;
				var fadeOutTimer = setTimeout(function () {
					fadeOut(O);
				}, 50);
			};
			fadeOut(O);
		} else {
			hide();
		}
	}
}

function showPrompt(ctrlid, evt, msg, timeout, negligible) {
	var menuid = ctrlid ? ctrlid + '_pmenu' : 'ntcwin';
	var duration = timeout ? 0 : 3;
	if(!DocumentElementById(menuid)) {
		var div = document.createElement('div');
		div.id = menuid;
		div.className = ctrlid ? 'promptmenu up' : 'ntcwin';
		div.style.display = 'none';
		DocumentElementById('append_parent').appendChild(div);
		if(ctrlid) {
			msg = '<div id="' + ctrlid + '_prompt" class="promptcontent"><ul><li>' + msg + '</li></ul></div>';
		} else {
			msg = negligible ? msg : '<span style="font-style: normal;">' + msg + '</span>';
			msg = '<table cellspacing="0" cellpadding="0" class="popupcredit"><tr><td class="pc_l">&nbsp;</td><td class="pc_c"><div class="pc_inner">' + msg +
				(negligible ? '<a class="pc_btn" href="javascript:;" onclick="display(\'ntcwin\');setcookie(\'discuz_creditnoticedisable\', 1, 31536000);" title="不要再提示我"><img src="' + IMGDIR + '/popupcredit_btn.gif" alt="不要再提示我" /></a>' : '') +
				'</td><td class="pc_r">&nbsp;</td></tr></table>';
		}
		div.innerHTML = msg;
	}
	if(ctrlid) {
		if(DocumentElementById(ctrlid).evt !== false) {
			var prompting = function() {
				showMenu({'mtype':'prompt','ctrlid':ctrlid,'evt':evt,'menuid':menuid,'pos':'210'});
			};
			if(evt == 'click') {
				DocumentElementById(ctrlid).onclick = prompting;
			} else {
				DocumentElementById(ctrlid).onmouseover = prompting;
			}
		}
		showMenu({'mtype':'prompt','ctrlid':ctrlid,'evt':evt,'menuid':menuid,'pos':'210','duration':duration,'timeout':timeout,'fade':1,'zindex':JSMENU['zIndex']['prompt']});
		DocumentElementById(ctrlid).unselectable = false;
	} else {
		showMenu({'mtype':'prompt','pos':'00','menuid':menuid,'duration':duration,'timeout':timeout,'fade':1,'zindex':JSMENU['zIndex']['prompt']});
	}
}

function showCreditPrompt() {
	var notice = getcookie('discuz_creditnotice').split('D');
	if(notice.length < 2 || notice[9] != discuz_uid || getcookie('discuz_creditnoticedisable')) {
		return;
	}
	var creditnames = creditnotice.split(',');
	var creditinfo = [];
	var s = '';
	var e;
	for(var i in creditnames) {
		e = creditnames[i].split('|');
		creditinfo[e[0]] = [e[1], e[2]];
	}
	for(i = 1; i <= 8; i++) {
		if(notice[i] != 0 && creditinfo[i]) {
			s += '<span>' + creditinfo[i][0] + (notice[i] > 0 ? '<em>+' : '<em class="desc">') + notice[i] + '</em>' + creditinfo[i][1] + '</span>';
		}
	}
	s && showPrompt(null, null, s, 2000, 1);
	setcookie('discuz_creditnotice', '', -2592000);
}

function showDialog(msg, mode, t, func, cover) {
	cover = isUndefined(cover) ? (mode == 'info' ? 0 : 1) : cover;
	mode = in_array(mode, ['confirm', 'notice', 'info']) ? mode : 'alert';
	var menuid = 'fwin_dialog';
	var menuObj = DocumentElementById(menuid);

	if(menuObj) hideMenu('fwin_dialog', 'dialog');
	menuObj = document.createElement('div');
	menuObj.style.display = 'none';
	menuObj.className = 'fwinmask';
	menuObj.id = menuid;
	DocumentElementById('append_parent').appendChild(menuObj);
	var s = '<table cellpadding="0" cellspacing="0" class="fwin"><tr><td class="t_l"></td><td class="t_c"></td><td class="t_r"></td></tr><tr><td class="m_l"></td><td class="m_c"><div class="fcontent' + (mode == 'info' ? '' : ' alert_win') + '"><h3 class="float_ctrl"><em>';
	s += t ? t : '提示信息';
	s += '</em><span><a href="javascript:;" class="float_close" onclick="hideMenu(\'' + menuid + '\', \'dialog\')" title="关闭">关闭</a></span></h3>';
	if(mode == 'info') {
		s += msg ? msg : '';
	} else {
		s += '<hr class="shadowline" />';
		s += '<div class="postbox"><div class="' + (mode == 'alert' ? 'alert_error' : 'alert_info') + '"><p>' + msg + '</p></div>';
		s += '<div class="alert_btn"><input type="button" id="fwin_dialog_submit" value="&nbsp;确定&nbsp;" />';
		s += mode == 'confirm' ? '&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<input type="button" onclick="hideMenu(\'' + menuid + '\', \'dialog\')" value="&nbsp;取消&nbsp;" />' : '';
		s += '</div></div>';
	}
	s += '</div></td><td class="m_r"></td></tr><tr><td class="b_l"></td><td class="b_c"></td><td class="b_r"></td></tr></table>';
	menuObj.innerHTML = s;
	if(DocumentElementById('fwin_dialog_submit')) DocumentElementById('fwin_dialog_submit').onclick = function() {
		if(typeof func == 'function') func();
		else eval(func);
		hideMenu(menuid, 'dialog')
	};
	showMenu({'mtype':'dialog','menuid':menuid,'duration':3,'pos':'00','zindex':JSMENU['zIndex']['dialog'],'cache':0,'cover':cover});
}

function showWindow(k, url, mode, cache) {
	mode = isUndefined(mode) ? 'get' : mode;
	cache = isUndefined(cache) ? 1 : cache;
	var menuid = 'fwin_' + k;
	var menuObj = DocumentElementById(menuid);

	if(disallowfloat && disallowfloat.indexOf(k) != -1) {
		if(BROWSER.ie) url += (url.indexOf('?') != -1 ?  '&' : '?') + 'referer=' + escape(location.href);
		location.href = url;
		return;
	}

	var fetchContent = function() {
		if(mode == 'get') {
			menuObj.url = url;
			url += (url.search(/\?/) > 0 ? '&' : '?') + 'infloat=yes&handlekey=' + k;
			ajaxget(url, 'fwin_content_' + k, null, '', '', function() {initMenu();show();});
		} else if(mode == 'post') {
			menuObj.act = DocumentElementById(url).action;
			ajaxpost(url, 'fwin_content_' + k, '', '', '', function() {initMenu();show();});
		}
		showDialog('', 'info', '<img src="' + IMGDIR + '/loading.gif"> 加载中...');
	};
	var initMenu = function() {
		var objs = menuObj.getElementsByTagName('*');
		for(var i = 0; i < objs.length; i++) {
			if(objs[i].id) {
				objs[i].setAttribute('fwin', k);
			}
			if(objs[i].className == 'float_ctrl') {
				if(!objs[i].id) objs[i].id = 'fctrl_' + k;
				drag = objs[i].id;
			}
		}
	};
	var show = function() {
		hideMenu('fwin_dialog', 'dialog');
		showMenu({'mtype':'win','menuid':menuid,'duration':3,'pos':'00','zindex':JSMENU['zIndex']['win'],'drag':typeof drag == 'undefined' ? '' : drag,'cache':cache});
	};

	if(!menuObj) {
		menuObj = document.createElement('div');
		menuObj.id = menuid;
		menuObj.className = 'fwinmask';
		menuObj.style.display = 'none';
		DocumentElementById('append_parent').appendChild(menuObj);
		menuObj.innerHTML = '<table cellpadding="0" cellspacing="0" class="fwin"><tr><td class="t_l"></td><td class="t_c"></td><td class="t_r"></td></tr><tr><td class="m_l"></td><td class="m_c" id="fwin_content_' + k + '">'
			+ '</td><td class="m_r"></td></tr><tr><td class="b_l"></td><td class="b_c"></td><td class="b_r"></td></tr></table>';
		fetchContent();
	} else if((mode == 'get' && url != menuObj.url) || (mode == 'post' && DocumentElementById(url).action != menuObj.act)) {
		fetchContent();
	} else {
		show();
	}
	doane();
}

function hideWindow(k) {
	hideMenu('fwin_' + k, 'win');
	hideMenu();
	hideMenu('', 'prompt');
}

function Ajax(recvType, waitId) {

	for(var stackId = 0; stackId < AJAX['stack'].length && AJAX['stack'][stackId] != 0; stackId++);
	AJAX['stack'][stackId] = 1;

	var aj = new Object();

	aj.loading = '加载中...';
	aj.recvType = recvType ? recvType : 'XML';
	aj.waitId = waitId ? DocumentElementById(waitId) : null;

	aj.resultHandle = null;
	aj.sendString = '';
	aj.targetUrl = '';
	aj.stackId = 0;
	aj.stackId = stackId;

	aj.setLoading = function(loading) {
		if(typeof loading !== 'undefined' && loading !== null) aj.loading = loading;
	};

	aj.setRecvType = function(recvtype) {
		aj.recvType = recvtype;
	};

	aj.setWaitId = function(waitid) {
		aj.waitId = typeof waitid == 'object' ? waitid : DocumentElementById(waitid);
	};

	aj.createXMLHttpRequest = function() {
		var request = false;
		if(window.XMLHttpRequest) {
			request = new XMLHttpRequest();
			if(request.overrideMimeType) {
				request.overrideMimeType('text/xml');
			}
		} else if(window.ActiveXObject) {
			var versions = ['Microsoft.XMLHTTP', 'MSXML.XMLHTTP', 'Microsoft.XMLHTTP', 'Msxml2.XMLHTTP.7.0', 'Msxml2.XMLHTTP.6.0', 'Msxml2.XMLHTTP.5.0', 'Msxml2.XMLHTTP.4.0', 'MSXML2.XMLHTTP.3.0', 'MSXML2.XMLHTTP'];
			for(var i=0; i<versions.length; i++) {
				try {
					request = new ActiveXObject(versions[i]);
					if(request) {
						return request;
					}
				} catch(e) {}
			}
		}
		return request;
	};

	aj.XMLHttpRequest = aj.createXMLHttpRequest();
	aj.showLoading = function() {
		if(aj.waitId && (aj.XMLHttpRequest.readyState != 4 || aj.XMLHttpRequest.status != 200)) {
			aj.waitId.style.display = '';
			aj.waitId.innerHTML = '<span><img src="' + IMGDIR + '/loading.gif"> ' + aj.loading + '</span>';
		}
	};

	aj.processHandle = function() {
		if(aj.XMLHttpRequest.readyState == 4 && aj.XMLHttpRequest.status == 200) {
			for(k in AJAX['url']) {
				if(AJAX['url'][k] == aj.targetUrl) {
					AJAX['url'][k] = null;
				}
			}
			if(aj.waitId) {
				aj.waitId.style.display = 'none';
			}
			if(aj.recvType == 'HTML') {
				aj.resultHandle(aj.XMLHttpRequest.responseText, aj);
			} else if(aj.recvType == 'XML') {
				if(aj.XMLHttpRequest.responseXML.lastChild) {
					aj.resultHandle(aj.XMLHttpRequest.responseXML.lastChild.firstChild.nodeValue, aj);
				} else {
					if(AJAX['debug']) {
						var error = mb_cutstr(aj.XMLHttpRequest.responseText.replace(/\r?\n/g, '\\n').replace(/"/g, '\\\"'), 200);
						aj.resultHandle('<root>ajaxerror<script type="text/javascript" reload="1">showDialog(\'Ajax Error: \\n' + error + '\');</script></root>', aj);
					}
				}
			}
			AJAX['stack'][aj.stackId] = 0;
		}
	};

	aj.get = function(targetUrl, resultHandle) {
		setTimeout(function(){aj.showLoading()}, 250);
		if(in_array(targetUrl, AJAX['url'])) {
			return false;
		} else {
			AJAX['url'].push(targetUrl);
		}
		aj.targetUrl = targetUrl;
		aj.XMLHttpRequest.onreadystatechange = aj.processHandle;
		aj.resultHandle = resultHandle;
		var attackevasive = isUndefined(attackevasive) ? 0 : attackevasive;
		var delay = attackevasive & 1 ? (aj.stackId + 1) * 1001 : 100;
		if(window.XMLHttpRequest) {
			setTimeout(function(){
			aj.XMLHttpRequest.open('GET', aj.targetUrl);
			aj.XMLHttpRequest.send(null);}, delay);
		} else {
			setTimeout(function(){
			aj.XMLHttpRequest.open("GET", targetUrl, true);
			aj.XMLHttpRequest.send();}, delay);
		}
	};
	aj.post = function(targetUrl, sendString, resultHandle) {
		setTimeout(function(){aj.showLoading()}, 250);
		if(in_array(targetUrl, AJAX['url'])) {
			return false;
		} else {
			AJAX['url'].push(targetUrl);
		}
		aj.targetUrl = targetUrl;
		aj.sendString = sendString;
		aj.XMLHttpRequest.onreadystatechange = aj.processHandle;
		aj.resultHandle = resultHandle;
		aj.XMLHttpRequest.open('POST', targetUrl);
		window.alert(targetUrl);
		aj.XMLHttpRequest.setRequestHeader('Content-Type', 'application/x-www-form-urlencoded');
		aj.XMLHttpRequest.send(aj.sendString);
	};
	return aj;
}

function newfunction(func){
	var args = [];
	for(var i=1; i<arguments.length; i++) args.push(arguments[i]);
	return function(event){
		doane(event);
		window[func].apply(window, args);
		return false;
	}
}

function evalscript(s) {
	if(s.indexOf('<script') == -1) return s;
	var p = /<script[^\>]*?>([^\x00]*?)<\/script>/ig;
	var arr = [];
	while(arr = p.exec(s)) {
		var p1 = /<script[^\>]*?src=\"([^\>]*?)\"[^\>]*?(reload=\"1\")?(?:charset=\"([\w\-]+?)\")?><\/script>/i;
		var arr1 = [];
		arr1 = p1.exec(arr[0]);
		if(arr1) {
			appendscript(arr1[1], '', arr1[2], arr1[3]);
		} else {
			p1 = /<script(.*?)>([^\x00]+?)<\/script>/i;
			arr1 = p1.exec(arr[0]);
			appendscript('', arr1[2], arr1[1].indexOf('reload=') != -1);
		}
	}
	return s;
}

function appendscript(src, text, reload, charset) {
	var id = hash(src + text);
	var evalscripts = [];
	if(!reload && in_array(id, evalscripts)) return;
	if(reload && DocumentElementById(id)) {
		DocumentElementById(id).parentNode.removeChild(DocumentElementById(id));
	}

	evalscripts.push(id);
	var scriptNode = document.createElement("script");
	scriptNode.type = "text/javascript";
	scriptNode.id = id;
	scriptNode.charset = charset ? charset : (BROWSER.firefox ? document.characterSet : document.charset);
	try {
		if(src) {
			scriptNode.src = src;
		} else if(text){
			scriptNode.text = text;
		}
		DocumentElementById('append_parent').appendChild(scriptNode);
	} catch(e) {}
}

function stripscript(s) {
	return s.replace(/<script.*?>.*?<\/script>/ig, '');
}

function ajaxupdateevents(obj, tagName) {
	tagName = tagName ? tagName : 'A';
	var objs = obj.getElementsByTagName(tagName);
	for(k in objs) {
		var o = objs[k];
		ajaxupdateevent(o);
	}
}

function ajaxupdateevent(o) {
	if(typeof o == 'object' && o.getAttribute) {
		if(o.getAttribute('ajaxtarget')) {
			if(!o.id) o.id = Math.random();
			var ajaxevent = o.getAttribute('ajaxevent') ? o.getAttribute('ajaxevent') : 'click';
			var ajaxurl = o.getAttribute('ajaxurl') ? o.getAttribute('ajaxurl') : o.href;
			_attachEvent(o, ajaxevent, newfunction('ajaxget', ajaxurl, o.getAttribute('ajaxtarget'), o.getAttribute('ajaxwaitid'), o.getAttribute('ajaxloading'), o.getAttribute('ajaxdisplay')));
			if(o.getAttribute('ajaxfunc')) {
				o.getAttribute('ajaxfunc').match(/(\w+)\((.+?)\)/);
				_attachEvent(o, ajaxevent, newfunction(RegExp.$1, RegExp.$2));
			}
		}
	}
}

/*
 *@ url: 需求请求的 url
 *@ id : 显示的 id
 *@ waitid: 等待的 id，默认为显示的 id，如果 waitid 为空字符串，则不显示 loading...， 如果为 null，则在 showid 区域显示
 *@ linkid: 是哪个链接触发的该 ajax 请求，该对象的属性(如 ajaxdisplay)保存了一些 ajax 请求过程需要的数据。
*/
function ajaxget(url, showid, waitid, loading, display, recall) {
	waitid = typeof waitid == 'undefined' || waitid === null ? showid : waitid;
	var x = new Ajax();
	x.setLoading(loading);
	x.setWaitId(waitid);
	x.display = typeof display == 'undefined' || display == null ? '' : display;
	x.showId = DocumentElementById(showid);
	if(x.showId) x.showId.orgdisplay = typeof x.showId.orgdisplay === 'undefined' ? x.showId.style.display : x.showId.orgdisplay;

	if(url.substr(strlen(url) - 1) == '#') {
		url = url.substr(0, strlen(url) - 1);
		x.autogoto = 1;
	}

	var url = url + '&inajax=1&ajaxtarget=' + showid;
	x.get(url, function(s, x) {
		var evaled = false;
		if(s.indexOf('ajaxerror') != -1) {
			evalscript(s);
			evaled = true;
		}
		if(!evaled && (typeof ajaxerror == 'undefined' || !ajaxerror)) {
			if(x.showId) {
				x.showId.style.display = x.showId.orgdisplay;
				x.showId.style.display = x.display;
				x.showId.orgdisplay = x.showId.style.display;
				ajaxinnerhtml(x.showId, s);
				ajaxupdateevents(x.showId);
				if(x.autogoto) scroll(0, x.showId.offsetTop);
			}
		}

		ajaxerror = null;
		if(typeof recall == 'function') {
			recall();
		} else {
			eval(recall);
		}
		if(!evaled) evalscript(s);
	});
}

function ajaxpost(formid, showid, waitid, showidclass, submitbtn, recall) {
	var waitid = typeof waitid == 'undefined' || waitid === null ? showid : (waitid !== '' ? waitid : '');
	var showidclass = !showidclass ? '' : showidclass;
	var ajaxframeid = 'ajaxframe';
	var ajaxframe = DocumentElementById(ajaxframeid);
	var formtarget = DocumentElementById(formid).target;

	var handleResult = function() {
		var s = '';
		var evaled = false;

		showloading('none');
		try {
			if(BROWSER.ie) {
				s = DocumentElementById(ajaxframeid).contentWindow.document.XMLDocument.text;
			} else {
				s = DocumentElementById(ajaxframeid).contentWindow.document.documentElement.firstChild.nodeValue;
			}
		} catch(e) {
			if(AJAX['debug']) {
				var error = mb_cutstr(DocumentElementById(ajaxframeid).contentWindow.document.body.innerText.replace(/\r?\n/g, '\\n').replace(/"/g, '\\\"'), 200);
				s = '<root>ajaxerror<script type="text/javascript" reload="1">showDialog(\'Ajax Error: \\n' + error + '\');</script></root>';
			}
		}

		if(s != '' && s.indexOf('ajaxerror') != -1) {
			evalscript(s);
			evaled = true;
		}
		if(showidclass) {
			DocumentElementById(showid).className = showidclass;
			if(submitbtn) {
				submitbtn.disabled = false;
			}
		}
		if(!evaled && (typeof ajaxerror == 'undefined' || !ajaxerror)) {
			ajaxinnerhtml(DocumentElementById(showid), s);
		}
		ajaxerror = null;
		if(DocumentElementById(formid)) DocumentElementById(formid).target = formtarget;
		if(typeof recall == 'function') {
			recall();
		} else {
			eval(recall);
		}
		if(!evaled) evalscript(s);
		ajaxframe.loading = 0;
		DocumentElementById('append_parent').removeChild(ajaxframe);
	};
	if(!ajaxframe) {
		if (BROWSER.ie) {
			ajaxframe = document.createElement('<iframe name="' + ajaxframeid + '" id="' + ajaxframeid + '"></iframe>');
		} else {
			ajaxframe = document.createElement('iframe');
			ajaxframe.name = ajaxframeid;
			ajaxframe.id = ajaxframeid;
		}
		ajaxframe.style.display = 'none';
		ajaxframe.loading = 1;
		DocumentElementById('append_parent').appendChild(ajaxframe);
	} else if(ajaxframe.loading) {
		return false;
	}

	_attachEvent(ajaxframe, 'load', handleResult);

	showloading();
	DocumentElementById(formid).target = ajaxframeid;
	DocumentElementById(formid).action += '&inajax=1';
	DocumentElementById(formid).submit();
	return false;
}

function ajaxmenu(ctrlObj, timeout, cache, duration, pos, recall) {
	var ctrlid = ctrlObj.id;
	if(!ctrlid) {
		ctrlid = ctrlObj.id = 'ajaxid_' + Math.random();
	}
	var menuid = ctrlid + '_menu';
	var menu = DocumentElementById(menuid);
	if(isUndefined(timeout)) timeout = 3000;
	if(isUndefined(cache)) cache = 1;
	if(isUndefined(pos)) pos = '43';
	if(isUndefined(duration)) duration = timeout > 0 ? 0 : 3;
	var func = function() {
		showMenu({'ctrlid':ctrlid,'duration':duration,'timeout':timeout,'pos':pos,'cache':cache,'layer':2});
		if(typeof recall == 'function') {
			recall();
		} else {
			eval(recall);
		}
	};

	if(menu) {
		if(menu.style.display == '') {
			hideMenu(menuid);
		} else {
			func();
		}
	} else {
		menu = document.createElement('div');
		menu.id = menuid;
		menu.style.display = 'none';
		menu.className = 'popupmenu_popup';
		menu.innerHTML = '<div class="popupmenu_option" id="' + menuid + '_content"></div>';
		DocumentElementById('append_parent').appendChild(menu);
		ajaxget(!isUndefined(ctrlObj.href) ? ctrlObj.href : ctrlObj.attributes['href'].value, menuid + '_content', 'ajaxwaitid', '', '', func);
	}
}

function hash(string, length) {
	var length = length ? length : 32;
	var start = 0;
	var i = 0;
	var result = '';
	filllen = length - string.length % length;
	for(i = 0; i < filllen; i++){
		string += "0";
	}
	while(start < string.length) {
		result = stringxor(result, string.substr(start, length));
		start += length;
	}
	return result;
}

function stringxor(s1, s2) {
	var s = '';
	var hash = 'abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ';
	var max = Math.max(s1.length, s2.length);
	for(var i=0; i<max; i++) {
		var k = s1.charCodeAt(i) ^ s2.charCodeAt(i);
		s += hash.charAt(k % 52);
	}
	return s;
}

function showloading(display, waiting) {
	var display = display ? display : 'block';
	var waiting = waiting ? waiting : '页面加载中...';
	DocumentElementById('ajaxwaitid').innerHTML = waiting;
	DocumentElementById('ajaxwaitid').style.display = display;
}

function ajaxinnerhtml(showid, s) {
	if(showid.tagName != 'TBODY') {
		showid.innerHTML = s;
	} else {
		while(showid.firstChild) {
			showid.firstChild.parentNode.removeChild(showid.firstChild);
		}
		var div1 = document.createElement('DIV');
		div1.id = showid.id+'_div';
		div1.innerHTML = '<table><tbody id="'+showid.id+'_tbody">'+s+'</tbody></table>';
		DocumentElementById('append_parent').appendChild(div1);
		var trs = div1.getElementsByTagName('TR');
		var l = trs.length;
		for(var i=0; i<l; i++) {
			showid.appendChild(trs[0]);
		}
		var inputs = div1.getElementsByTagName('INPUT');
		var l = inputs.length;
		for(var i=0; i<l; i++) {
			showid.appendChild(inputs[0]);
		}
		div1.parentNode.removeChild(div1);
	}
}

function AC_GetArgs(args, classid, mimeType) {
	var ret = new Object();
	ret.embedAttrs = new Object();
	ret.params = new Object();
	ret.objAttrs = new Object();
	for (var i = 0; i < args.length; i = i + 2){
		var currArg = args[i].toLowerCase();
		switch (currArg){
			case "classid":break;
			case "pluginspage":ret.embedAttrs[args[i]] = 'http://www.macromedia.com/go/getflashplayer';break;
			case "src":args[i+1] += (args[i+1].indexOf('?') != -1 ? '&' : '?') + VERHASH;ret.embedAttrs[args[i]] = args[i+1];ret.params["movie"] = args[i+1];break;
			case "codebase":ret.objAttrs[args[i]] = 'http://download.macromedia.com/pub/shockwave/cabs/flash/swflash.cab#version=9,0,0,0';break;
			case "onafterupdate":case "onbeforeupdate":case "onblur":case "oncellchange":case "onclick":case "ondblclick":case "ondrag":case "ondragend":
			case "ondragenter":case "ondragleave":case "ondragover":case "ondrop":case "onfinish":case "onfocus":case "onhelp":case "onmousedown":
			case "onmouseup":case "onmouseover":case "onmousemove":case "onmouseout":case "onkeypress":case "onkeydown":case "onkeyup":case "onload":
			case "onlosecapture":case "onpropertychange":case "onreadystatechange":case "onrowsdelete":case "onrowenter":case "onrowexit":case "onrowsinserted":case "onstart":
			case "onscroll":case "onbeforeeditfocus":case "onactivate":case "onbeforedeactivate":case "ondeactivate":case "type":
			case "id":ret.objAttrs[args[i]] = args[i+1];break;
			case "width":case "height":case "align":case "vspace": case "hspace":case "class":case "title":case "accesskey":case "name":
			case "tabindex":ret.embedAttrs[args[i]] = ret.objAttrs[args[i]] = args[i+1];break;
			default:ret.embedAttrs[args[i]] = ret.params[args[i]] = args[i+1];
		}
	}
	ret.objAttrs["classid"] = classid;
	if(mimeType) {
		ret.embedAttrs["type"] = mimeType;
	}
	return ret;
}

function AC_DetectFlashVer(reqMajorVer, reqMinorVer, reqRevision) {
	var versionStr = -1;
	if(navigator.plugins != null && navigator.plugins.length > 0 && (navigator.plugins["Shockwave Flash 2.0"] || navigator.plugins["Shockwave Flash"])) {
		var swVer2 = navigator.plugins["Shockwave Flash 2.0"] ? " 2.0" : "";
		var flashDescription = navigator.plugins["Shockwave Flash" + swVer2].description;
		var descArray = flashDescription.split(" ");
		var tempArrayMajor = descArray[2].split(".");
		var versionMajor = tempArrayMajor[0];
		var versionMinor = tempArrayMajor[1];
		var versionRevision = descArray[3];
		if(versionRevision == "") {
			versionRevision = descArray[4];
		}
		if(versionRevision[0] == "d") {
			versionRevision = versionRevision.substring(1);
		} else if(versionRevision[0] == "r") {
			versionRevision = versionRevision.substring(1);
			if(versionRevision.indexOf("d") > 0) {
				versionRevision = versionRevision.substring(0, versionRevision.indexOf("d"));
			}
		}
		versionStr = versionMajor + "." + versionMinor + "." + versionRevision;
	} else if(BROWSER.ie && !BROWSER.opera) {
		try {
			var axo = new ActiveXObject("ShockwaveFlash.ShockwaveFlash.7");
			versionStr = axo.GetVariable("$version");
		} catch (e) {}
	}
	if(versionStr == -1 ) {
		return false;
	} else if(versionStr != 0) {
		if(BROWSER.ie && !BROWSER.opera) {
			tempArray = versionStr.split(" ");
			tempString = tempArray[1];
			versionArray = tempString.split(",");
		} else {
			versionArray = versionStr.split(".");
		}
		var versionMajor = versionArray[0];
		var versionMinor = versionArray[1];
		var versionRevision = versionArray[2];
		return versionMajor > parseFloat(reqMajorVer) || (versionMajor == parseFloat(reqMajorVer)) && (versionMinor > parseFloat(reqMinorVer) || versionMinor == parseFloat(reqMinorVer) && versionRevision >= parseFloat(reqRevision));
	}
}

function AC_FL_RunContent() {
	var str = '';
	if(AC_DetectFlashVer(9,0,124)) {
		var ret = AC_GetArgs(arguments, "clsid:d27cdb6e-ae6d-11cf-96b8-444553540000", "application/x-shockwave-flash");
		if(BROWSER.ie && !BROWSER.opera) {
			str += '<object ';
			for (var i in ret.objAttrs) {
				str += i + '="' + ret.objAttrs[i] + '" ';
			}
			str += '>';
			for (var i in ret.params) {
				str += '<param name="' + i + '" value="' + ret.params[i] + '" /> ';
			}
			str += '</object>';
		} else {
			str += '<embed ';
			for (var i in ret.embedAttrs) {
				str += i + '="' + ret.embedAttrs[i] + '" ';
			}
			str += '></embed>';
		}
	} else {
		str = '此内容需要 Adobe Flash Player 9.0.124 或更高版本<br /><a href="http://www.adobe.com/go/getflashplayer/" target="_blank"><img src="http://www.adobe.com/images/shared/download_buttons/get_flash_player.gif" alt="下载 Flash Player" /></a>';
	}
	return str;
}

function simulateSelect(selectId) {
	var selectObj = DocumentElementById(selectId);
	var defaultopt = defaultv = '';
	var menuObj = document.createElement('div');
	var ul = document.createElement('ul');
	var handleKeyDown = function(e) {
		e = BROWSER.ie ? event : e;
		if(e.keyCode == 40 || e.keyCode == 38) doane(e);
	};

	for(var i = 0; i < selectObj.options.length; i++) {
		var li = document.createElement('li');
		li.innerHTML = selectObj.options[i].innerHTML;
		li.k_id = i;
		li.k_value = selectObj.options[i].value;
		if(selectObj.options[i].selected) {
			defaultopt = selectObj.options[i].innerHTML;
			defaultv = selectObj.options[i].value;
			li.className = 'current';
			selectObj.setAttribute('selecti', i);
		}
		li.onclick = function() {
			if(DocumentElementById(selectId + '_ctrl').innerHTML != this.innerHTML) {
				var lis = menuObj.getElementsByTagName('li');
				lis[DocumentElementById(selectId).getAttribute('selecti')].className = '';
				this.className = 'current';
				DocumentElementById(selectId + '_ctrl').innerHTML = this.innerHTML;
				DocumentElementById(selectId).setAttribute('selecti', this.k_id);
				DocumentElementById(selectId).options.length = 0;
				DocumentElementById(selectId).options[0] = new Option('', this.k_value);
				eval(selectObj.getAttribute('change'));
			}
			hideMenu(menuObj.id);
			return false;
		};
		ul.appendChild(li);
	}

	selectObj.options.length = 0;
	selectObj.options[0]= new Option('', defaultv);
	selectObj.style.display = 'none';
	selectObj.outerHTML += '<a href="javascript:;" hidefocus="true" id="' + selectId + '_ctrl" tabindex="1">' + defaultopt + '</a>';

	menuObj.id = selectId + '_ctrl_menu';
	menuObj.className = 'select_menu';
	menuObj.style.display = 'none';
	menuObj.appendChild(ul);
	DocumentElementById('append_parent').appendChild(menuObj);

	DocumentElementById(selectId + '_ctrl').onclick = function(e) {
		DocumentElementById(selectId + '_ctrl_menu').style.width = (BROWSER.ie ? Math.max(DocumentElementById(selectId + '_ctrl').clientWidth, parseInt(DocumentElementById(selectId + '_ctrl').currentStyle.width)) : DocumentElementById(selectId + '_ctrl').clientWidth) + 'px';
		showMenu({'ctrlid':(selectId == 'loginfield' ? 'account' : selectId + '_ctrl'),'menuid':selectId + '_ctrl_menu','evt':'click','pos':'13'});
		doane(e);
	};
	DocumentElementById(selectId + '_ctrl').onfocus = menuObj.onfocus = function() {
		_attachEvent(document.body, 'keydown', handleKeyDown);
	};
	DocumentElementById(selectId + '_ctrl').onblur = menuObj.onblur = function() {
		_detachEvent(document.body, 'keydown', handleKeyDown);
	};
	DocumentElementById(selectId + '_ctrl').onkeyup = function(e) {
		e = e ? e : window.event;
		value = e.keyCode;
		if(value == 40 || value == 38) {
			if(menuObj.style.display == 'none') {
				DocumentElementById(selectId + '_ctrl').click();
			} else {
				lis = menuObj.getElementsByTagName('li');
				selecti = selectObj.getAttribute('selecti');
				lis[selecti].className = '';
				if(value == 40) {
					selecti = parseInt(selecti) + 1;
				} else if(value == 38) {
					selecti = parseInt(selecti) - 1;
				}
				if(selecti < 0) {
					selecti = lis.length - 1
				} else if(selecti > lis.length - 1) {
					selecti = 0;
				}
				lis[selecti].className = 'current';
				selectObj.setAttribute('selecti', selecti);
				lis[selecti].parentNode.scrollTop = lis[selecti].offsetTop;
			}
		} else if(value == 13) {
			var lis = menuObj.getElementsByTagName('li');
			lis[selectObj.getAttribute('selecti')].click();
		} else if(value == 27) {
			hideMenu(menuObj.id);
		}
	};
}

function detectCapsLock(e, obj) {
	var valueCapsLock = e.keyCode ? e.keyCode : e.which;
	var valueShift = e.shiftKey ? e.shiftKey : (valueCapsLock == 16 ? true : false);
	this.clearDetect = function () {
		obj.className = 'txt';
	};

	obj.className = (valueCapsLock >= 65 && valueCapsLock <= 90 && !valueShift || valueCapsLock >= 97 && valueCapsLock <= 122 && valueShift) ? 'capslock txt' : 'txt';

	if(BROWSER.ie) {
		event.srcElement.onblur = this.clearDetect;
	} else {
		e.target.onblur = this.clearDetect;
	}
}

function switchTab(prefix, current, total) {
	for(i = 1; i <= total;i++) {
		DocumentElementById(prefix + '_' + i).className = '';
		DocumentElementById(prefix + '_c_' + i).style.display = 'none';
	}
	DocumentElementById(prefix + '_' + current).className = 'current';
	DocumentElementById(prefix + '_c_' + current).style.display = '';
}

function keyPageScroll(e, prev, next, url, page) {
	e = e ? e : window.event;
	var tagname = BROWSER.ie ? e.srcElement.tagName : e.target.tagName;
	if(tagname == 'INPUT' || tagname == 'TEXTAREA') return;
	actualCode = e.keyCode ? e.keyCode : e.charCode;
	if(next && actualCode == 39) {
		window.location = url + '&page=' + (page + 1);
	}
	if(prev && actualCode == 37) {
		window.location = url + '&page=' + (page - 1);
	}
}

function showselect(obj, inpid, t, rettype) {
	if(!obj.id) {
		var t = !t ? 0 : t;
		var rettype = !rettype ? 0 : rettype;
		obj.id = 'calendarexp_' + Math.random();
		div = document.createElement('div');
		div.id = obj.id + '_menu';
		div.style.display = 'none';
		div.className = 'showselect_menu';
		DocumentElementById('append_parent').appendChild(div);
		s = '';
		if(!t) {
			s += showselect_row(inpid, '一天', 1, 0, rettype);
			s += showselect_row(inpid, '一周', 7, 0, rettype);
			s += showselect_row(inpid, '一个月', 30, 0, rettype);
			s += showselect_row(inpid, '三个月', 90, 0, rettype);
			s += showselect_row(inpid, '自定义', -2);
		} else {
			if(DocumentElementById(t)) {
				var lis = DocumentElementById(t).getElementsByTagName('LI');
				for(i = 0;i < lis.length;i++) {
					s += '<a href="javascript:;" onclick="DocumentElementById(\'' + inpid + '\').value = this.innerHTML">' + lis[i].innerHTML + '</a><br />';
				}
				s += showselect_row(inpid, '自定义', -1);
			} else {
				s += '<a href="javascript:;" onclick="DocumentElementById(\'' + inpid + '\').value = \'0\'">永久</a><br />';
				s += showselect_row(inpid, '7 天', 7, 1, rettype);
				s += showselect_row(inpid, '14 天', 14, 1, rettype);
				s += showselect_row(inpid, '一个月', 30, 1, rettype);
				s += showselect_row(inpid, '三个月', 90, 1, rettype);
				s += showselect_row(inpid, '半年', 182, 1, rettype);
				s += showselect_row(inpid, '一年', 365, 1, rettype);
				s += showselect_row(inpid, '自定义', -1);
			}
		}
		DocumentElementById(div.id).innerHTML = s;
	}
	showMenu({'ctrlid':obj.id,'evt':'click'});
	if(BROWSER.ie && BROWSER.ie < 7) {
		doane(event);
	}
}

function showselect_row(inpid, s, v, notime, rettype) {
	if(v >= 0) {
		if(!rettype) {
			var notime = !notime ? 0 : 1;
			t = today.getTime();
			t += 86400000 * v;
			d = new Date();
			d.setTime(t);
			return '<a href="javascript:;" onclick="DocumentElementById(\'' + inpid + '\').value = \'' + d.getFullYear() + '-' + (d.getMonth() + 1) + '-' + d.getDate() + (!notime ? ' ' + d.getHours() + ':' + d.getMinutes() : '') + '\'">' + s + '</a><br />';
		} else {
			return '<a href="javascript:;" onclick="DocumentElementById(\'' + inpid + '\').value = \'' + v + '\'">' + s + '</a><br />';
		}
	} else if(v == -1) {
		return '<a href="javascript:;" onclick="DocumentElementById(\'' + inpid + '\').focus()">' + s + '</a><br />';
	} else if(v == -2) {
		return '<a href="javascript:;" onclick="DocumentElementById(\'' + inpid + '\').onclick()">' + s + '</a><br />';
	}
}

function showColorBox(ctrlid, layer, k) {
	if(!DocumentElementById(ctrlid + '_menu')) {
		var menu = document.createElement('div');
		menu.id = ctrlid + '_menu';
		menu.className = 'popupmenu_popup colorbox';
		menu.unselectable = true;
		menu.style.display = 'none';
		var coloroptions = ['Black', 'Sienna', 'DarkOliveGreen', 'DarkGreen', 'DarkSlateBlue', 'Navy', 'Indigo', 'DarkSlateGray', 'DarkRed', 'DarkOrange', 'Olive', 'Green', 'Teal', 'Blue', 'SlateGray', 'DimGray', 'Red', 'SandyBrown', 'YellowGreen','SeaGreen', 'MediumTurquoise','RoyalBlue', 'Purple', 'Gray', 'Magenta', 'Orange', 'Yellow', 'Lime', 'Cyan', 'DeepSkyBlue', 'DarkOrchid', 'Silver', 'Pink', 'Wheat', 'LemonChiffon', 'PaleGreen', 'PaleTurquoise', 'LightBlue', 'Plum', 'White'];
		var str = '';
		for(var i = 0; i < 40; i++) {
			str += '<input type="button" style="background-color: ' + coloroptions[i] + '" onclick="'
			+ (typeof wysiwyg == 'undefined' ? 'seditor_insertunit(\'' + k + '\', \'[color=' + coloroptions[i] + ']\', \'[/color]\')' : (ctrlid == editorid + '_cmd_table_param_4' ? 'DocumentElementById(\'' + ctrlid + '\').value=\'' + coloroptions[i] + '\';hideMenu(2)' : 'discuzcode(\'forecolor\', \'' + coloroptions[i] + '\')'))
			+ '" title="' + coloroptions[i] + '" />' + (i < 39 && (i + 1) % 8 == 0 ? '<br />' : '');
		}
		menu.innerHTML = str;
		DocumentElementById('append_parent').appendChild(menu);
	}
	showMenu({'ctrlid':ctrlid,'evt':'click','layer':layer});
}

function announcement() {
	var ann = new Object();
	ann.anndelay = 3000;ann.annst = 0;ann.annstop = 0;ann.annrowcount = 0;ann.anncount = 0;ann.annlis = DocumentElementById('annbody').getElementsByTagName("LI");ann.annrows = new Array();
	ann.announcementScroll = function () {
		if(this.annstop) { this.annst = setTimeout(function () { ann.announcementScroll(); }, this.anndelay);return; }
		if(!this.annst) {
			var lasttop = -1;
			for(i = 0;i < this.annlis.length;i++) {
				if(lasttop != this.annlis[i].offsetTop) {
					if(lasttop == -1) lasttop = 0;
					this.annrows[this.annrowcount] = this.annlis[i].offsetTop - lasttop;this.annrowcount++;
				}
				lasttop = this.annlis[i].offsetTop;
			}
			if(this.annrows.length == 1) {
				DocumentElementById('ann').onmouseover = DocumentElementById('ann').onmouseout = null;
			} else {
				this.annrows[this.annrowcount] = this.annrows[1];
				DocumentElementById('annbodylis').innerHTML += DocumentElementById('annbodylis').innerHTML;
				this.annst = setTimeout(function () { ann.announcementScroll(); }, this.anndelay);
				DocumentElementById('ann').onmouseover = function () { ann.annstop = 1; };
				DocumentElementById('ann').onmouseout = function () { ann.annstop = 0; };
			}
			this.annrowcount = 1;
			return;
		}
		if(this.annrowcount >= this.annrows.length) {
			DocumentElementById('annbody').scrollTop = 0;
			this.annrowcount = 1;
			this.annst = setTimeout(function () { ann.announcementScroll(); }, this.anndelay);
		} else {
			this.anncount = 0;
			this.announcementScrollnext(this.annrows[this.annrowcount]);
		}
	};
	ann.announcementScrollnext = function (time) {
		DocumentElementById('annbody').scrollTop++;
		this.anncount++;
		if(this.anncount != time) {
			this.annst = setTimeout(function () { ann.announcementScrollnext(time); }, 10);
		} else {
			this.annrowcount++;
			this.annst = setTimeout(function () { ann.announcementScroll(); }, this.anndelay);
		}
	};
	ann.announcementScroll();
}

function removeindexheats() {
	return confirm('您确认要把此主题从热点主题中移除么？');
}

//function smilies_show(id, smcols, seditorkey) {
//	if(seditorkey && !DocumentElementById(seditorkey + 'smilies_menu')) {
//		var div = document.createElement("div");
//		div.id = seditorkey + 'smilies_menu';
//		div.style.display = 'none';
//		div.className = 'smilieslist';
//		DocumentElementById('append_parent').appendChild(div);
//		var div = document.createElement("div");
//		div.id = id;
//		div.style.overflow = 'hidden';
//		DocumentElementById(seditorkey + 'smilies_menu').appendChild(div);
//	}
//	if(typeof smilies_type == 'undefined') {
//		var scriptNode = document.createElement("script");
//		scriptNode.type = "text/javascript";
//		scriptNode.charset = charset ? charset : (BROWSER.firefox ? document.characterSet : document.charset);
//		scriptNode.src = 'forumdata/cache/smilies_var.js?' + VERHASH;
//		DocumentElementById('append_parent').appendChild(scriptNode);
//		if(BROWSER.ie) {
//			scriptNode.onreadystatechange = function() {
//				smilies_onload(id, smcols, seditorkey);
//			};
//		} else {
//			scriptNode.onload = function() {
//				smilies_onload(id, smcols, seditorkey);
//			};
//		}
//	} else {
//		smilies_onload(id, smcols, seditorkey);
//	}
//}

function smilies_onload(id, smcols, seditorkey) {
	seditorkey = !seditorkey ? '' : seditorkey;
	smile = getcookie('smile').split('D');
	if(typeof smilies_type == 'object') {
		if(smile[0] && smilies_array[smile[0]]) {
			CURRENTSTYPE = smile[0];
		} else {
			for(i in smilies_array) {
				CURRENTSTYPE = i; break;
			}
		}
		smiliestype = '<div class="smiliesgroup"><ul>';
		for(i in smilies_type) {
			if(smilies_type[i][0]) {
				smiliestype += '<li><a href="javascript:;" hidefocus="true" ' + (CURRENTSTYPE == i ? 'class="current"' : '') + ' id="'+seditorkey+'stype_'+i+'" onclick="smilies_switch(\'' + id + '\', \'' + smcols + '\', '+i+', 1, \'' + seditorkey + '\');if(CURRENTSTYPE) {DocumentElementById(\''+seditorkey+'stype_\'+CURRENTSTYPE).className=\'\';}this.className=\'current\';CURRENTSTYPE='+i+';doane(event);">'+smilies_type[i][0]+'</a></li>';
			}
		}
		smiliestype += '</ul></div>';
		DocumentElementById(id).innerHTML = smiliestype + '<div id="' + id + '_data"></div><div class="smilieslist_page" id="' + id + '_page"></div>';
		smilies_switch(id, smcols, CURRENTSTYPE, smile[1], seditorkey);
	}
}

function smilies_switch(id, smcols, type, page, seditorkey) {
	page = page ? page : 1;
	if(!smilies_array[type] || !smilies_array[type][page]) return;
	setcookie('smile', type + 'D' + page, 31536000);
	smiliesdata = '<table id="' + id + '_table" cellpadding="0" cellspacing="0"><tr>';
	j = k = 0;
	img = [];
	for(i in smilies_array[type][page]) {
		if(j >= smcols) {
			smiliesdata += '<tr>';
			j = 0;
		}
		s = smilies_array[type][page][i];
		smilieimg = 'images/smilies/' + smilies_type[type][1] + '/' + s[2];
		img[k] = new Image();
		img[k].src = smilieimg;
		smiliesdata += s && s[0] ? '<td onmouseover="smilies_preview(\'' + seditorkey + '\', \'' + id + '\', this, ' + s[5] + ')" onclick="' + (typeof wysiwyg != 'undefined' ? 'insertSmiley(' + s[0] + ')': 'seditor_insertunit(\'' + seditorkey + '\', \'' + s[1].replace(/'/, '\\\'') + '\')') +
			'" id="' + seditorkey + 'smilie_' + s[0] + '_td"><img id="smilie_' + s[0] + '" width="' + s[3] +'" height="' + s[4] +'" src="' + smilieimg + '" alt="' + s[1] + '" />' : '<td>';
		j++;k++;
	}
	smiliesdata += '</table>';
	smiliespage = '';
	if(smilies_array[type].length > 2) {
		prevpage = ((prevpage = parseInt(page) - 1) < 1) ? smilies_array[type].length - 1 : prevpage;
		nextpage = ((nextpage = parseInt(page) + 1) == smilies_array[type].length) ? 1 : nextpage;
		smiliespage = '<div class="pags_act"><a href="javascript:;" onclick="smilies_switch(\'' + id + '\', \'' + smcols + '\', ' + type + ', ' + prevpage + ', \'' + seditorkey + '\');doane(event);">上页</a>' +
			'<a href="javascript:;" onclick="smilies_switch(\'' + id + '\', \'' + smcols + '\', ' + type + ', ' + nextpage + ', \'' + seditorkey + '\');doane(event);">下页</a></div>' +
			page + '/' + (smilies_array[type].length - 1);
	}
	DocumentElementById(id + '_data').innerHTML = smiliesdata;
	DocumentElementById(id + '_page').innerHTML = smiliespage;
}

function smilies_preview(seditorkey, id, obj, w) {
	var menu = DocumentElementById('smilies_preview');
	if(!menu) {
		menu = document.createElement('div');
		menu.id = 'smilies_preview';
		menu.className = 'smilies_preview';
		menu.style.display = 'none';
		DocumentElementById('append_parent').appendChild(menu);
	}
	menu.innerHTML = '<img width="' + w + '" src="' + obj.childNodes[0].src + '" />';
	mpos = fetchOffset(DocumentElementById(id + '_data'));
	spos = fetchOffset(obj);
	pos = spos['left'] >= mpos['left'] + DocumentElementById(id + '_data').offsetWidth / 2 ? '13' : '24';
	showMenu({'ctrlid':obj.id,'showid':id + '_data','menuid':menu.id,'pos':pos,'layer':3});
}

function seditor_ctlent(event, script) {
	if(event.ctrlKey && event.keyCode == 13 || event.altKey && event.keyCode == 83) {
		eval(script);
	}
}

function seditor_insertunit(key, text, textend, moveend) {
	DocumentElementById(key + 'message').focus();
	textend = isUndefined(textend) ? '' : textend;
	moveend = isUndefined(textend) ? 0 : moveend;
	startlen = strlen(text);
	endlen = strlen(textend);
	if(!isUndefined(DocumentElementById(key + 'message').selectionStart)) {
		var opn = DocumentElementById(key + 'message').selectionStart + 0;
		if(textend != '') {
			text = text + DocumentElementById(key + 'message').value.substring(DocumentElementById(key + 'message').selectionStart, DocumentElementById(key + 'message').selectionEnd) + textend;
		}
		DocumentElementById(key + 'message').value = DocumentElementById(key + 'message').value.substr(0, DocumentElementById(key + 'message').selectionStart) + text + DocumentElementById(key + 'message').value.substr(DocumentElementById(key + 'message').selectionEnd);
		if(!moveend) {
			DocumentElementById(key + 'message').selectionStart = opn + strlen(text) - endlen;
			DocumentElementById(key + 'message').selectionEnd = opn + strlen(text) - endlen;
		}
	} else if(document.selection && document.selection.createRange) {
		var sel = document.selection.createRange();
		if(textend != '') {
			text = text + sel.text + textend;
		}
		sel.text = text.replace(/\r?\n/g, '\r\n');
		if(!moveend) {
			sel.moveStart('character', -endlen);
			sel.moveEnd('character', -endlen);
		}
		sel.select();
	} else {
		DocumentElementById(key + 'message').value += text;
	}
	hideMenu(2);
	if(BROWSER.ie) {
		doane();
	}
}

function parseurl(str, mode, parsecode) {
	if(isUndefined(parsecode)) parsecode = true;
	if(parsecode) str= str.replace(/\s*\[code\]([\s\S]+?)\[\/code\]\s*/ig, function($1, $2) {return codetag($2);});
	str = str.replace(/([^>=\]"'\/]|^)((((https?|ftp):\/\/)|www\.)([\w\-]+\.)*[\w\-\u4e00-\u9fa5]+\.([\.a-zA-Z0-9]+|\u4E2D\u56FD|\u7F51\u7EDC|\u516C\u53F8)((\?|\/|:)+[\w\.\/=\?%\-&~`@':+!]*)+\.(jpg|gif|png|bmp))/ig, mode == 'html' ? '$1<img src="$2" border="0">' : '$1[img]$2[/img]');
	str = str.replace(/([^>=\]"'\/@]|^)((((https?|ftp|gopher|news|telnet|rtsp|mms|callto|bctp|ed2k|thunder|synacast):\/\/))([\w\-]+\.)*[:\.@\-\w\u4e00-\u9fa5]+\.([\.a-zA-Z0-9]+|\u4E2D\u56FD|\u7F51\u7EDC|\u516C\u53F8)((\?|\/|:)+[\w\.\/=\?%\-&~`@':+!#]*)*)/ig, mode == 'html' ? '$1<a href="$2" target="_blank">$2</a>' : '$1[url]$2[/url]');
	str = str.replace(/([^\w>=\]"'\/@]|^)((www\.)([\w\-]+\.)*[:\.@\-\w\u4e00-\u9fa5]+\.([\.a-zA-Z0-9]+|\u4E2D\u56FD|\u7F51\u7EDC|\u516C\u53F8)((\?|\/|:)+[\w\.\/=\?%\-&~`@':+!#]*)*)/ig, mode == 'html' ? '$1<a href="$2" target="_blank">$2</a>' : '$1[url]$2[/url]');
	str = str.replace(/([^\w->=\]:"'\.\/]|^)(([\-\.\w]+@[\.\-\w]+(\.\w+)+))/ig, mode == 'html' ? '$1<a href="mailto:$2">$2</a>' : '$1[email]$2[/email]');
	if(parsecode) {
		for(var i = 0; i <= DISCUZCODE['num']; i++) {
			str = str.replace("[\tDISCUZ_CODE_" + i + "\t]", DISCUZCODE['html'][i]);
		}
	}
	return str;
}

function codetag(text) {
	DISCUZCODE['num']++;
	if(typeof wysiwyg != 'undefined' && wysiwyg) text = text.replace(/<br[^\>]*>/ig, '\n').replace(/<(\/|)[A-Za-z].*?>/ig, '');
	DISCUZCODE['html'][DISCUZCODE['num']] = '[code]' + text + '[/code]';
	return '[\tDISCUZ_CODE_' + DISCUZCODE['num'] + '\t]';
}

function pmchecknew() {
	ajaxget('pm.php?checknewpm=' + Math.random(), 'myprompt_check', 'ajaxwaitid');
}

function showimmestatus(imme) {
	var lang = {'Online':'MSN 在线','Busy':'MSN 忙碌','Away':'MSN 离开','Offline':'MSN 脱机'};
	DocumentElementById('imme_status_' + imme.id.substr(0, imme.id.indexOf('@'))).innerHTML = lang[imme.statusText];
}

if(typeof IN_ADMINCP == 'undefined') {
	if(discuz_uid && !getcookie('checkpm')) {
		_attachEvent(window, 'load', pmchecknew, document);
	}
	if(creditnotice != '' && getcookie('discuz_creditnotice') && !getcookie('discuz_creditnoticedisable')) {
		_attachEvent(window, 'load', showCreditPrompt, document);
	}
}

if(BROWSER.ie) {
	document.documentElement.addBehavior("#default#userdata");
}
/*
	[Discuz!] (C)2001-2009 Comsenz Inc.
	This is NOT a freeware, use is subject to license terms

	$Id: post.js 20516 2009-09-30 01:23:33Z monkey $
*/

var postSubmited = false;
var AID = 1;
var UPLOADSTATUS = -1;
var UPLOADFAILED = UPLOADCOMPLETE = AUTOPOST =  0;
var CURRENTATTACH = '0';
var FAILEDATTACHS = '';
var UPLOADWINRECALL = null;
var STATUSMSG = {'-1' : '内部服务器错误', '0' : '上传成功', '1' : '不支持此类扩展名', '2' : '附件大小为 0', '3' : '附件大小超限', '4' : '不支持此类扩展名', '5' : '附件大小超限', '6' : '附件总大小超限', '7' : '图片附件不合法', '8' : '附件文件无法保存', '9' : '没有合法的文件被上传', '10' : '非法操作'};

function checkFocus() {
	var obj = wysiwyg ? editwin : textobj;
	if(!obj.hasfocus) {
		obj.focus();
	}
}

function ctlent(event) {
	if(postSubmited == false && (event.ctrlKey && event.keyCode == 13) || (event.altKey && event.keyCode == 83) && DocumentElementById('postsubmit')) {
		if(in_array(DocumentElementById('postsubmit').name, ['topicsubmit', 'replysubmit', 'editsubmit']) && !validate(DocumentElementById('postform'))) {
			doane(event);
			return;
		}
		postSubmited = true;
		DocumentElementById('postsubmit').disabled = true;
		DocumentElementById('postform').submit();
	}
	if(event.keyCode == 9) {
		doane(event);
	}
}

function checklength(theform) {
	var message = wysiwyg ? html2bbcode(getEditorContents()) : (!theform.parseurloff.checked ? parseurl(theform.message.value) : theform.message.value);
	showDialog('当前长度: ' + mb_strlen(message) + ' 字节，' + (postmaxchars != 0 ? '系统限制: ' + postminchars + ' 到 ' + postmaxchars + ' 字节。' : ''), 'notice', '字数检查');
}

if(!tradepost) {
	var tradepost = 0;
}

function validate(theform) {
	var message = trim(wysiwyg ? html2bbcode(getEditorContents()) : (!theform.parseurloff.checked ? parseurl(theform.message.value) : theform.message.value));
	if((DocumentElementById('postsubmit').name != 'replysubmit' && !(DocumentElementById('postsubmit').name == 'editsubmit' && !isfirstpost) && theform.subject.value == "") || !sortid && !special && message == "") {
		showDialog('请完成标题或内容栏。');
		return false;
	} else if(mb_strlen(theform.subject.value) > 80) {
		showDialog('您的标题超过 80 个字符的限制。');
		return false;
	}
	if(tradepost) {
		if(theform.item_name.value == '') {
			showDialog('对不起，请输入商品名称。');
			return false;
		} else if(theform.item_price.value == '') {
			showDialog('对不起，请输入商品现价。');
			return false;
		} else if(!parseInt(theform.item_price.value)) {
			showDialog('对不起，商品现价必须为有效数字。');
			return false;
		} else if(theform.item_costprice.value != '' && !parseInt(theform.item_costprice.value)) {
			showDialog('对不起，商品原价必须为有效数字。');
			return false;
		} else if(theform.item_number.value != '0' && !parseInt(theform.item_number.value)) {
			showDialog('对不起，商品数量必须为数字。');
			theform.item_number.focus();
			return false;
		}
	}
	if(in_array(DocumentElementById('postsubmit').name, ['topicsubmit', 'editsubmit'])) {
		if(theform.typeid && (theform.typeid.options && theform.typeid.options[theform.typeid.selectedIndex].value == 0) && typerequired) {
			showDialog('请选择主题对应的分类。');
			return false;
		}
		if(special == 3 && isfirstpost) {
			if(theform.rewardprice.value == "") {
				showDialog('对不起，请输入悬赏积分。');
				return false;
			}
		} else if(special == 4 && isfirstpost) {
			if(theform.activityclass.value == "") {
				showDialog('对不起，请输入活动所属类别。');
				return false;
			} else if(DocumentElementById('starttimefrom_0').value == "" && DocumentElementById('starttimefrom_1').value == "") {
				showDialog('对不起，请输入活动开始时间。');
				return false;
			} else if(theform.activityplace.value == "") {
				showDialog('对不起，请输入活动地点。');
				return false;
			}
		}
	}

	if(!disablepostctrl && !sortid && !special && ((postminchars != 0 && mb_strlen(message) < postminchars) || (postmaxchars != 0 && mb_strlen(message) > postmaxchars))) {
		showDialog('您的帖子长度不符合要求。\n\n当前长度: ' + mb_strlen(message) + ' 字节\n系统限制: ' + postminchars + ' 到 ' + postmaxchars + ' 字节');
		return false;
	}
	if(UPLOADSTATUS == 0) {
		if(!confirm('您有等待上传的附件，确认不上传这些附件吗？')) {
			return false;
		}
	} else if(UPLOADSTATUS == 1) {
		showDialog('您有正在上传的附件，请稍候，上传完成后帖子将会自动发表...', 'notice');
		AUTOPOST = 1;
		return false;
	}
	if(DocumentElementById(editorid + '_attachlist')) {
		DocumentElementById('postbox').appendChild(DocumentElementById(editorid + '_attachlist'));
		DocumentElementById(editorid + '_attachlist').style.display = 'none';
	}
	if(DocumentElementById(editorid + '_imgattachlist')) {
		DocumentElementById('postbox').appendChild(DocumentElementById(editorid + '_imgattachlist'));
		DocumentElementById(editorid + '_imgattachlist').style.display = 'none';
	}
	hideMenu();
	theform.message.value = message;
	if(DocumentElementById('postsubmit').name == 'editsubmit') {
		return true;
	} else if(in_array(DocumentElementById('postsubmit').name, ['topicsubmit', 'replysubmit'])) {
		seccheck(theform, seccodecheck, secqaacheck);
		return false;
	}
}

function seccheck(theform, seccodecheck, secqaacheck) {
	if(seccodecheck || secqaacheck) {
		var url = 'ajax.php?inajax=1&action=';
		if(seccodecheck) {
			var x = new Ajax();
			x.get(url + 'checkseccode&seccodeverify=' + (BROWSER.ie && document.charset == 'utf-8' ? encodeURIComponent(DocumentElementById('seccodeverify').value) : DocumentElementById('seccodeverify').value), function(s) {
				if(s.substr(0, 7) != 'succeed') {
					showDialog(s);
					DocumentElementById('seccodeverify').focus();
				} else if(secqaacheck) {
					checksecqaa(url, theform);
				} else {
					postsubmit(theform);
				}
			});
		} else if(secqaacheck) {
			checksecqaa(url, theform);
		}
	} else {
		postsubmit(theform);
	}
}

function checksecqaa(url, theform) {
	var x = new Ajax();
	var secanswer = DocumentElementById('secanswer').value;
	secanswer = BROWSER.ie && document.charset == 'utf-8' ? encodeURIComponent(secanswer) : secanswer;
	x.get(url + 'checksecanswer&secanswer=' + secanswer, function(s) {
		if(s.substr(0, 7) != 'succeed') {
			showDialog(s);
			DocumentElementById('secanswer').focus();
		} else {
			postsubmit(theform);
		}
	});
}

function postsubmit(theform) {
	theform.replysubmit ? theform.replysubmit.disabled = true : (theform.editsubmit ? theform.editsubmit.disabled = true : theform.topicsubmit.disabled = true);
	theform.submit();
}

function loadData(quiet) {
	var data = '';
	if(BROWSER.ie){
		with(document.documentElement) {
            		load('Discuz');
			data = getAttribute("value");
        	}
	} else if(window.sessionStorage){
		data = sessionStorage.getItem('Discuz');
        }

	if(in_array((data = trim(data)), ['', 'null', 'false', null, false])) {
		if(!quiet) {
			showDialog('没有可以恢复的数据！');
		}
		return;
	}

	if(!quiet && !confirm('此操作将覆盖当前帖子内容，确定要恢复数据吗？')) {
		return;
	}

	var data = data.split(/\x09\x09/);
	for(var i = 0; i < DocumentElementById('postform').elements.length; i++) {
		var el = DocumentElementById('postform').elements[i];
		if(el.name != '' && (el.tagName == 'TEXTAREA' || el.tagName == 'INPUT' && (el.type == 'text' || el.type == 'checkbox' || el.type == 'radio'))) {
			for(var j = 0; j < data.length; j++) {
				var ele = data[j].split(/\x09/);
				if(ele[0] == el.name) {
					elvalue = !isUndefined(ele[3]) ? ele[3] : '';
					if(ele[1] == 'INPUT') {
						if(ele[2] == 'text') {
							el.value = elvalue;
						} else if((ele[2] == 'checkbox' || ele[2] == 'radio') && ele[3] == el.value) {
							el.checked = true;
							evalevent(el);
						}
					} else if(ele[1] == 'TEXTAREA') {
						if(ele[0] == 'message') {
							if(!wysiwyg) {
								textobj.value = elvalue;
							} else {
								editdoc.body.innerHTML = bbcode2html(elvalue);
							}
						} else {
							el.value = elvalue;
						}
					}
					break
				}
			}
		}
	}
}

function evalevent(obj) {
	var script = obj.parentNode.innerHTML;
	var re = /onclick="(.+?)["|>]/ig;
	var matches = re.exec(script);
	if(matches != null) {
		matches[1] = matches[1].replace(/this\./ig, 'obj.');
		eval(matches[1]);
	}
}

function setCaretAtEnd() {
	if(wysiwyg) {
		editdoc.body.innerHTML += '';
	} else {
		editdoc.value += '';
	}
}

function relatekw(subject, message, recall) {
	if(isUndefined(recall)) recall = '';
	if(isUndefined(subject) || subject == -1) subject = DocumentElementById('subject').value;
	if(isUndefined(message) || message == -1) message = getEditorContents();
	subject = (BROWSER.ie && document.charset == 'utf-8' ? encodeURIComponent(subject) : subject);
	message = (BROWSER.ie && document.charset == 'utf-8' ? encodeURIComponent(message) : message);
	message = message.replace(/&/ig, '', message).substr(0, 500);
	//ajaxget('relatekw.php?subjectenc=' + subject + '&messageenc=' + message, 'tagselect', '', '', '', recall);
}

function switchicon(iconid, obj) {
	DocumentElementById('iconid').value = iconid;
	DocumentElementById('icon_img').src = obj.src;
	hideMenu();
}

var editbox = editwin = editdoc = editcss = null;
var cursor = -1;
var stack = [];
var initialized = false;

function newEditor(mode, initialtext) {

	wysiwyg = parseInt(mode);
	if(!(BROWSER.ie || BROWSER.firefox || (BROWSER.opera >= 9))) {
		allowswitcheditor = wysiwyg = 0;
	}
	if(!BROWSER.ie) {
		DocumentElementById(editorid + '_cmd_paste').parentNode.style.display = 'none';
	}
	if(!allowswitcheditor) {
		DocumentElementById(editorid + '_switcher').style.display = 'none';
	}

	DocumentElementById(editorid + '_cmd_table').disabled = wysiwyg ? false : true;
	DocumentElementById(editorid + '_cmd_table').className = wysiwyg ? '' : 'tblbtn_disabled';

	if(wysiwyg) {
		if(DocumentElementById(editorid + '_iframe')) {
			editbox = DocumentElementById(editorid + '_iframe');
		} else {
			var iframe = document.createElement('iframe');
			editbox = textobj.parentNode.appendChild(iframe);
			editbox.id = editorid + '_iframe';
		}

		editwin = editbox.contentWindow;
		editdoc = editwin.document;
		//initialtext参数为设置的文字
		//initialtext＝'123';]
		//设置文字
		var time_edit=DocumentElementById('edit_content').innerHTML;
		DocumentElementById('edit_content').innerHTML='';
		if (edit_enable){
            writeEditorContents(time_edit)
		}else{
		    DocumentElementById('edit_editor').innerHTML=time_edit;
		}
		//
		//window.alert(time_edit)
		

		//writeEditorContents(isUndefined(initialtext) ?  textobj.value : initialtext);
	} else {
		editbox = editwin = editdoc = textobj;
		if(!isUndefined(initialtext)) {
			writeEditorContents(initialtext);
		}
		addSnapshot(textobj.value);
	}
	setEditorEvents();
	initEditor();
}

function initEditor() {//给所有按钮添加点击事件
	var buttons = DocumentElementById(editorid + '_controls').getElementsByTagName('a');
	for(var i = 0; i < buttons.length; i++) {
	//如果edit_enable为false 则按钮功能取消
		if(buttons[i].id.indexOf(editorid + '_cmd_') != -1 && edit_enable) {
			buttons[i].href = 'javascript:;';
			buttons[i].onclick = function(e) {
			    discuzcode(this.id.substr(this.id.lastIndexOf('_cmd_') + 5));
			    try{
			        //ajaxget('forumstat.php?action='+this.id);
			        } catch(e) 
			            {
			        
			            }
			        };
		}
	}
	setUnselectable(DocumentElementById(editorid + '_controls'));
	textobj.onkeydown = function(e) {ctlent(e ? e : event)};
}

function setUnselectable(obj) {
	if(BROWSER.ie && BROWSER.ie > 4 && typeof obj.tagName != 'undefined') {
		if(obj.hasChildNodes()) {
			for(var i = 0; i < obj.childNodes.length; i++) {
				setUnselectable(obj.childNodes[i]);
			}
		}
		if(obj.tagName != 'INPUT') {
			obj.unselectable = 'on';
		}
	}
}

function writeEditorContents(text) {
	if(wysiwyg) {
		if(text == '' && (BROWSER.firefox || BROWSER.opera)) {
			text = '<br />';
		}
		if(initialized && !(BROWSER.firefox && BROWSER.firefox >= 3 || BROWSER.opera)) {
			editdoc.body.innerHTML = text;
		} else {
			editdoc.designMode = 'on';
			editdoc = editwin.document;
			editdoc.open('text/html', 'replace');
			editdoc.write(text);			
			editdoc.close();	
			//editdoc.body.onkeydown = function(){replaceP()};		
			editdoc.body.contentEditable = edit_enable;
			initialized = true;
		}
	} else {
		textobj.value = text;
	}
	setEditorStyle();
}
function replaceP(){
    var s_text=getEditorContents();
    while (s_text.indexOf("<P>&nbsp;</P>")>=0){
        s_text=s_text.replace("<P>&nbsp;</P>","")
        }
    while (s_text.indexOf("<P>")>=0){
        s_text=s_text.replace("<P>","")
        }
    while (s_text.indexOf("</P>")>=0){
        s_text=s_text.replace("</P>","<BR/>")
        }
    writeEditorContents(s_text)
}
function getEditorContents() {//获取文本编辑框的文字
	return wysiwyg ? editdoc.body.innerHTML : editdoc.value;
}

function setEditorStyle() {
	if(wysiwyg) {
		textobj.style.display = 'none';
		editbox.style.display = '';
		editbox.className = textobj.className;

		var headNode = editdoc.getElementsByTagName("head")[0];
		if(!headNode) {
			headNode = editdoc.getElementsByTagName("body")[0];
		}
		if(!headNode.getElementsByTagName('link').length) {
			editcss = editdoc.createElement('link');
			editcss.type = 'text/css';
			editcss.rel = 'stylesheet';
			editcss.href = editorcss;
			headNode.appendChild(editcss);
		}

		if(BROWSER.firefox || BROWSER.opera) {
			editbox.style.border = '0px';
		} else if(BROWSER.ie) {
			editdoc.body.style.border = '0px';
			editdoc.body.addBehavior('#default#userData');
		}
		editbox.style.width = textobj.style.width;
		editbox.style.height = textobj.style.height;
		editdoc.firstChild.style.background = 'none';
		editdoc.body.style.backgroundColor = TABLEBG;
		editdoc.body.style.textAlign = 'left';
		if(BROWSER.ie) {
			try{DocumentElementById('subject').focus();} catch(e) {editwin.focus();}
		}
	} else {
		var iframe = textobj.parentNode.getElementsByTagName('iframe')[0];
		if(iframe) {
			textobj.style.display = '';
			textobj.style.width = iframe.style.width;
			textobj.style.height = iframe.style.height;
			iframe.style.display = 'none';
		}
		if(BROWSER.ie) {
			try{DocumentElementById('subject').focus();} catch(e) {}
		}
	}
}

function setEditorEvents() {
    if (edit_enable===false){//如果文本编辑框为禁用，那么就不设置事件了
        return 
    }
	var floatPic = function(e) {
		var obj = BROWSER.ie ? e.srcElement : e.target;
		var tag = obj.tagName.toLowerCase();
		var menuid = obj.id + '_menu';
		var menu = DocumentElementById(menuid);

		if(JSMENU['float']) DocumentElementById(JSMENU['float']).style.display = 'none';
		if(tag != 'img') return;
		if(!obj.id) obj.id = editorid + '_f_' + tag + '_' + Math.random();

		if(!menu) {
			menu = document.createElement('div');
			menu.id = menuid;
			menu.style.position = 'absolute';
			menu.style.zIndex = '999';
			menu.className = 'popupmenu_popup popupfix simple_menu';
			menu.style.width = '80px';
			menu.innerHTML = '<div class="popupmenu_option" unselectable="on"><ul unselectable="on"><li id="' + menuid + '_left" unselectable="on">图片居左混排</li><li id="' + menuid + '_right" unselectable="on">图片居右混排</li></ul></div>';
			DocumentElementById('append_parent').appendChild(menu);
			DocumentElementById(menuid + '_left').onclick = function(e) {discuzcode('floatleft', obj.id);menu.style.display='none';doane(e)};
			DocumentElementById(menuid + '_right').onclick = function(e) {discuzcode('floatright', obj.id);menu.style.display='none';doane(e)};
		}
		var pos = fetchOffset(DocumentElementById(editorid + '_iframe'));
		menu.style.left = pos['left'] + e.clientX + 'px';
		menu.style.top = pos['top'] + e.clientY + 'px';
		menu.style.display = '';
		JSMENU['float'] = menuid;
		doane(e);
	};
	if(wysiwyg) {
		if(BROWSER.firefox || BROWSER.opera) {
			editwin.addEventListener('keydown', function(e) {ctlent(e);}, true);
			editwin.addEventListener('mouseup', floatPic, true);
		} else if(editdoc.attachEvent) {
			editdoc.body.attachEvent('onkeydown', ctlent);
			editdoc.body.attachEvent('onmouseup', floatPic);
		}
	}
	editwin.onfocus = function(e) {this.hasfocus = true;};
	editwin.onblur = function(e) {this.hasfocus = false;};
}

function wrapTags(tagname, useoption, selection) {
	if(isUndefined(selection)) {
		var selection = getSel();
		if(selection === false) {
			selection = '';
		} else {
			selection += '';
		}
	}

	if(useoption !== false) {
		var opentag = '[' + tagname + '=' + useoption + ']';
	} else {
		var opentag = '[' + tagname + ']';
	}

	var closetag = '[/' + tagname + ']';
	var text = opentag + selection + closetag;

	insertText(text, strlen(opentag), strlen(closetag), in_array(tagname, ['code', 'quote', 'free', 'hide']) ? true : false);
}

function applyFormat(cmd, dialog, argument) {
	if(wysiwyg) {
		editdoc.execCommand(cmd, (isUndefined(dialog) ? false : dialog), (isUndefined(argument) ? true : argument));
		return;
	}
	switch(cmd) {
		case 'paste':
			if(BROWSER.ie) {
				var str = clipboardData.getData("TEXT");
				insertText(str, str.length, 0);
			}
			break;
		case 'bold':
		case 'italic':
		case 'underline':
		case 'strikethrough':
			wrapTags(cmd.substr(0, 1), false);
			break;
		case 'inserthorizontalrule':
			insertText('[hr]', 4, 0);
			break;
		case 'justifyleft':
		case 'justifycenter':
		case 'justifyright':
			wrapTags('align', cmd.substr(7));
			break;
		case 'fontname':
			wrapTags('font', argument);
			break;
		case 'fontsize':
			wrapTags('size', argument);
			break;
		case 'forecolor':
			wrapTags('color', argument);
			break;
	}
}

function getCaret() {
	if(wysiwyg) {
		var obj = editdoc.body;
		var s = document.selection.createRange();
		s.setEndPoint('StartToStart', obj.createTextRange());
		var matches1 = s.htmlText.match(/<\/p>/ig);
		var matches2 = s.htmlText.match(/<br[^\>]*>/ig);
		var fix = (matches1 ? matches1.length - 1 : 0) + (matches2 ? matches2.length : 0);
		var pos = s.text.replace(/\r?\n/g, ' ').length;
		if(matches3 = s.htmlText.match(/<img[^\>]*>/ig)) pos += matches3.length;
		if(matches4 = s.htmlText.match(/<\/tr|table>/ig)) pos += matches4.length;
		return [pos, fix];
	} else {
		var sel = getSel();
		return [sel === false ? 0 : sel.length, 0];
	}
}

function setCaret(pos) {
	var obj = wysiwyg ? editdoc.body : editbox;
	var r = obj.createTextRange();
	r.moveStart('character', pos);
	r.collapse(true);
	r.select();
}

function isEmail(email) {
	return email.length > 6 && /^[\w\-\.]+@[\w\-\.]+(\.\w+)+$/.test(email);
}

function insertAttachTag(aid) {
	var txt = '[attach]' + aid + '[/attach]';
	if(wysiwyg) {
		insertText(txt, false);
	} else {
		insertText(txt, strlen(txt), 0);
	}
}

function insertAttachimgTag(aid) {
	if(wysiwyg) {
		insertText('<img src="' + DocumentElementById('image_' + aid).src + '" border="0" aid="attachimg_' + aid + '" width="' + DocumentElementById('image_' + aid).width + '" alt="" />', false);
	} else {
		var txt = '[attachimg]' + aid + '[/attachimg]';
		insertText(txt, strlen(txt), 0);
	}
}

function insertSmiley(smilieid) {
	checkFocus();
	var src = DocumentElementById('smilie_' + smilieid).src;
	var code = DocumentElementById('smilie_' + smilieid).alt;
	if(wysiwyg && allowsmilies && (!DocumentElementById('smileyoff') || DocumentElementById('smileyoff').checked == false)) {
		if(BROWSER.firefox) {
			applyFormat('InsertImage', false, src);
			var smilies = editdoc.body.getElementsByTagName('img');
			for(var i = 0; i < smilies.length; i++) {
				if(smilies[i].src == src && smilies[i].getAttribute('smilieid') < 1) {
					smilies[i].setAttribute('smilieid', smilieid);
					smilies[i].setAttribute('border', "0");
				}
			}
		} else {
			insertText('<img src="' + src + '" border="0" smilieid="' + smilieid + '" alt="" /> ', false);
		}
	} else {
		code += ' ';
		insertText(code, strlen(code), 0);
	}
	hideMenu();
}

function discuzcode(cmd, arg) {//当鼠标按下按钮时
	if(cmd != 'redo') {
		addSnapshot(getEditorContents());
	}

	checkFocus();

	if(in_array(cmd, ['simple', 'paragraph', 'list', 'smilies', 'createlink', 'quote', 'code', 'free', 'hide', 'audio', 'video', 'flash', 'attach', 'image']) || cmd == 'table' && wysiwyg || in_array(cmd, ['fontname', 'fontsize', 'forecolor']) && !arg) {
		showEditorMenu(cmd);
		return;
	} else if(cmd.substr(0, 6) == 'custom') {
		showEditorMenu(cmd.substr(8), cmd.substr(6, 1));
		return;
	} else if(wysiwyg && cmd == 'inserthorizontalrule') {
		insertText('<hr class="solidline" />', 24);
	} else if(cmd == 'autotypeset') {
		autoTypeset();
		return;
	} else if(!wysiwyg && cmd == 'removeformat') {
		var simplestrip = new Array('b', 'i', 'u');
		var complexstrip = new Array('font', 'color', 'size');

		var str = getSel();
		if(str === false) {
			return;
		}
		for(var tag in simplestrip) {
			str = stripSimple(simplestrip[tag], str);
		}
		for(var tag in complexstrip) {
			str = stripComplex(complexstrip[tag], str);
		}
		insertText(str);
	} else if(!wysiwyg && cmd == 'undo') {
		addSnapshot(getEditorContents());
		moveCursor(-1);
		if((str = getSnapshot()) !== false) {
			editdoc.value = str;
		}
	} else if(!wysiwyg && cmd == 'redo') {
		moveCursor(1);
		if((str = getSnapshot()) !== false) {
			editdoc.value = str;
		}
	} else if(!wysiwyg && in_array(cmd, ['insertorderedlist', 'insertunorderedlist'])) {
		var listtype = cmd == 'insertorderedlist' ? '1' : '';
		var opentag = '[list' + (listtype ? ('=' + listtype) : '') + ']\n';
		var closetag = '[/list]';

		if(txt = getSel()) {
			var regex = new RegExp('([\r\n]+|^[\r\n]*)(?!\\[\\*\\]|\\[\\/?list)(?=[^\r\n])', 'gi');
			txt = opentag + trim(txt).replace(regex, '$1[*]') + '\n' + closetag;
			insertText(txt, strlen(txt), 0);
		} else {
			insertText(opentag + closetag, opentag.length, closetag.length);

			while(listvalue = prompt('输入一个列表项目.\r\n留空或者点击取消完成此列表.', '')) {
				if(BROWSER.opera > 8) {
					listvalue = '\n' + '[*]' + listvalue;
					insertText(listvalue, strlen(listvalue) + 1, 0);
				} else {
					listvalue = '[*]' + listvalue + '\n';
					insertText(listvalue, strlen(listvalue), 0);
				}
			}
		}
	} else if(!wysiwyg && cmd == 'unlink') {
		var sel = getSel();
		sel = stripSimple('url', sel);
		sel = stripComplex('url', sel);
		insertText(sel);
	} else if(cmd == 'floatleft' || cmd == 'floatright') {
		if(wysiwyg) {
			if(selection = getSel()) {
				var span = editdoc.getElementById(arg).parentNode;
				if(span.tagName == 'SPAN') {
					if(typeof span.style.styleFloat != 'undefined') span.style.styleFloat = cmd.substr(5);
					else span.style.cssFloat = cmd.substr(5);
					return;
				} else {
					var ret = insertText('<br style="clear: both"><span style="float: ' + cmd.substr(5) + '">' + selection + '</span>', true);
				}
			}
		}
	} else if(cmd == 'loaddata') {
		loadData();
	} else if(cmd == 'savedata') {
		saveData();
	} else if(cmd == 'checklength') {
		checklength(DocumentElementById('postform'));
	} else if(cmd == 'clearcontent') {
		clearContent();
	} else {
		try {
			var ret = applyFormat(cmd, false, (isUndefined(arg) ? true : arg));
		} catch(e) {
			var ret = false;
		}
	}

	if(cmd != 'undo') {
		addSnapshot(getEditorContents());
	}
	if(in_array(cmd, ['bold', 'italic', 'underline', 'strikethrough', 'inserthorizontalrule', 'fontname', 'fontsize', 'forecolor', 'justifyleft', 'justifycenter', 'justifyright', 'insertorderedlist', 'insertunorderedlist', 'floatleft', 'floatright', 'removeformat', 'unlink', 'undo', 'redo'])) {
		hideMenu();
	}
	return ret;
}
var S_Ctrlid=''
function showEditorMenu(tag, params) {
	var sel, selection;
	var str = '';
	var ctrlid = editorid + (params ? '_cmd_custom' + params + '_' : '_cmd_') + tag;
	S_Ctrlid=ctrlid+'_param_1'
	var opentag = '[' + tag + ']';
	var closetag = '[/' + tag + ']';
	var menu = DocumentElementById(ctrlid + '_menu');
	var pos = [0, 0];

	if(BROWSER.ie) {
		sel = wysiwyg ? editdoc.selection.createRange() : document.selection.createRange();
		pos = getCaret();
	}
	selection = sel ? (wysiwyg ? sel.htmlText : sel.text) : getSel();

	if(menu) {
		if(menu.style.display == '') {
			hideMenu(ctrlid + '_menu', 'menu');
			return;
		}
		showMenu({'ctrlid':ctrlid,'evt':'click','duration':in_array(tag, ['simple', 'fontname', 'fontsize', 'paragraph', 'list', 'smilies']) ? 2 : 3,'drag':in_array(tag, ['attach', 'image']) ? ctrlid + '_ctrl' : 1});
	} else {
		switch(tag) {
			case 'createlink':
				str = '请输入链接的地址:&nbsp;&nbsp;&nbsp;&nbsp;<a href="javascript:;" onclick="uploadAffixFile()">上传附件</a><br /><input type="text" id="' + ctrlid + '_param_1" style="width: 98%" value="" class="txt" />'+
					(selection ? '' : '<br />请输入链接的文字:<br /><input type="text" id="' + ctrlid + '_param_2" style="width: 98%" value="" class="txt" />');
				break;
			case 'forecolor':
				showColorBox(ctrlid, 1);
				return;
			case 'code':
			case 'quote':
			case 'hide':
			case 'free':
				if(selection) {
					return insertText((opentag + selection + closetag), strlen(opentag), strlen(closetag), true, sel);
				}
				var lang = {'quote' : '请输入要插入的引用', 'code' : '请输入要插入的代码', 'hide' : '请输入要插入的隐藏内容', 'free' : '请输入要插入的免费信息'};
				str += lang[tag] + ':<br /><textarea id="' + ctrlid + '_param_1" style="width: 98%" cols="50" rows="5" class="txtarea"></textarea>' +
					(tag == 'hide' ? '<br /><input type="radio" name="' + ctrlid + '_radio" id="' + ctrlid + '_radio_1" class="txt" checked="checked" />只有当浏览者回复本帖时才显示<br /><input type="radio" name="' + ctrlid + '_radio" id="' + ctrlid + '_radio_2" class="txt" />只有当浏览者积分高于 <input type="text" size="3" id="' + ctrlid + '_param_2" class="txt" /> 时才显示' : '');
				break;
			case 'table':
				str = '表格行数: <input type="text" id="' + ctrlid + '_param_1" size="2" value="2" class="txt" /> &nbsp; 表格列数: <input type="text" id="' + ctrlid + '_param_2" size="2" value="2" class="txt" /><br />表格宽度: <input type="text" id="' + ctrlid + '_param_3" size="2" value="" class="txt" /> &nbsp; 背景颜色: <input type="text" id="' + ctrlid + '_param_4" size="2" class="txt" onclick="showColorBox(this.id, 2)" />';
				break;
			case 'audio':
				str = '请输入音乐文件地址:<br /><input type="text" id="' + ctrlid + '_param_1" class="txt" value="" style="width: 245px;" />';
				break;
			case 'video':
				str = '请输入视频地址:<br /><input type="text" value="" id="' + ctrlid + '_param_1" style="width: 245px;" class="txt" /><br />宽: <input id="' + ctrlid + '_param_2" size="5" value="400" class="txt" /> &nbsp; 高: <input id="' + ctrlid + '_param_3" size="5" value="300" class="txt" />';
				break;
			case 'flash':
				str = '请输入 Flash 文件地址:<br /><input type="text" id="' + ctrlid + '_param_1" class="txt" value="" style="width: 245px;" />';
				break;
			default:
				var haveSel = selection == null || selection == false || in_array(trim(selection), ['', 'null', 'undefined', 'false']) ? 0 : 1;
				if(params == 1 && haveSel) {
					return insertText((opentag + selection + closetag), strlen(opentag), strlen(closetag), true, sel);
				}
				var promptlang = custombbcodes[tag]['prompt'].split("\t");
				for(var i = 1; i <= params; i++) {
					if(i != params || !haveSel) {
						str += (promptlang[i - 1] ? promptlang[i - 1] : '请输入第 ' + i + ' 个参数:') + '<br /><input type="text" id="' + ctrlid + '_param_' + i + '" style="width: 98%" value="" class="txt" />' + (i < params ? '<br />' : '');
					}
				}
				break;
		}

		var menu = document.createElement('div');
		menu.id = ctrlid + '_menu';
		menu.style.display = 'none';
		menu.className = 'popupmenu_popup popupfix';
		menu.style.width = (tag == 'table' ? 192 : 250) + 'px';
		DocumentElementById(editorid + '_controls').appendChild(menu);
		menu.innerHTML = '<div class="popupmenu_option">' + str + '<br /><center><input type="button" id="' + ctrlid + '_submit" value="提交" /> &nbsp; <input type="button" onClick="hideMenu()" value="取消" /></center></div>';
		showMenu({'ctrlid':ctrlid,'evt':'click','duration':3,'cache':0,'drag':1});
	}

	try{DocumentElementById(ctrlid + '_param_1').focus()}catch(e){};
	var objs = menu.getElementsByTagName('*');
	for(var i = 0; i < objs.length; i++) {
		_attachEvent(objs[i], 'keydown', function(e) {
			e = e ? e : event;
			obj = BROWSER.ie ? event.srcElement : e.target;
			if((obj.type == 'text' && e.keyCode == 13) || (obj.type == 'textarea' && e.ctrlKey && e.keyCode == 13)) {
				if(DocumentElementById(ctrlid + '_submit') && tag != 'image') DocumentElementById(ctrlid + '_submit').click();
				doane(e);
			} else if(e.keyCode == 27) {
				hideMenu();
				doane(e);
			}
		});
	}
	if(DocumentElementById(ctrlid + '_submit')) DocumentElementById(ctrlid + '_submit').onclick = function() {
		checkFocus();
		if(BROWSER.ie) {
			setCaret(pos[0]);
		}
		switch(tag) {
			case 'createlink':
				var href = DocumentElementById(ctrlid + '_param_1').value;
				href = (isEmail(href) ? 'mailto:' : '') + href;
				if(href != '') {
					var v = selection ? selection : (DocumentElementById(ctrlid + '_param_2').value ? DocumentElementById(ctrlid + '_param_2').value : href);
					str = wysiwyg ? ('<a href="' + href + '">' + v + '</a>') : '[url=' + href + ']' + v + '[/url]';
					if(wysiwyg) insertText(str, str.length - v.length, 0, (selection ? true : false), sel);
					else insertText(str, str.length - v.length - 6, 6, (selection ? true : false), sel);
				}
				break;
			case 'code':
			case 'quote':
			case 'hide':
			case 'free':
				if(tag == 'hide' && DocumentElementById(ctrlid + '_radio_2').checked) {
					var mincredits = parseInt(DocumentElementById(ctrlid + '_param_2').value);
					opentag = mincredits > 0 ? '[hide=' + mincredits + ']' : '[hide]';
				}
				str = selection ? selection : DocumentElementById(ctrlid + '_param_1').value;
				if(wysiwyg) {
					if(tag == 'code') {
						str = preg_replace(['<', '>'], ['&lt;', '&gt;'], str);
					}
					str = str.replace(/\r?\n/g, '<br />');
				}
				str = opentag + str + closetag;
				insertText(str, strlen(opentag), strlen(closetag), false, sel);
				break;
			case 'table':
				var rows = DocumentElementById(ctrlid + '_param_1').value;
				var columns = DocumentElementById(ctrlid + '_param_2').value;
				var width = DocumentElementById(ctrlid + '_param_3').value;
				var bgcolor = DocumentElementById(ctrlid + '_param_4').value;
				rows = /^[-\+]?\d+$/.test(rows) && rows > 0 && rows <= 30 ? rows : 2;
				columns = /^[-\+]?\d+$/.test(columns) && columns > 0 && columns <= 30 ? columns : 2;
				width = width.substr(width.length - 1, width.length) == '%' ? (width.substr(0, width.length - 1) <= 98 ? width : '98%') : (width <= 560 ? width : '98%');
				bgcolor = /[\(\)%,#\w]+/.test(bgcolor) ? bgcolor : '';
				str = '<table cellspacing="0" cellpadding="0" width="' + (width ? width : '50%') + '" class="t_table"' + (bgcolor ? ' bgcolor="' + bgcolor + '"' : '') + '>';
				for (var row = 0; row < rows; row++) {
					str += '<tr>\n';
					for (col = 0; col < columns; col++) {
						str += '<td>&nbsp;</td>\n';
					}
					str += '</tr>\n';
				}
				str += '</table>\n';
				insertText(str, str.length - pos[1], 0, false, sel);
				break;
			case 'audio':
			case 'flash':
				insertText(opentag + DocumentElementById(ctrlid + '_param_1').value + closetag, opentag.length, closetag.length, false, sel);
				break;
			case 'video':
				var mediaUrl = DocumentElementById(ctrlid + '_param_1').value;
				var ext = mediaUrl.lastIndexOf('.') == -1 ? '' : mediaUrl.substr(mediaUrl.lastIndexOf('.') + 1, mb_strlen(mediaUrl)).toLowerCase();
				ext = in_array(ext, ['mp3', 'wma', 'ra', 'rm', 'ram', 'mid', 'wmv', 'avi', 'mpg', 'mpeg', 'rmvb', 'asf', 'mov', 'flv', 'swf']) ? ext : 'x';
				var str = '[media=' + ext + ',' + DocumentElementById(ctrlid + '_param_2').value + ',' + DocumentElementById(ctrlid + '_param_3').value + ']' + mediaUrl + '[/media]';
				insertText(str, str.length - pos[1], 0, false, sel);
				break;
			case 'image':
				var width = parseInt(DocumentElementById(ctrlid + '_param_2').value);
				var height = parseInt(DocumentElementById(ctrlid + '_param_3').value);
				width = width > 0 && width <= 1024 ? width : 0;
				height = height && height <= 768 > 0 ? height : 0;
				var src = DocumentElementById(ctrlid + '_param_1').value;
				var style = '';
				if(wysiwyg) {
					style += width ? ' width=' + width : '';
					style += height ? ' height=' + height : '';
					var str = '<img src=' + src + style + ' border=0 /> ';
					insertText(str, str.length - pos[1], 0, false, sel);
				} else {
					style += width || height ? '=' + width + ',' + height : '';
					insertText('[img' + style + ']' + src + '[/img]');
				}
				DocumentElementById(ctrlid + '_param_1').value = '';
			default:
				var first = DocumentElementById(ctrlid + '_param_1').value;
				if(DocumentElementById(ctrlid + '_param_2')) var second = DocumentElementById(ctrlid + '_param_2').value;
				if(DocumentElementById(ctrlid + '_param_3')) var third = DocumentElementById(ctrlid + '_param_3').value;
				if((params == 1 && first) || (params == 2 && first && (haveSel || second)) || (params == 3 && first && second && (haveSel || third))) {
					if(params == 1) {
						str = first;
					} else if(params == 2) {
						str = haveSel ? selection : second;
						opentag = '[' + tag + '=' + first + ']';
					} else {
						str = haveSel ? selection : third;
						opentag = '[' + tag + '=' + first + ',' + second + ']';
					}
					insertText((opentag + str + closetag), strlen(opentag), strlen(closetag), true, sel);
				}
				break;
		}
		hideMenu();
	};
}

function autoTypeset() {
	var sel;
	if(BROWSER.ie) {
		sel = wysiwyg ? editdoc.selection.createRange() : document.selection.createRange();
	}
	var selection = sel ? (wysiwyg ? sel.htmlText.replace(/<\/?p>/ig, '<br />') : sel.text) : getSel();
	selection = wysiwyg ? selection.replace(/<br[^\>]*>/ig, "\n") : selection.replace(/\r?\n/g, "\n");
	selection = trim(selection);
	selection = wysiwyg ? selection.replace(/\n+/g, '</p><p style="line-height: 30px; text-indent: 2em;">') : selection.replace(/\n/g, '[/p][p=30, 2, left]');
	opentag = wysiwyg ? '<p style="line-height: 30px; text-indent: 2em;">' : '[p=30, 2, left]';
	var s = opentag + selection + (wysiwyg ? '</p>' : '[/p]');
	insertText(s, strlen(opentag), 4, false, sel);
	hideMenu();
}

function getSel() {
	if(wysiwyg) {
		if(BROWSER.firefox || BROWSER.opera) {
			selection = editwin.getSelection();
			checkFocus();
			range = selection ? selection.getRangeAt(0) : editdoc.createRange();
			return readNodes(range.cloneContents(), false);
		} else {
			var range = editdoc.selection.createRange();
			if(range.htmlText && range.text) {
				return range.htmlText;
			} else {
				var htmltext = '';
				for(var i = 0; i < range.length; i++) {
					htmltext += range.item(i).outerHTML;
				}
				return htmltext;
			}
		}
	} else {
		if(!isUndefined(editdoc.selectionStart)) {
			return editdoc.value.substr(editdoc.selectionStart, editdoc.selectionEnd - editdoc.selectionStart);
		} else if(document.selection && document.selection.createRange) {
			return document.selection.createRange().text;
		} else if(window.getSelection) {
			return window.getSelection() + '';
		} else {
			return false;
		}
	}
}

function insertText(text, movestart, moveend, select, sel) {
	if(wysiwyg) {
		if(BROWSER.firefox || BROWSER.opera) {
			applyFormat('removeformat');
			var fragment = editdoc.createDocumentFragment();
			var holder = editdoc.createElement('span');
			holder.innerHTML = text;

			while(holder.firstChild) {
				fragment.appendChild(holder.firstChild);
			}
			insertNodeAtSelection(fragment);
		} else {
			checkFocus();
			if(!isUndefined(editdoc.selection) && editdoc.selection.type != 'Text' && editdoc.selection.type != 'None') {
				movestart = false;
				editdoc.selection.clear();
			}

			if(isUndefined(sel)) {
				sel = editdoc.selection.createRange();
			}

			sel.pasteHTML(text);

			if(text.indexOf('\n') == -1) {
				if(!isUndefined(movestart)) {
					sel.moveStart('character', -strlen(text) + movestart);
					sel.moveEnd('character', -moveend);
				} else if(movestart != false) {
					sel.moveStart('character', -strlen(text));
				}
				if(!isUndefined(select) && select) {
					sel.select();
				}
			}
		}
	} else {
		checkFocus();
		if(!isUndefined(editdoc.selectionStart)) {
			var opn = editdoc.selectionStart + 0;
			editdoc.value = editdoc.value.substr(0, editdoc.selectionStart) + text + editdoc.value.substr(editdoc.selectionEnd);

			if(!isUndefined(movestart)) {
				editdoc.selectionStart = opn + movestart;
				editdoc.selectionEnd = opn + strlen(text) - moveend;
			} else if(movestart !== false) {
				editdoc.selectionStart = opn;
				editdoc.selectionEnd = opn + strlen(text);
			}
		} else if(document.selection && document.selection.createRange) {
			if(isUndefined(sel)) {
				sel = document.selection.createRange();
			}
			sel.text = text.replace(/\r?\n/g, '\r\n');
			if(!isUndefined(movestart)) {
				sel.moveStart('character', -strlen(text) +movestart);
				sel.moveEnd('character', -moveend);
			} else if(movestart !== false) {
				sel.moveStart('character', -strlen(text));
			}
			sel.select();
		} else {
			editdoc.value += text;
		}
	}
}

function stripSimple(tag, str, iterations) {
	var opentag = '[' + tag + ']';
	var closetag = '[/' + tag + ']';

	if(isUndefined(iterations)) {
		iterations = -1;
	}
	while((startindex = stripos(str, opentag)) !== false && iterations != 0) {
		iterations --;
		if((stopindex = stripos(str, closetag)) !== false) {
			var text = str.substr(startindex + opentag.length, stopindex - startindex - opentag.length);
			str = str.substr(0, startindex) + text + str.substr(stopindex + closetag.length);
		} else {
			break;
		}
	}
	return str;
}

function stripComplex(tag, str, iterations) {
	var opentag = '[' + tag + '=';
	var closetag = '[/' + tag + ']';

	if(isUndefined(iterations)) {
		iterations = -1;
	}
	while((startindex = stripos(str, opentag)) !== false && iterations != 0) {
		iterations --;
		if((stopindex = stripos(str, closetag)) !== false) {
			var openend = stripos(str, ']', startindex);
			if(openend !== false && openend > startindex && openend < stopindex) {
				var text = str.substr(openend + 1, stopindex - openend - 1);
				str = str.substr(0, startindex) + text + str.substr(stopindex + closetag.length);
			} else {
				break;
			}
		} else {
			break;
		}
	}
	return str;
}

function stripos(haystack, needle, offset) {
	if(isUndefined(offset)) {
		offset = 0;
	}
	var index = haystack.toLowerCase().indexOf(needle.toLowerCase(), offset);

	return (index == -1 ? false : index);
}

function switchEditor(mode) {
	if(mode == wysiwyg || !allowswitcheditor)  {
		return;
	}
	if(!mode) {
		var controlbar = DocumentElementById(editorid + '_controls');
		var controls = [];
		var buttons = controlbar.getElementsByTagName('a');
		var buttonslength = buttons.length;
		for(var i = 0; i < buttonslength; i++) {
			if(buttons[i].id) {
				controls[controls.length] = buttons[i].id;
			}
		}
		var controlslength = controls.length;
		for(var i = 0; i < controlslength; i++) {
			var control = DocumentElementById(controls[i]);

			if(control.id.indexOf(editorid + '_cmd_') != -1) {
				control.className = control.id.indexOf(editorid + '_cmd_custom') == -1 ? '' : 'plugeditor';
				control.state = false;
				control.mode = 'normal';
			} else if(control.id.indexOf(editorid + '_popup_') != -1) {
				control.state = false;
			}
		}
	}
	cursor = -1;
	stack = [];
	var parsedtext = getEditorContents();
	parsedtext = mode ? bbcode2html(parsedtext) : html2bbcode(parsedtext);
	wysiwyg = mode;
	DocumentElementById(editorid + '_mode').value = mode;

	newEditor(mode, parsedtext);
	setEditorStyle();
	editwin.focus();
	setCaretAtEnd();
}

function insertNodeAtSelection(text) {
	checkFocus();

	var sel = editwin.getSelection();
	var range = sel ? sel.getRangeAt(0) : editdoc.createRange();
	sel.removeAllRanges();
	range.deleteContents();

	var node = range.startContainer;
	var pos = range.startOffset;

	switch(node.nodeType) {
		case Node.ELEMENT_NODE:
			if(text.nodeType == Node.DOCUMENT_FRAGMENT_NODE) {
				selNode = text.firstChild;
			} else {
				selNode = text;
			}
			node.insertBefore(text, node.childNodes[pos]);
			add_range(selNode);
			break;

		case Node.TEXT_NODE:
			if(text.nodeType == Node.TEXT_NODE) {
				var text_length = pos + text.length;
				node.insertData(pos, text.data);
				range = editdoc.createRange();
				range.setEnd(node, text_length);
				range.setStart(node, text_length);
				sel.addRange(range);
			} else {
				node = node.splitText(pos);
				var selNode;
				if(text.nodeType == Node.DOCUMENT_FRAGMENT_NODE) {
					selNode = text.firstChild;
				} else {
					selNode = text;
				}
				node.parentNode.insertBefore(text, node);
				add_range(selNode);
			}
			break;
	}
}

function add_range(node) {
	checkFocus();
	var sel = editwin.getSelection();
	var range = editdoc.createRange();
	range.selectNodeContents(node);
	sel.removeAllRanges();
	sel.addRange(range);
}

function readNodes(root, toptag) {
	var html = "";
	var moz_check = /_moz/i;

	switch(root.nodeType) {
		case Node.ELEMENT_NODE:
		case Node.DOCUMENT_FRAGMENT_NODE:
			var closed;
			if(toptag) {
				closed = !root.hasChildNodes();
				html = '<' + root.tagName.toLowerCase();
				var attr = root.attributes;
				for(var i = 0; i < attr.length; ++i) {
					var a = attr.item(i);
					if(!a.specified || a.name.match(moz_check) || a.value.match(moz_check)) {
						continue;
					}
					html += " " + a.name.toLowerCase() + '="' + a.value + '"';
				}
				html += closed ? " />" : ">";
			}
			for(var i = root.firstChild; i; i = i.nextSibling) {
				html += readNodes(i, true);
			}
			if(toptag && !closed) {
				html += "</" + root.tagName.toLowerCase() + ">";
			}
			break;

		case Node.TEXT_NODE:
			html = htmlspecialchars(root.data);
			break;
	}
	return html;
}

function moveCursor(increment) {
	var test = cursor + increment;
	if(test >= 0 && stack[test] != null && !isUndefined(stack[test])) {
		cursor += increment;
	}
}

function addSnapshot(str) {
	if(stack[cursor] == str) {
		return;
	} else {
		cursor++;
		stack[cursor] = str;

		if(!isUndefined(stack[cursor + 1])) {
			stack[cursor + 1] = null;
		}
	}
}

function getSnapshot() {
	if(!isUndefined(stack[cursor]) && stack[cursor] != null) {
		return stack[cursor];
	} else {
		return false;
	}
}

function clearContent() {
	if(wysiwyg) {
		editdoc.body.innerHTML = BROWSER.firefox ? '<br />' : '';
	} else {
		textobj.value = '';
	}
}

function uploadNextAttach() {
	var str = DocumentElementById('attachframe').contentWindow.document.body.innerHTML;
	if(str == '') return;
	var arr = str.split('|');
	var att = CURRENTATTACH.split('|');
	uploadAttach(parseInt(att[0]), arr[0] == 'DISCUZUPLOAD' ? parseInt(arr[1]) : -1, att[1]);
}

function uploadAttach(curId, statusid, prefix) {
	prefix = isUndefined(prefix) ? '' : prefix;
	var nextId = 0;
	for(var i = 0; i < AID - 1; i++) {
		if(DocumentElementById(prefix + 'attachform_' + i)) {
			nextId = i;
			if(curId == 0) {
				break;
			} else {
				if(i > curId) {
					break;
				}
			}
		}
	}
	if(nextId == 0) {
		return;
	}
	CURRENTATTACH = nextId + '|' + prefix;
	if(curId > 0) {
		if(statusid == 0) {
			UPLOADCOMPLETE++;
		} else {
			FAILEDATTACHS += '<br />' + mb_cutstr(DocumentElementById(prefix + 'attachnew_' + curId).value.substr(DocumentElementById(prefix + 'attachnew_' + curId).value.replace(/\\/g, '/').lastIndexOf('/') + 1), 25) + ': ' + STATUSMSG[statusid];
			UPLOADFAILED++;
		}
		DocumentElementById(prefix + 'cpdel_' + curId).innerHTML = '<img src="' + IMGDIR + '/check_' + (statusid == 0 ? 'right' : 'error') + '.gif" alt="' + STATUSMSG[statusid] + '" />';
		if(nextId == curId || in_array(statusid, [6, 8])) {
			if(prefix == 'img') updateImageList();
			else updateAttachList();
			if(UPLOADFAILED > 0) {
				showDialog('附件上传完成！成功 ' + UPLOADCOMPLETE + ' 个，失败 ' + UPLOADFAILED + ' 个:' + FAILEDATTACHS);
				FAILEDATTACHS = '';
			}
			UPLOADSTATUS = 2;
			for(var i = 0; i < AID - 1; i++) {
				if(DocumentElementById(prefix + 'attachform_' + i)) {
					reAddAttach(prefix, i)
				}
			}
			DocumentElementById(prefix + 'uploadbtn').style.display = '';
			DocumentElementById(prefix + 'uploading').style.display = 'none';
			if(AUTOPOST) {
				hideMenu();
				validate(DocumentElementById('postform'));
			} else if(UPLOADFAILED == 0 && ((prefix == 'img' && DocumentElementById(editorid + '_cmd_image_menu').style.display == 'none') || (prefix == '' && DocumentElementById(editorid + '_cmd_attach_menu').style.display == 'none'))) {
				showDialog('附件上传完成！', 'notice');
			}
			UPLOADFAILED = UPLOADCOMPLETE = 0;
			CURRENTATTACH = '0';
			FAILEDATTACHS = '';
			return;
		}
	} else {
		DocumentElementById(prefix + 'uploadbtn').style.display = 'none';
		DocumentElementById(prefix + 'uploading').style.display = '';
	}
	DocumentElementById(prefix + 'cpdel_' + nextId).innerHTML = '<img src="' + IMGDIR + '/loading.gif" alt="上传中..." />';
	UPLOADSTATUS = 1;
	DocumentElementById(prefix + 'attachform_' + nextId).submit();
}

function addAttach(prefix) {
	var id = AID;
	var tags, newnode, i;
	prefix = isUndefined(prefix) ? '' : prefix;
	newnode = DocumentElementById(prefix + 'attachbtnhidden').firstChild.cloneNode(true);
	tags = newnode.getElementsByTagName('input');
	for(i in tags) {
		if(tags[i].name == 'Filedata') {
			tags[i].id = prefix + 'attachnew_' + id;
			tags[i].onchange = function() {insertAttach(prefix, id)};
			tags[i].unselectable = 'on';
		} else if(tags[i].name == 'attachid') {
			tags[i].value = id;
		}
	}
	tags = newnode.getElementsByTagName('form');
	tags[0].name = tags[0].id = prefix + 'attachform_' + id;
	DocumentElementById(prefix + 'attachbtn').appendChild(newnode);
	newnode = DocumentElementById(prefix + 'attachbodyhidden').firstChild.cloneNode(true);
	tags = newnode.getElementsByTagName('input');
	for(i in tags) {
		if(tags[i].name == prefix + 'localid[]') {
			tags[i].value = id;
		}
	}
	tags = newnode.getElementsByTagName('span');
	for(i in tags) {
		if(tags[i].id == prefix + 'localfile[]') {
			tags[i].id = prefix + 'localfile_' + id;
		} else if(tags[i].id == prefix + 'cpdel[]') {
			tags[i].id = prefix + 'cpdel_' + id;
		} else if(tags[i].id == prefix + 'localno[]') {
			tags[i].id = prefix + 'localno_' + id;
		} else if(tags[i].id == prefix + 'deschidden[]') {
			tags[i].id = prefix + 'deschidden_' + id;
		}
	}
	AID++;
	newnode.style.display = 'none';
	DocumentElementById(prefix + 'attachbody').appendChild(newnode);
}

function insertAttach(prefix, id) {
	var localimgpreview = '';
	var path = DocumentElementById(prefix + 'attachnew_' + id).value;
	var extpos = path.lastIndexOf('.');
	var ext = extpos == -1 ? '' : path.substr(extpos + 1, path.length).toLowerCase();
	var re = new RegExp("(^|\\s|,)" + ext + "($|\\s|,)", "ig");
	var localfile = DocumentElementById(prefix + 'attachnew_' + id).value.substr(DocumentElementById(prefix + 'attachnew_' + id).value.replace(/\\/g, '/').lastIndexOf('/') + 1);
	var filename = mb_cutstr(localfile, 30);

	if(path == '') {
		return;
	}
	if(extensions != '' && (re.exec(extensions) == null || ext == '')) {
		reAddAttach(prefix, id);
		showDialog('对不起，不支持上传此类扩展名的附件。');
		return;
	}
	if(prefix == 'img' && imgexts.indexOf(ext) == -1) {
		reAddAttach(prefix, id);
		showDialog('请选择图片文件(' + imgexts + ')');
		return;
	}

	DocumentElementById(prefix + 'cpdel_' + id).innerHTML = '<a href="###" class="deloption" onclick="reAddAttach(\'' + prefix + '\', ' + id + ')">删除</a>';
	DocumentElementById(prefix + 'localfile_' + id).innerHTML = '<span>' + filename + '</span>';
	DocumentElementById(prefix + 'attachnew_' + id).style.display = 'none';
	DocumentElementById(prefix + 'deschidden_' + id).style.display = '';
	DocumentElementById(prefix + 'deschidden_' + id).title = localfile;
	DocumentElementById(prefix + 'localno_' + id).parentNode.parentNode.style.display = '';
	addAttach(prefix);
	UPLOADSTATUS = 0;
}

function reAddAttach(prefix, id) {
	DocumentElementById(prefix + 'attachbody').removeChild(DocumentElementById(prefix + 'localno_' + id).parentNode.parentNode);
	DocumentElementById(prefix + 'attachbtn').removeChild(DocumentElementById(prefix + 'attachnew_' + id).parentNode.parentNode);
	DocumentElementById(prefix + 'attachbody').innerHTML == '' && addAttach(prefix);
	DocumentElementById('localimgpreview_' + id) ? document.body.removeChild(DocumentElementById('localimgpreview_' + id)) : null;
}

function delAttach(id) {
	appendAttachDel(id);
	DocumentElementById('attach_' + id).style.display = 'none';
}

function delImgAttach(id) {
	appendAttachDel(id);
	DocumentElementById('image_td_' + id).className = 'imgdeleted';
	DocumentElementById('image_' + id).onclick = null;
	DocumentElementById('image_desc_' + id).disabled = true;
}

function appendAttachDel(id) {
	var input = document.createElement('input');
	input.name = 'attachdel[]';
	input.value = id;
	input.type = 'hidden';
	DocumentElementById('postbox').appendChild(input);
}

function updateAttach(aid) {
	objupdate = DocumentElementById('attachupdate'+aid);
	obj = DocumentElementById('attach' + aid);
	if(!objupdate.innerHTML) {
		obj.style.display = 'none';
		objupdate.innerHTML = '<input type="file" name="attachupdate[paid' + aid + ']"><a href="javascript:;" onclick="updateAttach(' + aid + ')">取消</a>';
	} else {
		obj.style.display = '';
		objupdate.innerHTML = '';
	}
}

function swfHandler(action, type) {
	if(type == 'image') {
		updateImageList(action);
	} else {
		updateAttachList(action);
	}
}

function updateAttachList(action) {
	//if(action != 2) ajaxget('ajax.php?action=attachlist', 'attachlist');
	if(action != 1) switchAttachbutton('attachlist');DocumentElementById('attach_tblheader').style.display = DocumentElementById('attach_notice').style.display = '';
}

function updateImageList(action) {
	//if(action != 2) ajaxget('ajax.php?action=imagelist&pid=' + pid, 'imgattachlist');
	if(action != 1) switchImagebutton('imgattachlist');DocumentElementById('imgattach_notice').style.display = '';
}

function switchButton(btn, btns) {
	DocumentElementById(editorid + '_btn_' + btn).style.display = '';
	DocumentElementById(editorid + '_' + btn).style.display = '';
	DocumentElementById(editorid + '_btn_' + btn).className = 'current';
	for(i = 0;i < btns.length;i++) {
		if(btns[i] != btn) {
			DocumentElementById(editorid + '_' + btns[i]).style.display = 'none';
			DocumentElementById(editorid + '_btn_' + btns[i]).className = '';
		}
	}
}

function uploadWindowstart() {
	DocumentElementById('uploadwindowing').style.visibility = 'visible';
	DocumentElementById('uploadsubmit').disabled = true;
}

function uploadWindowload() {
	DocumentElementById('uploadwindowing').style.visibility = 'hidden';
	DocumentElementById('uploadsubmit').disabled = false;
	var str = DocumentElementById('uploadattachframe').contentWindow.document.body.innerHTML;
	if(str == '') return;
	var arr = str.split('|');
	if(arr[0] == 'DISCUZUPLOAD' && arr[2] == 0) {
		UPLOADWINRECALL(arr[3], arr[5]);
		hideWindow('upload');
	} else {
		showDialog('上传失败:' + STATUSMSG[arr[2]]);
	}
}

function uploadWindow(recall, type) {
	var type = isUndefined(type) ? 'image' : type;
	UPLOADWINRECALL = recall;
	showWindow('upload', 'misc.php?action=upload&fid=' + fid + '&type=' + type, 'get', 0, 1, 0);
}

function updatetradeattach(aid, url, attachurl) {
	DocumentElementById('tradeaid').value = aid;
	DocumentElementById('tradeattach_image').innerHTML = '<img src="' + attachurl + '/' + url + '" class="goodsimg" />';
}
function Editor_ChangeTab(id){
    var a_arr=[];    
    var obj
    obj=document.getElementById('edit_update_tab_url')
    obj.style.display='none';
    obj=document.getElementById('edit_update_tab_list')
    obj.style.display='none';
    obj=document.getElementById('edit_update_tab_upload')
    obj.style.display='none';
    document.getElementById('tab_01').className='none'
    document.getElementById('tab_02').className='none'
    document.getElementById('tab_03').className='none'
    if (id=='edit_update_tab_url')
    {
        document.getElementById('tab_01').className='on'
    }
    if (id=='edit_update_tab_list')
    {
        document.getElementById('tab_02').className='on'
    }
    if (id=='edit_update_tab_upload')
    {
        document.getElementById('tab_03').className='on'
    }
    obj=document.getElementById(id)
    obj.style.display='';
}
function Editor_SubmitLoading(s_formid,s_url){
    var obj=document.getElementById(s_formid)
    var old=obj.action
    obj.action=s_url
    obj.submit();
    obj.action=old
    if (!is_moz){
        Common_OpenLoading();   
    } 
}
function Editor_RefreshPictureList()//刷新图片列表
{
    var o_ajax_request=new AjaxRequest();
    o_ajax_request.setFunction ('RefreshPictureListForEditor');
    o_ajax_request.setPage(S_Root+'include/it_ajax.svr.php');
    o_ajax_request.SendRequest()
}
function Editor_InsertPicture(s_url){
    insertText('<img src="' + s_url + '" border="0" alt="" />', false);
}
function Editor_BulidPhotoList(s_photolist)//接受数据库传回来的图片信息,并构造图片列表
{
	if (s_photolist==''){
		return;		
	}
	var a_photo=s_photolist.split("<1>");
	var obj=document.getElementById('edit_pic_list')	
	obj.innerHTML='';
	for (var i=0;i<a_photo.length;i++){
		var a_photoinfo=a_photo[i].split("<2>");			
		Editor_AddPicture(a_photoinfo[1],a_photoinfo[0])
	}
}
var S_Editor_UploadUrl='';
var N_Editor_FreeSplace=0;
function Editor_BuildUploadVcl(){
	var obj=document.getElementById('edit_update_vcl')
}
function Editor_AddPicture(s_url,n_id){
    var obj=document.getElementById('edit_pic_list')
    var s_html='<div id="picture'+n_id+'"><a href="javascript:;" onclick="Editor_InsertPicture(\''+s_url+'\')"><img src="'+s_url+'" alt="" /></a><a href="javascript:;" title="" onclick="Editor_DelUpLoadPicture('+n_id+')" title="删除图片"><img src="'+S_Root+'images/email_delete.gif" style="height:16px; width:16px"/></a></div>'
    obj.innerHTML=obj.innerHTML+s_html
    //document.getElementById('UpLoadFileBox').innerHTML='<input id="Vcl_UpLoadFile" name="Vcl_UpLoadFile" style="width: 95%" type="file" />';    
}
function Editor_DelUpLoadPicture(n_uid){
    var o_ajax_request=new AjaxRequest();
    o_ajax_request.setFunction ('DelUpLoadPictureForEditor');
    o_ajax_request.PushParameter(n_uid);
    o_ajax_request.setPage(S_Root+'include/it_ajax.svr.php');
    try
    {
        parent.parent.Dialog_Confirm("文章中所使用的图片将消失 ! <br>您真的要删除吗?",function(){Editor_HidePicture(n_uid);o_ajax_request.SendRequest()})
    }           
    catch(e){
        parent.parent.parent.Dialog_Confirm("文章中所使用的图片将消失 ! <br>您真的要删除吗?",function(){Editor_HidePicture(n_uid);o_ajax_request.SendRequest()})
    }  
}
function Editor_SetPhotoFreeSplace(n_splace){
	var flash = document.getElementById("vcl_flash_upload");
	flash.SetVariable('N_FreeSplace',n_splace);	
}
function Editor_HidePicture(n_uid){
    obj=document.getElementById("picture"+n_uid);
    obj.style.display='none'
}
function Editor_AddHeight(){
    if (edit_enable===false){//如果文本编辑框为禁用，那么就不设置事件了
        return 
    }
    obj=document.getElementById('edit_editor');
    var iframe = textobj.parentNode.getElementsByTagName('iframe')[0];
    var height=obj.style.height;
    var height_content=iframe.style.height;
    height=height.replace('px','');
    height_content=height_content.replace('px','');
    height =Number(height)+50
    height_content =Number(height_content)+50
    height_content=height_content+'px'  
    height=height+'px'    
    obj.style.height=height;
    iframe.style.height=height_content;
}
function Editor_SubHeight(n_oldHeight){
    if (edit_enable===false){//如果文本编辑框为禁用，那么就不设置事件了
        return 
    }
    var iframe = textobj.parentNode.getElementsByTagName('iframe')[0];
    obj=document.getElementById('edit_editor');
    var height=obj.style.height;
    var height_content=iframe.style.height;
    height=height.replace('px','');
    height_content=height_content.replace('px','');
    height =Number(height)-50
    height_content =Number(height_content)-50
    if (height<=n_oldHeight){
        height=n_oldHeight
    }
    if (height_content<=n_oldHeight){
        height_content=n_oldHeight
    }
    height=height+'px' 
    height_content=height_content+'px'  
    obj.style.height=height;
    iframe.style.height=height_content;
}

/*
	[Discuz!] (C)2001-2009 Comsenz Inc.
	This is NOT a freeware, use is subject to license terms

	$Id: bbcode.js 20143 2009-09-20 07:08:19Z liuqiang $
*/

var re;

function addslashes(str) {
	return preg_replace(['\\\\', '\\\'', '\\\/', '\\\(', '\\\)', '\\\[', '\\\]', '\\\{', '\\\}', '\\\^', '\\\$', '\\\?', '\\\.', '\\\*', '\\\+', '\\\|'], ['\\\\', '\\\'', '\\/', '\\(', '\\)', '\\[', '\\]', '\\{', '\\}', '\\^', '\\$', '\\?', '\\.', '\\*', '\\+', '\\|'], str);
}

function atag(aoptions, text) {
	if(trim(text) == '') {
		return '';
	}

	href = getoptionvalue('href', aoptions);

	if(href.substr(0, 11) == 'javascript:') {
		return trim(recursion('a', text, 'atag'));
	}

	return '[url=' + href + ']' + trim(recursion('a', text, 'atag')) + '[/url]';
}

function bbcode2html(str) {

	if(str == '') {
		return '';
	}
	if(!fetchCheckbox('bbcodeoff') && allowbbcode) {
		str = str.replace(/\s*\[code\]([\s\S]+?)\[\/code\]\s*/ig, function($1, $2) {return parsecode($2);});
	}
	if(!forumallowhtml || !allowhtml || !fetchCheckbox('htmlon')) {
		str = str.replace(/</g, '&lt;');
		str = str.replace(/>/g, '&gt;');
		if(!fetchCheckbox('parseurloff')) {
			str = parseurl(str, 'html', false);
		}
	}

	if(!fetchCheckbox('smileyoff') && allowsmilies) {
		if(typeof smilies_type == 'object') {
			for(var typeid in smilies_array) {
				for(var page in smilies_array[typeid]) {
					for(var i in smilies_array[typeid][page]) {
						re = new RegExp(preg_quote(smilies_array[typeid][page][i][1]), "g");
						str = str.replace(re, '<img src="./images/smilies/' + smilies_type[typeid][1] + '/' + smilies_array[typeid][page][i][2] + '" border="0" smilieid="' + smilies_array[typeid][page][i][0] + '" alt="' + smilies_array[typeid][page][i][1] + '" />');
					}
				}
			}
		}
	}

	if(!fetchCheckbox('bbcodeoff') && allowbbcode) {
		str= str.replace(/\[url\]\s*((https?|ftp|gopher|news|telnet|rtsp|mms|callto|bctp|ed2k|thunder|synacast){1}:\/\/|www\.)([^\[\"']+?)\s*\[\/url\]/ig, function($1, $2, $3, $4) {return cuturl($2 + $4);});
		str= str.replace(/\[url=((https?|ftp|gopher|news|telnet|rtsp|mms|callto|bctp|ed2k|thunder|synacast){1}:\/\/|www\.|mailto:)([^\[\"']+?)\]([\s\S]+?)\[\/url\]/ig, '<a href="$1$3" target="_blank">$4</a>');
		str= str.replace(/\[email\](.*?)\[\/email\]/ig, '<a href="mailto:$1">$1</a>');
		str= str.replace(/\[email=(.[^\[]*)\](.*?)\[\/email\]/ig, '<a href="mailto:$1" target="_blank">$2</a>');
		str = str.replace(/\[color=([^\[\<]+?)\]/ig, '<font color="$1">');
		str = str.replace(/\[size=(\d+?)\]/ig, '<font size="$1">');
		str = str.replace(/\[size=(\d+(\.\d+)?(px|pt|in|cm|mm|pc|em|ex|%)+?)\]/ig, '<font style="font-size: $1">');
		str = str.replace(/\[font=([^\[\<]+?)\]/ig, '<font face="$1">');
		str = str.replace(/\[align=([^\[\<]+?)\]/ig, '<p align="$1">');
		str = str.replace(/\[p=(\d{1,2}), (\d{1,2}), (left|center|right)\]/ig, '<p style="line-height: $1px; text-indent: $2em; text-align: $3;">');
		str = str.replace(/\[float=([^\[\<]+?)\]/ig, '<br style="clear: both"><span style="float: $1;">');

		re = /\[table(?:=(\d{1,4}%?)(?:,([\(\)%,#\w ]+))?)?\]\s*([\s\S]+?)\s*\[\/table\]/ig;
		for (i = 0; i < 4; i++) {
			str = str.replace(re, function($1, $2, $3, $4) {return parsetable($2, $3, $4);});
		}

		str = preg_replace([
			'\\\[\\\/color\\\]', '\\\[\\\/size\\\]', '\\\[\\\/font\\\]', '\\\[\\\/align\\\]', '\\\[\\\/p\\\]', '\\\[b\\\]', '\\\[\\\/b\\\]',
			'\\\[i\\\]', '\\\[\\\/i\\\]', '\\\[u\\\]', '\\\[\\\/u\\\]', '\\\[s\\\]', '\\\[\\\/s\\\]', '\\\[hr\\\]', '\\\[list\\\]', '\\\[list=1\\\]', '\\\[list=a\\\]',
			'\\\[list=A\\\]', '\\\[\\\*\\\]', '\\\[\\\/list\\\]', '\\\[indent\\\]', '\\\[\\\/indent\\\]', '\\\[\\\/float\\\]'
			], [
			'</font>', '</font>', '</font>', '</p>', '</p>', '<b>', '</b>', '<i>',
			'</i>', '<u>', '</u>', '<strike>', '</strike>', '<hr class="solidline" />', '<ul>', '<ul type=1 class="litype_1">', '<ul type=a class="litype_2">',
			'<ul type=A class="litype_3">', '<li>', '</ul>', '<blockquote>', '</blockquote>', '</span>'
			], str, 'g');
	}

	if(!fetchCheckbox('bbcodeoff')) {
		if(allowimgcode) {
			str = str.replace(/\[localimg=(\d{1,4}),(\d{1,4})\](\d+)\[\/localimg\]/ig, function ($1, $2, $3, $4) {if(DocumentElementById('attachnew_' + $4)) {var src = DocumentElementById('attachnew_' + $4).value; if(src != '') return '<img style="filter:progid:DXImageTransform.Microsoft.AlphaImageLoader(sizingMethod=\'scale\',src=\'' + src + '\');width:' + $2 + ';height=' + $3 + '" src=\'images/common/none.gif\' border="0" aid="attach_' + $4 + '" alt="" />';}});
			str = str.replace(/\[img\]\s*([^\[\<\r\n]+?)\s*\[\/img\]/ig, '<img src="$1" border="0" alt="" />');
			str = str.replace(/\[attachimg\](\d+)\[\/attachimg\]/ig, function ($1, $2) {return '<img src="' + DocumentElementById('image_' + $2).src + '" border="0" aid="attachimg_' + $2 + '" width="' + DocumentElementById('image_' + $2).getAttribute('_width') + '" alt="" />';});
			str = str.replace(/\[img=(\d{1,4})[x|\,](\d{1,4})\]\s*([^\[\<\r\n]+?)\s*\[\/img\]/ig, function ($1, $2, $3, $4) {return '<img' + ($2 > 0 ? ' width="' + $2 + '"' : '') + ($3 > 0 ? ' height="' + $3 + '"' : '') + ' src="' + $4 + '" border="0" alt="" />'});
		} else {
			str = str.replace(/\[img\]\s*([^\[\<\r\n]+?)\s*\[\/img\]/ig, '<a href="$1" target="_blank">$1</a>');
			str = str.replace(/\[img=(\d{1,4})[x|\,](\d{1,4})\]\s*([^\[\<\r\n]+?)\s*\[\/img\]/ig, '<a href="$1" target="_blank">$1</a>');
		}
	}

	for(var i = 0; i <= DISCUZCODE['num']; i++) {
		str = str.replace("[\tDISCUZ_CODE_" + i + "\t]", DISCUZCODE['html'][i]);
	}

	if(!forumallowhtml || !allowhtml || !fetchCheckbox('htmlon')) {
		str = preg_replace(['\t', '   ', '  ', '(\r\n|\n|\r)'], ['&nbsp; &nbsp; &nbsp; &nbsp; ', '&nbsp; &nbsp;', '&nbsp;&nbsp;', '<br />'], str);
	}

	return str;
}

function cuturl(url) {
	var length = 65;
	var urllink = '<a href="' + (url.toLowerCase().substr(0, 4) == 'www.' ? 'http://' + url : url) + '" target="_blank">';
	if(url.length > length) {
		url = url.substr(0, parseInt(length * 0.5)) + ' ... ' + url.substr(url.length - parseInt(length * 0.3));
	}
	urllink += url + '</a>';
	return urllink;
}

function dstag(options, text, tagname) {
	if(trim(text) == '') {
		return '\n';
	}
	var pend = parsestyle(options, '', '');
	var prepend = pend['prepend'];
	var append = pend['append'];
	if(in_array(tagname, ['div', 'p'])) {
		align = getoptionvalue('align', options);
		if(in_array(align, ['left', 'center', 'right'])) {
			prepend = '[align=' + align + ']' + prepend;
			append += '[/align]';
		} else {
			append += '\n';
		}
	}
	return prepend + recursion(tagname, text, 'dstag') + append;
}

function ptag(options, text, tagname) {
	if(trim(text) == '') {
		return '\n';
	} else if(trim(options) == '') {
		return '\n' + text;
	}

	var lineHeight = 30;
	var textIndent = 2;
	var align, re, matches;

	re = /line-height\s?:\s?(\d{1,3})px/ig;
	matches = re.exec(options);
	if(matches != null) {
		lineHeight = matches[1];
	}

	re = /text-indent\s?:\s?(\d{1,3})em/ig;
	matches = re.exec(options);
	if(matches != null) {
		textIndent = matches[1];
	}

	re = /text-align\s?:\s?(left|center|right)/ig;
	matches = re.exec(options);
	if(matches != null) {
		align = matches[1];
	} else {
		align = getoptionvalue('align', options);
	}
	align = in_array(align, ['left', 'center', 'right']) ? align : 'left';

	return '[p=' + lineHeight + ', ' + textIndent + ', ' + align + ']' + text + '[/p]';
}

function fetchCheckbox(cbn) {
	return DocumentElementById(cbn) && DocumentElementById(cbn).checked == true ? 1 : 0;
}

function fetchoptionvalue(option, text) {
	if((position = strpos(text, option)) !== false) {
		delimiter = position + option.length;
		if(text.charAt(delimiter) == '"') {
			delimchar = '"';
		} else if(text.charAt(delimiter) == '\'') {
			delimchar = '\'';
		} else {
			delimchar = ' ';
		}
		delimloc = strpos(text, delimchar, delimiter + 1);
		if(delimloc === false) {
			delimloc = text.length;
		} else if(delimchar == '"' || delimchar == '\'') {
			delimiter++;
		}
		return trim(text.substr(delimiter, delimloc - delimiter));
	} else {
		return '';
	}
}

function fonttag(fontoptions, text) {
	var prepend = '';
	var append = '';
	var tags = new Array();
	tags = {'font' : 'face=', 'size' : 'size=', 'color' : 'color='};
	for(bbcode in tags) {
		optionvalue = fetchoptionvalue(tags[bbcode], fontoptions);
		if(optionvalue) {
			prepend += '[' + bbcode + '=' + optionvalue + ']';
			append = '[/' + bbcode + ']' + append;
		}
	}

	var pend = parsestyle(fontoptions, prepend, append);
	return pend['prepend'] + recursion('font', text, 'fonttag') + pend['append'];
}

function getoptionvalue(option, text) {
	re = new RegExp(option + "(\s+?)?\=(\s+?)?[\"']?(.+?)([\"']|$|>)", "ig");
	var matches = re.exec(text);
	if(matches != null) {
		return trim(matches[3]);
	}
	return '';
}

function html2bbcode(str) {

	if((forumallowhtml && allowhtml && fetchCheckbox('htmlon')) || trim(str) == '') {
		str = str.replace(/<img[^>]+smilieid=(["']?)(\d+)(\1)[^>]*>/ig, function($1, $2, $3) {return smileycode($3);});
		str = str.replace(/<img([^>]*aid=[^>]*)>/ig, function($1, $2) {return imgtag($2);});
		return str;
	}

	str= str.replace(/\s*\[code\]([\s\S]+?)\[\/code\]\s*/ig, function($1, $2) {return codetag($2);});

	str = preg_replace(['<style.*?>[\\\s\\\S]*?<\/style>', '<script.*?>[\\\s\\\S]*?<\/script>', '<noscript.*?>[\\\s\\\S]*?<\/noscript>', '<select.*?>[\s\S]*?<\/select>', '<object.*?>[\s\S]*?<\/object>', '<!--[\\\s\\\S]*?-->', ' on[a-zA-Z]{3,16}\\\s?=\\\s?"[\\\s\\\S]*?"'], '', str);

	str= str.replace(/(\r\n|\n|\r)/ig, '');

	str= trim(str.replace(/&((#(32|127|160|173))|shy|nbsp);/ig, ' '));

	if(!fetchCheckbox('parseurloff')) {
		str = parseurl(str, 'bbcode', false);
	}

	str = str.replace(/<br\s+?style=(["']?)clear: both;?(\1)[^\>]*>/ig, '');
	str = str.replace(/<br[^\>]*>/ig, "\n");

	if(!fetchCheckbox('bbcodeoff') && allowbbcode) {
		str = preg_replace(['<table([^>]*(width|background|background-color|bgcolor)[^>]*)>', '<table[^>]*>', '<tr[^>]*(?:background|background-color|bgcolor)[:=]\\\s*(["\']?)([\(\)%,#\\\w]+)(\\1)[^>]*>', '<tr[^>]*>', '<t[dh]([^>]*(width|colspan|rowspan)[^>]*)>', '<t[dh][^>]*>', '<\/t[dh]>', '<\/tr>', '<\/table>'], [function($1, $2) {return tabletag($2);}, '[table]', function($1, $2, $3) {return '[tr=' + $3 + ']';}, '[tr]', function($1, $2) {return tdtag($2);}, '[td]', '[/td]', '[/tr]', '[/table]'], str);

		str = str.replace(/<h([0-9]+)[^>]*>(.*)<\/h\\1>/ig, "[size=$1]$2[/size]\n\n");
		str = str.replace(/<hr[^>]*>/ig, "[hr]");
		str = str.replace(/<img[^>]+smilieid=(["']?)(\d+)(\1)[^>]*>/ig, function($1, $2, $3) {return smileycode($3);});
		str = str.replace(/<img([^>]*src[^>]*)>/ig, function($1, $2) {return imgtag($2);});
		str = str.replace(/<a\s+?name=(["']?)(.+?)(\1)[\s\S]*?>([\s\S]*?)<\/a>/ig, '$4');

		str = recursion('b', str, 'simpletag', 'b');
		str = recursion('strong', str, 'simpletag', 'b');
		str = recursion('i', str, 'simpletag', 'i');
		str = recursion('em', str, 'simpletag', 'i');
		str = recursion('u', str, 'simpletag', 'u');
		str = recursion('strike', str, 'simpletag', 's');
		str = recursion('a', str, 'atag');
		str = recursion('font', str, 'fonttag');
		str = recursion('blockquote', str, 'simpletag', 'indent');
		str = recursion('ol', str, 'listtag');
		str = recursion('ul', str, 'listtag');
		str = recursion('div', str, 'dstag');
		str = recursion('p', str, 'ptag');
		str = recursion('span', str, 'dstag');
	}

	str = str.replace(/<[\/\!]*?[^<>]*?>/ig, '');

	for(var i = 0; i <= DISCUZCODE['num']; i++) {
		str = str.replace("[\tDISCUZ_CODE_" + i + "\t]", DISCUZCODE['html'][i]);
	}

	return preg_replace(['&nbsp;', '&lt;', '&gt;', '&amp;'], [' ', '<', '>', '&'], str);
}

function htmlspecialchars(str) {
	return preg_replace(['&', '<', '>', '"'], ['&amp;', '&lt;', '&gt;', '&quot;'], str);
}

function imgtag(attributes) {
	var width = '';
	var height = '';

	re = /src=(["']?)([\s\S]*?)(\1)/i;
	var matches = re.exec(attributes);
	if(matches != null) {
		var src = matches[2];
	} else {
		return '';
	}

	re = /width\s?:\s?(\d{1,4})(px)?/ig;
	var matches = re.exec(attributes);
	if(matches != null) {
		width = matches[1];
	}

	re = /height\s?:\s?(\d{1,4})(px)?/ig;
	var matches = re.exec(attributes);
	if(matches != null) {
		height = matches[1];
	}

	if(!width) {
		re = /width=(["']?)(\d+)(\1)/i;
		var matches = re.exec(attributes);
		if(matches != null) {
			width = matches[2];
		}
	}

	if(!height) {
		re = /height=(["']?)(\d+)(\1)/i;
		var matches = re.exec(attributes);
		if(matches != null) {
			height = matches[2];
		}
	}

	re = /aid=(["']?)attach_(\d+)(\1)/i;
	var matches = re.exec(attributes);
	var imgtag = 'img';
	if(matches != null) {
		imgtag = 'localimg';
		src = matches[2];
	}
	re = /aid=(["']?)attachimg_(\d+)(\1)/i;
	var matches = re.exec(attributes);
	if(matches != null) {
		return '[attachimg]' + matches[2] + '[/attachimg]';
	}

	width = width > 0 ? width : 0;
	height = height > 0 ? height : 0;
	return width > 0 || height > 0 ?
		'[' + imgtag + '=' + width + ',' + height + ']' + src + '[/' + imgtag + ']' :
		'[img]' + src + '[/img]';
}

function listtag(listoptions, text, tagname) {
	text = text.replace(/<li>(([\s\S](?!<\/li))*?)(?=<\/?ol|<\/?ul|<li|\[list|\[\/list)/ig, '<li>$1</li>') + (BROWSER.opera ? '</li>' : '');
	text = recursion('li', text, 'litag');
	var opentag = '[list]';
	var listtype = fetchoptionvalue('type=', listoptions);
	listtype = listtype != '' ? listtype : (tagname == 'ol' ? '1' : '');
	if(in_array(listtype, ['1', 'a', 'A'])) {
		opentag = '[list=' + listtype + ']';
	}
	return text ? opentag + recursion(tagname, text, 'listtag') + '[/list]' : '';
}

function litag(listoptions, text) {
	return '[*]' + text.replace(/(\s+)$/g, '');
}

function parsecode(text) {
	DISCUZCODE['num']++;
	DISCUZCODE['html'][DISCUZCODE['num']] = '[code]' + htmlspecialchars(text) + '[/code]';
	return "[\tDISCUZ_CODE_" + DISCUZCODE['num'] + "\t]";
}

function parsestyle(tagoptions, prepend, append) {
	var searchlist = [
		['align', true, 'text-align:\\s*(left|center|right);?', 1],
		['float', true, 'float:\\s*(left|right);?', 1],
		['color', true, '^(?:\\s|)color:\\s*([^;]+);?', 1],
		['font', true, 'font-family:\\s*([^;]+);?', 1],
		['size', true, 'font-size:\\s*(\\d+(\\.\\d+)?(px|pt|in|cm|mm|pc|em|ex|%|));?', 1],
		['b', false, 'font-weight:\\s*(bold);?'],
		['i', false, 'font-style:\\s*(italic);?'],
		['u', false, 'text-decoration:\\s*(underline);?'],
		['s', false, 'text-decoration:\\s*(line-through);?']
	];
	var style = getoptionvalue('style', tagoptions);
	re = /^(?:\s|)color:\s*rgb\((\d+),\s*(\d+),\s*(\d+)\)(;?)/ig;
	style = style.replace(re, function($1, $2, $3, $4, $5) {return("color:#" + parseInt($2).toString(16) + parseInt($3).toString(16) + parseInt($4).toString(16) + $5);});
	var len = searchlist.length;
	for(var i = 0; i < len; i++) {
		re = new RegExp(searchlist[i][2], "ig");
		match = re.exec(style);
		if(match != null) {
			opnvalue = match[searchlist[i][3]];
			prepend += '[' + searchlist[i][0] + (searchlist[i][1] == true ? '=' + opnvalue + ']' : ']');
			append = '[/' + searchlist[i][0] + ']' + append;
		}
	}
	return {'prepend' : prepend, 'append' : append};
}

function parsetable(width, bgcolor, str) {

	if(isUndefined(width)) {
		var width = '';
	} else {
		width = width.substr(width.length - 1, width.length) == '%' ? (width.substr(0, width.length - 1) <= 98 ? width : '98%') : (width <= 560 ? width : '98%');
	}

	str = str.replace(/\[tr(?:=([\(\)%,#\w]+))?\]\s*\[td(?:=(\d{1,2}),(\d{1,2})(?:,(\d{1,4}%?))?)?\]/ig, function($1, $2, $3, $4, $5) {
		return '<tr' + ($2 ? ' style="background: ' + $2 + '"' : '') + '><td' + ($3 ? ' colspan="' + $3 + '"' : '') + ($4 ? ' rowspan="' + $4 + '"' : '') + ($5 ? ' width="' + $5 + '"' : '') + '>';
	});
	str = str.replace(/\[\/td\]\s*\[td(?:=(\d{1,2}),(\d{1,2})(?:,(\d{1,4}%?))?)?\]/ig, function($1, $2, $3, $4) {
		return '</td><td' + ($2 ? ' colspan="' + $2 + '"' : '') + ($3 ? ' rowspan="' + $3 + '"' : '') + ($4 ? ' width="' + $4 + '"' : '') + '>';
	});
	str = str.replace(/\[\/td\]\s*\[\/tr\]/ig, '</td></tr>');

	return '<table ' + (width == '' ? '' : 'width="' + width + '" ') + 'class="t_table"' + (isUndefined(bgcolor) ? '' : ' style="background: ' + bgcolor + '"') + '>' + str + '</table>';
}

function preg_replace(search, replace, str, regswitch) {
	var regswitch = !regswitch ? 'ig' : regswitch;
	var len = search.length;
	for(var i = 0; i < len; i++) {
		re = new RegExp(search[i], regswitch);
		str = str.replace(re, typeof replace == 'string' ? replace : (replace[i] ? replace[i] : replace[0]));
	}
	return str;
}

function preg_quote(str) {
	return (str+'').replace(/([\\\.\+\*\?\[\^\]\$\(\)\{\}\=\!<>\|\:])/g, "\\$1");
}

function recursion(tagname, text, dofunction, extraargs) {
	if(extraargs == null) {
		extraargs = '';
	}
	tagname = tagname.toLowerCase();

	var open_tag = '<' + tagname;
	var open_tag_len = open_tag.length;
	var close_tag = '</' + tagname + '>';
	var close_tag_len = close_tag.length;
	var beginsearchpos = 0;

	do {
		var textlower = text.toLowerCase();
		var tagbegin = textlower.indexOf(open_tag, beginsearchpos);
		if(tagbegin == -1) {
			break;
		}

		var strlen = text.length;

		var inquote = '';
		var found = false;
		var tagnameend = false;
		var optionend = 0;
		var t_char = '';

		for(optionend = tagbegin; optionend <= strlen; optionend++) {
			t_char = text.charAt(optionend);
			if((t_char == '"' || t_char == "'") && inquote == '') {
				inquote = t_char;
			} else if((t_char == '"' || t_char == "'") && inquote == t_char) {
				inquote = '';
			} else if(t_char == '>' && !inquote) {
				found = true;
				break;
			} else if((t_char == '=' || t_char == ' ') && !tagnameend) {
				tagnameend = optionend;
			}
		}

		if(!found) {
			break;
		}
		if(!tagnameend) {
			tagnameend = optionend;
		}

		var offset = optionend - (tagbegin + open_tag_len);
		var tagoptions = text.substr(tagbegin + open_tag_len, offset);
		var acttagname = textlower.substr(tagbegin * 1 + 1, tagnameend - tagbegin - 1);

		if(acttagname != tagname) {
			beginsearchpos = optionend;
			continue;
		}

		var tagend = textlower.indexOf(close_tag, optionend);
		if(tagend == -1) {
			break;
		}

		var nestedopenpos = textlower.indexOf(open_tag, optionend);
		while(nestedopenpos != -1 && tagend != -1) {
			if(nestedopenpos > tagend) {
				break;
			}
			tagend = textlower.indexOf(close_tag, tagend + close_tag_len);
			nestedopenpos = textlower.indexOf(open_tag, nestedopenpos + open_tag_len);
		}

		if(tagend == -1) {
			beginsearchpos = optionend;
			continue;
		}

		var localbegin = optionend + 1;
		var localtext = eval(dofunction)(tagoptions, text.substr(localbegin, tagend - localbegin), tagname, extraargs);

		text = text.substring(0, tagbegin) + localtext + text.substring(tagend + close_tag_len);

		beginsearchpos = tagbegin + localtext.length;

	} while(tagbegin != -1);

	return text;
}

function simpletag(options, text, tagname, parseto) {
	if(trim(text) == '') {
		return '';
	}
	text = recursion(tagname, text, 'simpletag', parseto);
	return '[' + parseto + ']' + text + '[/' + parseto + ']';
}

function smileycode(smileyid) {
	if(typeof smilies_type != 'object') return;
	for(var typeid in smilies_array) {
		for(var page in smilies_array[typeid]) {
			for(var i in smilies_array[typeid][page]) {
				if(smilies_array[typeid][page][i][0] == smileyid) {
					return smilies_array[typeid][page][i][1];
					break;
				}
			}
		}
	}
}

function strpos(haystack, needle, offset) {
	if(isUndefined(offset)) {
		offset = 0;
	}

	index = haystack.toLowerCase().indexOf(needle.toLowerCase(), offset);

	return index == -1 ? false : index;
}

function tabletag(attributes) {
	var width = '';
	re = /width=(["']?)(\d{1,4}%?)(\1)/i;
	var matches = re.exec(attributes);

	if(matches != null) {
		width = matches[2].substr(matches[2].length - 1, matches[2].length) == '%' ?
			(matches[2].substr(0, matches[2].length - 1) <= 98 ? matches[2] : '98%') :
			(matches[2] <= 560 ? matches[2] : '98%');
	} else {
		re = /width\s?:\s?(\d{1,4})([px|%])/ig;
		var matches = re.exec(attributes);
		if(matches != null) {
			width = matches[2] == '%' ? (matches[1] <= 98 ? matches[1] + '%' : '98%') : (matches[1] <= 560 ? matches[1] : '98%');
		}
	}

	var bgcolor = '';
	re = /(?:background|background-color|bgcolor)[:=]\s*(["']?)((rgb\(\d{1,3}%?,\s*\d{1,3}%?,\s*\d{1,3}%?\))|(#[0-9a-fA-F]{3,6})|([a-zA-Z]{1,20}))(\1)/i;
	var matches = re.exec(attributes);
	if(matches != null) {
		bgcolor = matches[2];
		width = width ? width : '98%';
	}

	return bgcolor ? '[table=' + width + ',' + bgcolor + ']' : (width ? '[table=' + width + ']' : '[table]');
}

function tdtag(attributes) {

	var colspan = 1;
	var rowspan = 1;
	var width = '';

	re = /colspan=(["']?)(\d{1,2})(\1)/ig;
	var matches = re.exec(attributes);
	if(matches != null) {
		colspan = matches[2];
	}

	re = /rowspan=(["']?)(\d{1,2})(\1)/ig;
	var matches = re.exec(attributes);
	if(matches != null) {
		rowspan = matches[2];
	}

	re = /width=(["']?)(\d{1,4}%?)(\1)/ig;
	var matches = re.exec(attributes);
	if(matches != null) {
		width = matches[2];
	}

	return in_array(width, ['', '0', '100%']) ?
		(colspan == 1 && rowspan == 1 ? '[td]' : '[td=' + colspan + ',' + rowspan + ']') :
		'[td=' + colspan + ',' + rowspan + ',' + width + ']';
}
var swfobject = function() {
	
	var UNDEF = "undefined",
		OBJECT = "object",
		SHOCKWAVE_FLASH = "Shockwave Flash",
		SHOCKWAVE_FLASH_AX = "ShockwaveFlash.ShockwaveFlash",
		FLASH_MIME_TYPE = "application/x-shockwave-flash",
		EXPRESS_INSTALL_ID = "SWFObjectExprInst",
		
		win = window,
		doc = document,
		nav = navigator,
		
		domLoadFnArr = [],
		regObjArr = [],
		timer = null,
		storedAltContent = null,
		storedAltContentId = null,
		isDomLoaded = false,
		isExpressInstallActive = false;
	
	/* Centralized function for browser feature detection
		- Proprietary feature detection (conditional compiling) is used to detect Internet Explorer's features
		- User agent string detection is only used when no alternative is possible
		- Is executed directly for optimal performance
	*/	
	var ua = function() {
		var w3cdom = typeof doc.getElementById != UNDEF && typeof doc.getElementsByTagName != UNDEF && typeof doc.createElement != UNDEF && typeof doc.appendChild != UNDEF && typeof doc.replaceChild != UNDEF && typeof doc.removeChild != UNDEF && typeof doc.cloneNode != UNDEF,
			playerVersion = [0,0,0],
			d = null;
		if (typeof nav.plugins != UNDEF && typeof nav.plugins[SHOCKWAVE_FLASH] == OBJECT) {
			d = nav.plugins[SHOCKWAVE_FLASH].description;
			if (d) {
				d = d.replace(/^.*\s+(\S+\s+\S+$)/, "$1");
				playerVersion[0] = parseInt(d.replace(/^(.*)\..*$/, "$1"), 10);
				playerVersion[1] = parseInt(d.replace(/^.*\.(.*)\s.*$/, "$1"), 10);
				playerVersion[2] = /r/.test(d) ? parseInt(d.replace(/^.*r(.*)$/, "$1"), 10) : 0;
			}
		}
		else if (typeof win.ActiveXObject != UNDEF) {
			var a = null, fp6Crash = false;
			try {
				a = new ActiveXObject(SHOCKWAVE_FLASH_AX + ".7");
			}
			catch(e) {
				try { 
					a = new ActiveXObject(SHOCKWAVE_FLASH_AX + ".6");
					playerVersion = [6,0,21];
					a.AllowScriptAccess = "always";  // Introduced in fp6.0.47
				}
				catch(e) {
					if (playerVersion[0] == 6) {
						fp6Crash = true;
					}
				}
				if (!fp6Crash) {
					try {
						a = new ActiveXObject(SHOCKWAVE_FLASH_AX);
					}
					catch(e) {}
				}
			}
			if (!fp6Crash && a) { // a will return null when ActiveX is disabled
				try {
					d = a.GetVariable("$version");  // Will crash fp6.0.21/23/29
					if (d) {
						d = d.split(" ")[1].split(",");
						playerVersion = [parseInt(d[0], 10), parseInt(d[1], 10), parseInt(d[2], 10)];
					}
				}
				catch(e) {}
			}
		}
		var u = nav.userAgent.toLowerCase(),
			p = nav.platform.toLowerCase(),
			webkit = /webkit/.test(u) ? parseFloat(u.replace(/^.*webkit\/(\d+(\.\d+)?).*$/, "$1")) : false, // returns either the webkit version or false if not webkit
			ie = false,
			windows = p ? /win/.test(p) : /win/.test(u),
			mac = p ? /mac/.test(p) : /mac/.test(u);
		/*@cc_on
			ie = true;
			@if (@_win32)
				windows = true;
			@elif (@_mac)
				mac = true;
			@end
		@*/
		return { w3cdom:w3cdom, pv:playerVersion, webkit:webkit, ie:ie, win:windows, mac:mac };
	}();

	/* Cross-browser onDomLoad
		- Based on Dean Edwards' solution: http://dean.edwards.name/weblog/2006/06/again/
		- Will fire an event as soon as the DOM of a page is loaded (supported by Gecko based browsers - like Firefox -, IE, Opera9+, Safari)
	*/ 
	var onDomLoad = function() {
		if (!ua.w3cdom) {
			return;
		}
		addDomLoadEvent(main);
		if (ua.ie && ua.win) {
			try {  // Avoid a possible Operation Aborted error
				doc.write("<scr" + "ipt id=__ie_ondomload defer=true src=//:></scr" + "ipt>"); // String is split into pieces to avoid Norton AV to add code that can cause errors 
				var s = getElementById("__ie_ondomload");
				if (s) {
					s.onreadystatechange = function() {
						if (this.readyState == "complete") {
							this.parentNode.removeChild(this);
							callDomLoadFunctions();
						}
					};
				}
			}
			catch(e) {}
		}
		if (ua.webkit && typeof doc.readyState != UNDEF) {
			timer = setInterval(function() { if (/loaded|complete/.test(doc.readyState)) { callDomLoadFunctions(); }}, 10);
		}
		if (typeof doc.addEventListener != UNDEF) {
			doc.addEventListener("DOMContentLoaded", callDomLoadFunctions, null);
		}
		addLoadEvent(callDomLoadFunctions);
	}();
	
	function callDomLoadFunctions() {
		if (isDomLoaded) {
			return;
		}
		if (ua.ie && ua.win) { // Test if we can really add elements to the DOM; we don't want to fire it too early
			var s = createElement("span");
			try { // Avoid a possible Operation Aborted error
				var t = doc.getElementsByTagName("body")[0].appendChild(s);
				t.parentNode.removeChild(t);
			}
			catch (e) {
				return;
			}
		}
		isDomLoaded = true;
		if (timer) {
			clearInterval(timer);
			timer = null;
		}
		var dl = domLoadFnArr.length;
		for (var i = 0; i < dl; i++) {
			domLoadFnArr[i]();
		}
	}
	
	function addDomLoadEvent(fn) {
		if (isDomLoaded) {
			fn();
		}
		else { 
			domLoadFnArr[domLoadFnArr.length] = fn; // Array.push() is only available in IE5.5+
		}
	}
	
	/* Cross-browser onload
		- Based on James Edwards' solution: http://brothercake.com/site/resources/scripts/onload/
		- Will fire an event as soon as a web page including all of its assets are loaded 
	 */
	function addLoadEvent(fn) {
		if (typeof win.addEventListener != UNDEF) {
			win.addEventListener("load", fn, false);
		}
		else if (typeof doc.addEventListener != UNDEF) {
			doc.addEventListener("load", fn, false);
		}
		else if (typeof win.attachEvent != UNDEF) {
			win.attachEvent("onload", fn);
		}
		else if (typeof win.onload == "function") {
			var fnOld = win.onload;
			win.onload = function() {
				fnOld();
				fn();
			};
		}
		else {
			win.onload = fn;
		}
	}
	
	/* Main function
		- Will preferably execute onDomLoad, otherwise onload (as a fallback)
	*/
	function main() { // Static publishing only
		var rl = regObjArr.length;
		for (var i = 0; i < rl; i++) { // For each registered object element
			var id = regObjArr[i].id;
			if (ua.pv[0] > 0) {
				var obj = getElementById(id);
				if (obj) {
					regObjArr[i].width = obj.getAttribute("width") ? obj.getAttribute("width") : "0";
					regObjArr[i].height = obj.getAttribute("height") ? obj.getAttribute("height") : "0";
					if (hasPlayerVersion(regObjArr[i].swfVersion)) { // Flash plug-in version >= Flash content version: Houston, we have a match!
						if (ua.webkit && ua.webkit < 312) { // Older webkit engines ignore the object element's nested param elements
							fixParams(obj);
						}
						setVisibility(id, true);
					}
					else if (regObjArr[i].expressInstall && !isExpressInstallActive && hasPlayerVersion("6.0.65") && (ua.win || ua.mac)) { // Show the Adobe Express Install dialog if set by the web page author and if supported (fp6.0.65+ on Win/Mac OS only)
						showExpressInstall(regObjArr[i]);
					}
					else { // Flash plug-in and Flash content version mismatch: display alternative content instead of Flash content
						displayAltContent(obj);
					}
				}
			}
			else {  // If no fp is installed, we let the object element do its job (show alternative content)
				setVisibility(id, true);
			}
		}
	}
	
	/* Fix nested param elements, which are ignored by older webkit engines
		- This includes Safari up to and including version 1.2.2 on Mac OS 10.3
		- Fall back to the proprietary embed element
	*/
	function fixParams(obj) {
		var nestedObj = obj.getElementsByTagName(OBJECT)[0];
		if (nestedObj) {
			var e = createElement("embed"), a = nestedObj.attributes;
			if (a) {
				var al = a.length;
				for (var i = 0; i < al; i++) {
					if (a[i].nodeName.toLowerCase() == "data") {
						e.setAttribute("src", a[i].nodeValue);
					}
					else {
						e.setAttribute(a[i].nodeName, a[i].nodeValue);
					}
				}
			}
			var c = nestedObj.childNodes;
			if (c) {
				var cl = c.length;
				for (var j = 0; j < cl; j++) {
					if (c[j].nodeType == 1 && c[j].nodeName.toLowerCase() == "param") {
						e.setAttribute(c[j].getAttribute("name"), c[j].getAttribute("value"));
					}
				}
			}
			obj.parentNode.replaceChild(e, obj);

		}
	}
	
	/* Fix hanging audio/video threads and force open sockets and NetConnections to disconnect
		- Occurs when unloading a web page in IE using fp8+ and innerHTML/outerHTML
		- Dynamic publishing only
	*/
	function fixObjectLeaks(id) {
		if (ua.ie && ua.win && hasPlayerVersion("8.0.0")) {
			win.attachEvent("onunload", function () {
				var obj = getElementById(id);
				if (obj) {
					for (var i in obj) {
						if (typeof obj[i] == "function") {
							obj[i] = function() {};
						}
					}
					obj.parentNode.removeChild(obj);
				}
			});
		}
	}
	
	/* Show the Adobe Express Install dialog
		- Reference: http://www.adobe.com/cfusion/knowledgebase/index.cfm?id=6a253b75
	*/
	function showExpressInstall(regObj) {
		isExpressInstallActive = true;
		var obj = getElementById(regObj.id);
		if (obj) {
			if (regObj.altContentId) {
				var ac = getElementById(regObj.altContentId);
				if (ac) {
					storedAltContent = ac;
					storedAltContentId = regObj.altContentId;
				}
			}
			else {
				storedAltContent = abstractAltContent(obj);
			}
			if (!(/%$/.test(regObj.width)) && parseInt(regObj.width, 10) < 310) {
				regObj.width = "310";
			}
			if (!(/%$/.test(regObj.height)) && parseInt(regObj.height, 10) < 137) {
				regObj.height = "137";
			}
			doc.title = doc.title.slice(0, 47) + " - Flash Player Installation";
			var pt = ua.ie && ua.win ? "ActiveX" : "PlugIn",
				dt = doc.title,
				fv = "MMredirectURL=" + win.location + "&MMplayerType=" + pt + "&MMdoctitle=" + dt,
				replaceId = regObj.id;
			// For IE when a SWF is loading (AND: not available in cache) wait for the onload event to fire to remove the original object element
			// In IE you cannot properly cancel a loading SWF file without breaking browser load references, also obj.onreadystatechange doesn't work
			if (ua.ie && ua.win && obj.readyState != 4) {
				var newObj = createElement("div");
				replaceId += "SWFObjectNew";
				newObj.setAttribute("id", replaceId);
				obj.parentNode.insertBefore(newObj, obj); // Insert placeholder div that will be replaced by the object element that loads expressinstall.swf
				obj.style.display = "none";
				win.attachEvent("onload", function() { obj.parentNode.removeChild(obj); });
			}
			createSWF({ data:regObj.expressInstall, id:EXPRESS_INSTALL_ID, width:regObj.width, height:regObj.height }, { flashvars:fv }, replaceId);
		}
	}
	
	/* Functions to abstract and display alternative content
	*/
	function displayAltContent(obj) {
		if (ua.ie && ua.win && obj.readyState != 4) {
			// For IE when a SWF is loading (AND: not available in cache) wait for the onload event to fire to remove the original object element
			// In IE you cannot properly cancel a loading SWF file without breaking browser load references, also obj.onreadystatechange doesn't work
			var el = createElement("div");
			obj.parentNode.insertBefore(el, obj); // Insert placeholder div that will be replaced by the alternative content
			el.parentNode.replaceChild(abstractAltContent(obj), el);
			obj.style.display = "none";
			win.attachEvent("onload", function() { obj.parentNode.removeChild(obj); });
		}
		else {
			obj.parentNode.replaceChild(abstractAltContent(obj), obj);
		}
	}	

	function abstractAltContent(obj) {
		var ac = createElement("div");
		if (ua.win && ua.ie) {
			ac.innerHTML = obj.innerHTML;
		}
		else {
			var nestedObj = obj.getElementsByTagName(OBJECT)[0];
			if (nestedObj) {
				var c = nestedObj.childNodes;
				if (c) {
					var cl = c.length;
					for (var i = 0; i < cl; i++) {
						if (!(c[i].nodeType == 1 && c[i].nodeName.toLowerCase() == "param") && !(c[i].nodeType == 8)) {
							ac.appendChild(c[i].cloneNode(true));
						}
					}
				}
			}
		}
		return ac;
	}
	
	/* Cross-browser dynamic SWF creation
	*/
	function createSWF(attObj, parObj, id) {
		var r, el = getElementById(id);
		if (typeof attObj.id == UNDEF) { // if no 'id' is defined for the object element, it will inherit the 'id' from the alternative content
			attObj.id = id;
		}
		if (ua.ie && ua.win) { // IE, the object element and W3C DOM methods do not combine: fall back to outerHTML
			var att = "";
			for (var i in attObj) {
				if (attObj[i] != Object.prototype[i]) { // Filter out prototype additions from other potential libraries, like Object.prototype.toJSONString = function() {}
					if (i == "data") {
						parObj.movie = attObj[i];
					}
					else if (i.toLowerCase() == "styleclass") { // 'class' is an ECMA4 reserved keyword
						att += ' class="' + attObj[i] + '"';
					}
					else if (i != "classid") {
						att += ' ' + i + '="' + attObj[i] + '"';
					}
				}
			}
			var par = "";
			for (var j in parObj) {
				if (parObj[j] != Object.prototype[j]) { // Filter out prototype additions from other potential libraries
					par += '<param name="' + j + '" value="' + parObj[j] + '" />';
				}
			}
			el.outerHTML = '<object classid="clsid:D27CDB6E-AE6D-11cf-96B8-444553540000"' + att + '>' + par + '</object>';
			fixObjectLeaks(attObj.id); // This bug affects dynamic publishing only
			r = getElementById(attObj.id);	
		}
		else if (ua.webkit && ua.webkit < 312) { // Older webkit engines ignore the object element's nested param elements: fall back to the proprietary embed element
			var e = createElement("embed");
			e.setAttribute("type", FLASH_MIME_TYPE);
			for (var k in attObj) {
				if (attObj[k] != Object.prototype[k]) { // Filter out prototype additions from other potential libraries
					if (k == "data") {
						e.setAttribute("src", attObj[k]);
					}
					else if (k.toLowerCase() == "styleclass") { // 'class' is an ECMA4 reserved keyword
						e.setAttribute("class", attObj[k]);
					}
					else if (k != "classid") { // Filter out IE specific attribute
						e.setAttribute(k, attObj[k]);
					}
				}
			}
			for (var l in parObj) {
				if (parObj[l] != Object.prototype[l]) { // Filter out prototype additions from other potential libraries
					if (l != "movie") { // Filter out IE specific param element
						e.setAttribute(l, parObj[l]);
					}
				}
			}
			el.parentNode.replaceChild(e, el);
			r = e;
		}
		else { // Well-behaving browsers
			var o = createElement(OBJECT);
			o.setAttribute("type", FLASH_MIME_TYPE);
			for (var m in attObj) {
				if (attObj[m] != Object.prototype[m]) { // Filter out prototype additions from other potential libraries
					if (m.toLowerCase() == "styleclass") { // 'class' is an ECMA4 reserved keyword
						o.setAttribute("class", attObj[m]);
					}
					else if (m != "classid") { // Filter out IE specific attribute
						o.setAttribute(m, attObj[m]);
					}
				}
			}
			for (var n in parObj) {
				if (parObj[n] != Object.prototype[n] && n != "movie") { // Filter out prototype additions from other potential libraries and IE specific param element
					createObjParam(o, n, parObj[n]);
				}
			}
			el.parentNode.replaceChild(o, el);
			r = o;
		}
		return r;
	}
	
	function createObjParam(el, pName, pValue) {
		var p = createElement("param");
		p.setAttribute("name", pName);	
		p.setAttribute("value", pValue);
		el.appendChild(p);
	}
	
	function getElementById(id) {
		return doc.getElementById(id);
	}
	
	function createElement(el) {
		return doc.createElement(el);
	}
	
	function hasPlayerVersion(rv) {
		var pv = ua.pv, v = rv.split(".");
		v[0] = parseInt(v[0], 10);
		v[1] = parseInt(v[1], 10);
		v[2] = parseInt(v[2], 10);
		return (pv[0] > v[0] || (pv[0] == v[0] && pv[1] > v[1]) || (pv[0] == v[0] && pv[1] == v[1] && pv[2] >= v[2])) ? true : false;
	}
	
	/* Cross-browser dynamic CSS creation
		- Based on Bobby van der Sluis' solution: http://www.bobbyvandersluis.com/articles/dynamicCSS.php
	*/	
	function createCSS(sel, decl) {
		if (ua.ie && ua.mac) {
			return;
		}
		var h = doc.getElementsByTagName("head")[0], s = createElement("style");
		s.setAttribute("type", "text/css");
		s.setAttribute("media", "screen");
		if (!(ua.ie && ua.win) && typeof doc.createTextNode != UNDEF) {
			s.appendChild(doc.createTextNode(sel + " {" + decl + "}"));
		}
		h.appendChild(s);
		if (ua.ie && ua.win && typeof doc.styleSheets != UNDEF && doc.styleSheets.length > 0) {
			var ls = doc.styleSheets[doc.styleSheets.length - 1];
			if (typeof ls.addRule == OBJECT) {
				ls.addRule(sel, decl);
			}
		}
	}
	
	function setVisibility(id, isVisible) {
		var v = isVisible ? "visible" : "hidden";
		if (isDomLoaded) {
			getElementById(id).style.visibility = v;
		}
		else {
			createCSS("#" + id, "visibility:" + v);
		}
	}
	
	function getTargetVersion(obj) {
	    if (!obj)
	        return 0;
		var c = obj.childNodes;
		var cl = c.length;
		for (var i = 0; i < cl; i++) {
			if (c[i].nodeType == 1 && c[i].nodeName.toLowerCase() == "object") {
			    c = c[i].childNodes;
			    cl = c.length;
			    i = 0;
			}     
			if (c[i].nodeType == 1 && c[i].nodeName.toLowerCase() == "param" && c[i].getAttribute("name") == "swfversion") {
			   return c[i].getAttribute("value"); 
			}
		}
		return 0;
	}
    
	function getExpressInstall(obj) {
	    if (!obj)
	        return "";
		var c = obj.childNodes;
		var cl = c.length;
		for (var i = 0; i < cl; i++) {
			if (c[i].nodeType == 1 && c[i].nodeName.toLowerCase() == "object") {
			    c = c[i].childNodes;
			    cl = c.length;
			    i = 0;
			}     
			if (c[i].nodeType == 1 && c[i].nodeName.toLowerCase() == "param" && c[i].getAttribute("name") == "expressinstall") { 
			    return c[i].getAttribute("value"); 
			}	       
		}
		return "";
	}
    
	return {
		/* Public API
			- Reference: http://code.google.com/p/swfobject/wiki/SWFObject_2_0_documentation
		*/ 
		registerObject: function(objectIdStr, swfVersionStr, xiSwfUrlStr) {
			if (!ua.w3cdom || !objectIdStr) {
				return;
			}
			var obj = document.getElementById(objectIdStr);
			var xi = getExpressInstall(obj);
			var regObj = {};
			regObj.id = objectIdStr;
			regObj.swfVersion = swfVersionStr ? swfVersionStr : getTargetVersion(obj);
			regObj.expressInstall = xiSwfUrlStr ? xiSwfUrlStr : ((xi != "") ? xi : false);
			regObjArr[regObjArr.length] = regObj;
			setVisibility(objectIdStr, false);
		},
		
		getObjectById: function(objectIdStr) {
			var r = null;
			if (ua.w3cdom && isDomLoaded) {
				var o = getElementById(objectIdStr);
				if (o) {
					var n = o.getElementsByTagName(OBJECT)[0];
					if (!n || (n && typeof o.SetVariable != UNDEF)) {
				    	r = o;
					}
					else if (typeof n.SetVariable != UNDEF) {
						r = n;
					}
				}
			}
			return r;
		},
		
		embedSWF: function(swfUrlStr, replaceElemIdStr, widthStr, heightStr, swfVersionStr, xiSwfUrlStr, flashvarsObj, parObj, attObj) {
			if (!ua.w3cdom || !swfUrlStr || !replaceElemIdStr || !widthStr || !heightStr || !swfVersionStr) {
				return;
			}
			widthStr += ""; // Auto-convert to string to make it idiot proof
			heightStr += "";
			if (hasPlayerVersion(swfVersionStr)) {
				setVisibility(replaceElemIdStr, false);
				var att = (typeof attObj == OBJECT) ? attObj : {};
				att.data = swfUrlStr;
				att.width = widthStr;
				att.height = heightStr;
				var par = (typeof parObj == OBJECT) ? parObj : {};
				if (typeof flashvarsObj == OBJECT) {
					for (var i in flashvarsObj) {
						if (flashvarsObj[i] != Object.prototype[i]) { // Filter out prototype additions from other potential libraries
							if (typeof par.flashvars != UNDEF) {
								par.flashvars += "&" + i + "=" + flashvarsObj[i];
							}
							else {
								par.flashvars = i + "=" + flashvarsObj[i];
							}
						}
					}
				}
				addDomLoadEvent(function() {
					createSWF(att, par, replaceElemIdStr);
					if (att.id == replaceElemIdStr) {
						setVisibility(replaceElemIdStr, true);
					}
				});
			}
			else if (xiSwfUrlStr && !isExpressInstallActive && hasPlayerVersion("6.0.65") && (ua.win || ua.mac)) {
				setVisibility(replaceElemIdStr, false);
				addDomLoadEvent(function() {
					var regObj = {};
					regObj.id = regObj.altContentId = replaceElemIdStr;
					regObj.width = widthStr;
					regObj.height = heightStr;
					regObj.expressInstall = xiSwfUrlStr;
					showExpressInstall(regObj);
				});
			}
		},
		
		getFlashPlayerVersion: function() {
			return { major:ua.pv[0], minor:ua.pv[1], release:ua.pv[2] };
		},
		
		hasFlashPlayerVersion:hasPlayerVersion,
		
		createSWF: function(attObj, parObj, replaceElemIdStr) {
			if (ua.w3cdom && isDomLoaded) {
				return createSWF(attObj, parObj, replaceElemIdStr);
			}
			else {
				return undefined;
			}
		},
		
		createCSS: function(sel, decl) {
			if (ua.w3cdom) {
				createCSS(sel, decl);
			}
		},
		
		addDomLoadEvent:addDomLoadEvent,
		
		addLoadEvent:addLoadEvent,
		
		getQueryParamValue: function(param) {
			var q = doc.location.search || doc.location.hash;
			if (param == null) {
				return q;
			}
		 	if(q) {
				var pairs = q.substring(1).split("&");
				for (var i = 0; i < pairs.length; i++) {
					if (pairs[i].substring(0, pairs[i].indexOf("=")) == param) {
						return pairs[i].substring((pairs[i].indexOf("=") + 1));
					}
				}
			}
			return "";
		},
		
		// For internal usage only
		expressInstallCallback: function() {
			if (isExpressInstallActive && storedAltContent) {
				var obj = getElementById(EXPRESS_INSTALL_ID);
				if (obj) {
					obj.parentNode.replaceChild(storedAltContent, obj);
					if (storedAltContentId) {
						setVisibility(storedAltContentId, true);
						if (ua.ie && ua.win) {
							storedAltContent.style.display = "block";
						}
					}
					storedAltContent = null;
					storedAltContentId = null;
					isExpressInstallActive = false;
				}
			} 
		}
		
	};

}();

///////////////////////////////////////////////////////////////////////////////////上传文件////////////////////////////////////////////////////////////////////
function uploadAffixFile(){
    var o_obj=document.getElementById('master_box');
    var a_arr=[];
    a_arr.push('<form method="post" id="dialog_form_affix"')
    a_arr.push('	action="'+S_Root+'include/bn_submit.svr.php?function=UploadAffixFile"')
    a_arr.push('	enctype="multipart/form-data" target="ajax_submit_frame_affix"')
    a_arr.push('	style="width: 100%">')
    a_arr.push('<table style="width:400px;" border="0" cellspacing="0" cellpadding="0">');
    a_arr.push('    <tr>');
    a_arr.push('        <td class="dialog_title" style="width: 380px">');
    a_arr.push('            上传文件');
    a_arr.push('        </td>');
    a_arr.push('        <td>');
    a_arr.push('            <div onmouseover="this.className=\'dialog_closebutton_over\'" class="dialog_closebutton"');
    a_arr.push('                onclick="Common_CloseDialog()" onmouseout="this.className=\'dialog_closebutton\'">');
    a_arr.push('            </div>');
    a_arr.push('       </td>');
    a_arr.push('    </tr>');
    a_arr.push('</table>');
    a_arr.push('<table class="TableBlock" align="center" width="100%">')
    a_arr.push('	<tbody>')
    a_arr.push('		<tr>')
    a_arr.push('			<td class="TableData" nowrap="nowrap" width="80">&nbsp;&nbsp;文件：</td>')
    a_arr.push('			<td class="TableData"><iframe id="upload_file" style="width: 250px;height: 20px;" src="'+S_Root+'include/file_upload.php" marginwidth="0" marginheight="0" frameborder="0" framespacing="0" border="0" scrolling="no"></iframe></td>')
    a_arr.push('		</tr>')
    a_arr.push('		<tr class="TableControl" align="center">')
    a_arr.push('			<td colspan="2" nowrap="nowrap"><input id="Vcl_Submit" value="上传" class="submitButton"')
    a_arr.push('				onclick="uploadAffixTempFile()" type="button" /> &nbsp;&nbsp; <input')
    a_arr.push('				value="取消" class="submitButton" onclick="uploadAffixCancel()"')
    a_arr.push('				type="button" /></td>')
    a_arr.push('		</tr>')
    a_arr.push('	</tbody>')
    a_arr.push('</table>')
    a_arr.push('</form>')
	window.clearInterval(N_Dialog_TimeHandle);
	N_Dialog_Height=350
	N_Dialog_Width=417
	o_obj.style.top='-1000px';
	TimeHandle=window.setInterval(Dialog_SetPosition,30)//开始动画
	o_obj.innerHTML=Dialog_GetBorder(a_arr.join('\n')); 
}
function uploadAffixCancel()
{
    //document.getElementById("upload_file").src="file_upload.php"
   Common_CloseDialog()
}
function uploadAffixTempFile()
{
    document.getElementById("upload_file").contentWindow.uploadStart() 
    document.getElementById("Vcl_Submit").disabled="disabled"
    //document.getElementById("Vcl_KeyWord1").disabled="disabled"
}
function uploadAffixTempFileCallback(s_text)
{
    document.getElementById("Vcl_Submit").disabled=""
    //document.getElementById("Vcl_KeyWord1").disabled=""
    document.getElementById("upload_file").src=S_Root+"include/file_upload.php"
    parent.parent.Dialog_Error(s_text)
}
function uploadAffixSubmit()
{
    //document.getElementById("Vcl_KeyWord").value=document.getElementById("Vcl_KeyWord1").value
    document.getElementById('dialog_form_affix').submit();
}
function uploadAffixSuccessCallback(str)
{
    document.getElementById(S_Ctrlid).value=str
    Common_CloseDialog()
}