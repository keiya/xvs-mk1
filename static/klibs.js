/* klibs.js the useful javascript library
 * Licensed under New BSD License
 * edited by Keiya Chinen <keiya_21@yahoo.co.jp>
 */

var klibs = {};

/*
 * searchToHash : URI queries to hash
 * http://www.snapman.net/notes/js-url-query-hash
 * hashOfQuery = klibs.searchToHash()
 */
klibs.searchToHash = function (arg) {
	if (location.search) {
		var search = arg ? arg : location.search.substr(1);
		var qstr = search.split("&");
		var qhash = {};
		for (var i=0; i<qstr.length; i++) {
			var qdata = qstr[i].split("=");
			qhash[qdata[0]] = qdata[1];
		}
		return qhash;
	}
	else {
		return undefined;
	}
}

klibs.objToSearch = function (obj) {
	var search = '';
	for (var key in obj) {
		if (key && obj[key])
		search += key+'='+obj[key]+'&';
	}
	return search;
}

/*
 * loadCookie : returns cookie string
 * 
 * cookiedata = klibs.loadCookie( 'cookiename' )
 */
klibs.loadCookie = function (key) {
	var obj = {};
	var cookies = document.cookie.split('; ');
	var i = 0;
	for (var idx in cookies) {
		var kv = cookies[idx].split('=');
		obj[kv[0]] = kv[1];
		i++;
	}
	if (i == 0)
		return false;

	if (key) {
		if (obj[key])
			return JSON.parse(decodeURIComponent(obj[key]));
		else
			return {};
	}
	else {
		for (var k in obj) {
			if (obj[k])
				try {
					obj[k] = JSON.parse(decodeURIComponent(obj[k]));
				}catch(e){}
			else
				obj[k] = {};
		}
		return obj;
	}
}

/*
 * loadCookie : returns cookie string
 *
 * klibs.saveCookie( 'cookiename','value',expire )
 */
klibs.saveCookie = function (obj,path,expire) {
	if (!path)
		path = '/';
	var kv = '';
	for (var key in obj) {
		kv += encodeURIComponent(key) + "=" + encodeURIComponent(JSON.stringify(obj[key]));
		if (expire) {
			var expireDate = new Date(expire);
			document.cookie = kv + '; expires=' + expireDate.toGMTString() + '; path=' + path;
		}
		else {
			document.cookie = kv + '; path=' + path;
		}
	}
}
klibs.removeCookie = function (name,path){
	if (!path)
		path = '/';
  var expireDate = new Date();
  expireDate.setFullYear(expireDate.getFullYear()-1);
  var setdata = name + "=;expires=Thu, 01-Jan-1970 00:00:01 GMT;max-age=0";
  document.cookie = setdata + '; path=' + path;
}

/*
 * unixtimeToDate : returns Date object
 * http://pc.casey.jp/archives/507
 * unixtime, timezone
 * oDate = klibs.unixtimeToDate( 1261818168 , '+9' )
 * oDate.toString() --> Sun Dec 27 05:06:19 UTC+0900 2009
 */
klibs.unixtimeToDate = function (ut, TZ) {
	var tD = new Date( ut * 1000 );
	tD.setTime( tD.getTime() + (60*60*1000 * TZ) );
	return tD;
}

/*
 * centerizeHorizonal : 
 * jQuery object
 * klibs.centerizeHorizonal( $("div") )
 */
klibs.centerizeHorizonal = function ($obj,$of) {
	var $centerOf = $of ? $of : $('body');
	var scrsize_x = $centerOf.outerWidth();
	var scr_cntr_x = scrsize_x/2;
	var obj_x = $obj.outerWidth();
	var pos_x = scr_cntr_x - obj_x/2;
	
	$obj.css({
		left: pos_x+'px'
	});

	return pos_x;
}

/*
 * centerizeVertical : 
 * jQuery object
 * klibs.centerizeVertical( $("div") )
 */
klibs.centerizeVertical = function ($obj,$of) {
	var $centerOf = $of ? $of : $('body');
	var scrsize_y = $centerOf.outerHeight();
	var scr_cntr_y = scrsize_y/2;
	var obj_y = $obj.outerHeight();
	var pos_y = scr_cntr_y - obj_y/2;
	if (obj_y > scrsize_y)
		return false;
	
	$obj.css({
		top: pos_y+'px'
	});

	return pos_y;
}

klibs.centerizeHorizonalOfVisible = function ($obj) {
	var scrsize_x = document.documentElement.clientWidth;
	var scr_cntr_x = scrsize_x/2;
	var obj_x = $obj.width();
	var pos_x = scr_cntr_x - obj_x/2;
	if (obj_x > scrsize_x)
		return false;
	
	$obj.css({
		left: pos_x+'px'
	});
}


klibs.centerizeVerticalOfVisible = function ($obj) {
	var scrsize_y = document.documentElement.clientHeight;
	var scr_cntr_y = scrsize_y/2;
	var obj_y = $obj.height();
	var pos_y = scr_cntr_y - obj_y/2;
	if (obj_y > scrsize_y)
		return false;
	
	$obj.css({
		top: pos_y+'px'
	});
}


klibs.getVerticalCenter = function ($obj,$of) {
	var $centerOf = $of ? $of : $('body');
	var scrsize_y = $centerOf.width();
	var scr_cntr_y = scrsize_y/2;
	var obj_y = $obj.height();
	var pos_y = scr_cntr_y - obj_y/2;
	
	return pos_y;
}

/*
 * windowResize : 
 * klibs.windowResize( x,y )
 */
klibs.windowResize = function(x,y) {
	window.resizeTo(x,y);
//	window.addEventListener("resize",function(){
	setTimeout(function(){
		var width = klibs.bodyWidth();
		var height = klibs.bodyHeight();

		var deltaX = x - width;
		var deltaY = y - height;
		var targetWindowsizeX = x + deltaX;
		var targetWindowsizeY = y + deltaY;
		window.resizeTo(targetWindowsizeX,targetWindowsizeY);
//		window.removeEventListener("resize",arguments.callee,false);
	},250);
//	},false);
}

klibs.bodyWidth = function() {
	var D = document;
	return Math.max(
		Math.max(D.body.scrollWidth, D.documentElement.scrollWidth),
		Math.max(D.body.offsetWidth, D.documentElement.offsetWidth),
		Math.max(D.body.clientWidth, D.documentElement.clientWidth)
	);
}


klibs.bodyHeight = function() {
	var D = document;
	return Math.max(
		Math.max(D.body.scrollHeight, D.documentElement.scrollHeight),
		Math.max(D.body.offsetHeight, D.documentElement.offsetHeight),
		Math.max(D.body.clientHeight, D.documentElement.clientHeight)
	);
}

klibs.minHeightToScreen = function($obj,$of) {
	var $sizeOf = $of ? $of : $(window);
	var scrsize_y = $sizeOf.outerHeight();
	$obj.css({
		'min-height' : scrsize_y+'px'
	});
	var _scrsize_y = $obj.outerHeight();
	var delta = _scrsize_y - scrsize_y;
	$obj.css({
		'min-height' : scrsize_y - delta+'px'
	});
}
