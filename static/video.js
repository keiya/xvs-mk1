XVS.video = function() {
	$(document).ready(function(){
		$('#embed').addClass('shade');
		$(window).focus(function(){
			$('#embed').addClass('shade');
		});
		$(window).blur(function(){
			$('#embed').removeClass('shade');
		});
	});
};
