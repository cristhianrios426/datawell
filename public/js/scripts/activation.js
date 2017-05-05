(function(window, $){
	$('#activation-form').sendAjax({
		validate:{
			rules:{
				password_confirmation:{
					equalTo:'#password'
				}
			}
		}
	});
})(window, jQuery)