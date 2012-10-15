/*
 * ktempl template
 * by Keiya Chinen <keiya_21@yahoo.co.jp>
 */
 
var KTempl = function (options) {
	"use strict";
	this._constructor(options);
}

KTempl.prototype = {

	_constructor : function(options) {
	
		options.syntaxOpen  = '{';
		options.syntaxClose = '}';
	
		this.options = options;
	},
	_parse : function(string,object) {
		var text = '';
		for (var idx in object) {
			var re = new RegExp(
				this.options.syntaxOpen +
				idx +
				this.options.syntaxClose
			,'g');
			string = string.replace(re, object[idx] ? object[idx] : '');
		}
		return string;
	},
	oprintf : function(format,object) {
		var text = '';
		if (this._isArray(object)) {
			for (var idx in object) {
				text += this._parse(format,object[idx]);
			}
		}
		else {
			return this._parse(format,object);
		}
		return text;
	},
	render : function(object) {
		var format = $('script[type="text/x-ktempl"]#'+this.options.template).text();
		return this.oprintf(format,object);
	},
	_isArray : function(object) {
		return !(
			!object ||
				(!object.length ||
				object.length == 0) ||
			typeof object !== 'object' ||
			!object.constructor ||
			object.nodeType ||
			object.item
		);
	}
}
