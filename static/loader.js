var XVS = function (method) {
	return this[method]();
}

XVS.prototype = {
	search : function() {
		var xhrlock = false;
		$.ajaxSetup({ cache:true,async:true });
		function load_next_page() {
			if (XVS.nextPage==0) return false;
			if (xhrlock) return false;
			var next_page = XVS.currentPage + 1;
			xhrlock = true;
			$('<div>').load('/video/search_tag_ajax/'+XVS.searchQuery+'/'+next_page,null,function(res,stat){
				xhrlock = false;
				$('#search').append($(this).find('#search').html());
			})
		}
		$(document).ready(function(){
			$(window).scroll(function(){
				if ($(this).scrollTop() / ($(document).height()-$(window).height()) > 0.9) {
					load_next_page();
				}
			});
		});
	},
	video : function() {
		$(document).ready(function(){
			$('#player > object').attr({'id':'embed'});
			$('#player > object > embed').attr({'width':'854','height':'480'});
			var view_start_date = Math.floor(new Date);
			$(window).focus(function(){
				$('#embed').removeClass('shade');
			});
			$(window).blur(function(){
				$('#embed').addClass('shade');
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
