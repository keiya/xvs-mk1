XVS.prototype.search = function() {
	var xhrlock = false;
	$.ajaxSetup({ cache:true,async:true });
	function load_next_page() {
		if (XVS.nextPage==0) return false;
		console.log(XVS.currentPage);
		if (xhrlock) return false;
		var next_page = XVS.currentPage + 1;
		xhrlock = true;
		$('<div>').load('/video/search_tag/'+XVS.searchQuery+'/'+next_page,null,function(res,stat){
			xhrlock = false;
			$('#search').append($(this).find('#search').html());
		})
	}
	$(document).ready(function(){
		$(window).scroll(function(){
			if ($(this).scrollTop() / ($(document).height()-$(window).height()) > 0.8) {
				load_next_page();
			}
		});
	});
};
