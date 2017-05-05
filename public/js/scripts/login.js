(function(window, $){
	$('#login-form').sendAjax({
		validate:{
			errorClass: 'has-error'
		}
	});
})(window, jQuery);