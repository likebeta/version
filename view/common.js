$(document).ready(function(){
	$('#navbar li a').each(function(){
		if ($(this).attr("href") == location.href || $(this).attr("href") == location.href.substr(0, location.href.length-1)) {
			$(this).parent().addClass('active');
		}
	});
});