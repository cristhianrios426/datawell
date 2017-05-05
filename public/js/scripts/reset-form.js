(function(window, $){
	$('#reset-form').sendAjax({
		validate:{
			errorClass: 'has-error'
		}
	});
})(window, jQuery);