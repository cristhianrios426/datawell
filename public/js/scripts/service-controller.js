(function(window, $){
	$('*[data-uploader]').datawellUploader({
		template: $('#template-file')[0].innerHTML,
		list: $('#list-files')
	});
	$('*[data-old-attachment]').each(function(){
		var $this = $(this);
		$this.on('click', '*[data-remove]', function(){
			var cofirm = window.confirm('Desea eliminar el archivo?');
			if(!cofirm){
				return false;
			}
			$this.hide();
			$this.find('[data-removed]').val(1);
			return false;

		});

	});
	$('form').sendAjax({
		send:function(){		
			
			var data = this.$form.serialize();
			var url = this.$form[0].action;
			var method = this.$form.attr('method');
			var jqXHR = $.ajax({
				data:data,
				url:url,
				method:method,
				dataType:'json'
			});
			window.loading(true);
			jqXHR
				.then(function(){window.loading(false);}, function(){window.loading(false);});
			this.response(jqXHR);
			return jqXHR
		}
	});
	$('.selectpicker').selectpicker();
	$('.selectpicker').click(function(){
	   if($(this).val() ==''){ $(this).trigger('change');}
	 });
})(window, jQuery);