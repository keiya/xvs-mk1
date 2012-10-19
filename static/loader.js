var XVS = function (method) {
	this.__constructor();
	if (method)
		return this[method]();
}

XVS.prototype = {
	__constructor : function() {
		this.vars = {};
	},
	_optionApplier : function(/*optionName,defaultVal*/) {
		// checkbox loader
		var chkbox_selector = '.opt.chkbox';
		$(chkbox_selector).each(function(){
			var optionName = $(this).attr('name');
			var cookieVal = klibs.loadCookie('opt-chkbox');
			for (var k in cookieVal) {
				var selector = '[name="'+k+'"]';
				var t = {};
				if (cookieVal[k] == 1) {
					$(selector).attr('checked','checked');
				}
				else if (cookieVal[k] == 0) {
					$(selector).removeAttr('checked');
				}
			}
			$(this).click(function(){
				var cookieVal = klibs.loadCookie('opt-chkbox');
				cookieVal[optionName] = $('[name="'+optionName+'"]:checked').length;
				klibs.saveCookie({'opt-chkbox':cookieVal},'/','Tue Jan 1 2030 00:00:00 GMT+0900');
			});
		});
	},
	_filterLoad : function() {
		var filters_selector = '.opt.filter';
		var options = {};
		var _this = this;
		$(filters_selector).each(function(){
			var id = $(this).attr('id');
			var defaultVal = $(this).attr('value');
			var optionName = $(this).attr('name');
			options[optionName] = defaultVal;
			$(this).change(function(){
				var optionName = $(this).attr('name');
				options[optionName] = $(this).val();
				klibs.saveCookie({'opt-filter':options},'/','Tue Jan 1 2030 00:00:00 GMT+0900');
			});
		});

		// load default values
		var cookieVal = klibs.loadCookie('opt-filter');
		for (var k in cookieVal) {
			var selector = '[name="'+k+'"]';
			// default values is overrided by user config
			$(selector).val(cookieVal[k]);
		}
	},
	_optionGet : function(optionName){
		var selector = '[name="'+optionName+'"]';
		return $(selector+':checked').length === 1 ? true : false;
	},
	search : function() {
		var _this = this;
		var xhrlock = false;
		$.ajaxSetup({ cache:true,async:true });
		function openLink() {
			if (_this._optionGet('openAnotherWindow')) {
				$(this).target = '_blank';
				window.open($(this).attr('href'));
				return false;
			}
			else {
				return true;
			}
		}
		function apply_events() {
			var $links = $('a.thumb_box');
			$links.unbind('click',openLink);
			$links.click(openLink);
		}
		function check_scr_position() {
			if ($(window).scrollTop() / ($(document).height()-$(window).height()) > 0.9)
				return true;
			else if (($(document).height()-$(window).height()) == 0)
				return true;
			else return false
		}
		function load_next_page() {
			if (XVS.nextPage==0) return false;
			if (xhrlock) return false;
			var next_page = XVS.currentPage + 1;
			xhrlock = true;
			if (XVS.searchQuery === 0) {
				$('<div>').load('/video/index_ajax/'+next_page,null,function(res,stat){
					xhrlock = false;
					$('#search').append($(this).find('#search').html());
					apply_events();
					if (check_scr_position()) load_next_page();
				})
			}
			else {
				$('<div>').load('/video/search_tag_ajax/'+XVS.searchQuery+'/'+next_page,null,function(res,stat){
					xhrlock = false;
					$('#search').append($(this).find('#search').html());
					apply_events();
					if (check_scr_position()) load_next_page();
				})
			}
		}
		$(document).ready(function(){
			$(window).scroll(function(){
				if (check_scr_position()) load_next_page();
			});
			if (check_scr_position()) {
				load_next_page();
			}
			_this._optionApplier();
			_this._filterLoad();
			var _tmpl = new KTempl({template:'video_minlength'});
			function show_time() {
				var minsecraw = parseInt($('[name="minLength"]').val(),10);
				var minmin = minsecraw / 60;
				var min_splitted = minmin.toFixed(1).split('.');
				//var minsec = parseInt(minsecraw % 60,10);
				//if (minsec < 10) minsec = '0'+minsec;
				$('#timeminlength').html(_tmpl.render({min_int:min_splitted[0],min_float:min_splitted[1]}));
				$('.thumb_box').each(function(){
					if ($(this).attr('data-sec') < minsecraw) {
						$(this).hide();
					}
					else {
						$(this).show();
					}
				});
			}
			function changed() {
				if (xhrlock) return false;
				xhrlock = true;
				$('<div>').load('/video/index_ajax/1',null,function(res,stat){
					xhrlock = false;
					$('#search').html($(this).find('#search').html());
					apply_events();
					if (check_scr_position()) load_next_page();
				});
			}
			$('[name="minLength"]').change(function(){
				show_time();
			});
			$('[name="minLength"]').mouseup(function(){
				changed();
			});
			$('[name="minLength"]').keyup(function(){
				changed();
			});
			show_time();
			apply_events();
		});
	},
	video : function() {
		var _this = this;
		$(document).ready(function(){
			var removeSpm = setInterval(function(){
				if (typeof extClick != "undefined") {
					j = {};
					j.I = {};
					j.I.y = function(){};
					clearInterval(removeSpm);
				}
				if ($('embed').length > 0) {
					$('param[name="allowScriptAccess"]').remove();
					$('embed').attr({'allowscriptaccess':'never'});
				}
			},50);
			$('#player > object').attr({'id':'embed'});
			$('#player > object > embed').attr({'width':'854','height':'480'});
			_this._optionApplier('blackoutOnBlur',1);
			var view_start_date = Math.floor(new Date);
			$(window).focus(function(){
				if (_this._optionGet('blackoutOnBlur')) {
					$('#embed').removeClass('shade');
				}
			});
			$(window).blur(function(){
				if (_this._optionGet('blackoutOnBlur')) {
					$('#embed').addClass('shade');
				}
			});
			$(window).unload(function(){
				var stime = (Math.floor(new Date) - view_start_date) / 1000;
				if (stime > 30) {
					$.ajax({
						url:'/recommend/save_history',
						type:'post',
						data:{'video_id':XVS.videoId,'duration':stime.toFixed(9)},
						async:false,
						success:function(res) {
						}
					});
				}
			});
			function apply_uievent() {
				$('.delete_tag').click(function(){
					var vid = $(this).attr('data-vid');
					var tag = $(this).attr('data-tag');
					var _this = this;
					$.ajax({
						url: '/video/delete_tag',
						type:'post',
						data:{'video_id':vid,'tag':tag},
						beforeSend:function(){$(_this).attr({'disabled':'disabled'});},
						complete:function(){$(_this).removeAttr('disabled');},
						success:function(res) {
							if (res == 'ok') {
								$(_this).parent().remove();
							}
						}
					});
				});
			}
			apply_uievent();

			$('#add_tag').click(function(){
				var _this = this;
				var _li = new KTempl({template:'tag_list'});
				var tag = $('#add_tag_text').val();
				var rendered_li = _li.render({tag:tag,vid:XVS.videoId});
				$.ajax({
					url: '/video/add_tag',
					type:'post',
					data:{'video_id':XVS.videoId,'tag':tag},
					beforeSend:function(){$(_this).attr({'disabled':'disabled'});},
					complete:function(){$(_this).removeAttr('disabled');},
					success:function(res) {
						if (res == 'ok') {
							$('#tags').append(rendered_li);
							apply_uievent();
						}
					}
				});

			});
		});
	}
}
