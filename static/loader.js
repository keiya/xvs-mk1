var XVS = function (method) {
	if (method)
		return this[method]();
}

XVS.prototype = {
	_optionApplier : function(optionName,defaultVal) {
		var selector = '#opt-'+optionName;
		var cookieVal = klibs.loadCookie(optionName);
		var t = {};
		if (cookieVal == 1) {
			$(selector).attr('checked','checked');
		}
		else if (cookieVal == 0) {
			$(selector).removeAttr('checked');
		}
		else {
			t[optionName] = defaultVal;
			klibs.saveCookie(t,'/','Tue Jan 1 2030 00:00:00 GMT+0900');
		}
		$(selector).click(function(){
			t[optionName] = $(selector+':checked').length;
			klibs.saveCookie(t,'/','Tue Jan 1 2030 00:00:00 GMT+0900');
		});
	},
	_optionGet : function(optionName){
		var selector = '#opt-'+optionName;
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
				})
			}
			else {
				$('<div>').load('/video/search_tag_ajax/'+XVS.searchQuery+'/'+next_page,null,function(res,stat){
					xhrlock = false;
					$('#search').append($(this).find('#search').html());
					apply_events();
				})
			}
		}
		$(document).ready(function(){
			$(window).scroll(function(){
				if ($(this).scrollTop() / ($(document).height()-$(window).height()) > 0.9) {
					load_next_page();
				}
			});
			_this._optionApplier('openAnotherWindow',1);
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
