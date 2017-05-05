(function(window, $){
	
	$('body').on('change','select[select-unit]', function(){
		var $this = $(this);
		if($this.val() == 'new'){
			$('*[container-select-unit]').hide();
			$('*[container-new-unit]').show();
		}
	});
	$('body').on('click','*[cancel-new-unit]', function(){
		$('select[select-unit]').val('');
		$('*[container-select-unit]').show();
		$('*[container-new-unit]').hide();
		
	});

})(window, jQuery);