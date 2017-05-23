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
	$('form[form-revision]').sendAjax({

		send:function(){		
			$('#select-assigned').modal('hide');
			var data = this.$form.serialize();
			var url = this.$form.attr('action');
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
	$('form[form-save]').sendAjax({

		send:function(){
			var data = this.$form.serialize();
			var url = this.$form.attr('action');
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
	$('*[assigned-modal]').on('click', function(){		
		if($('#save-well').valid()){
			$('#assigned_to').addClass('required');
			$('#select-assigned').modal('show');
			$('#select-assigned').one('hidden.bs.modal', function(){
				$('#assigned_to').removeClass('required');
			});
		}
	})
	setTimeout(function() {
		$('select[location-ref]').locationSelect({
			run:true,
			dependsSelector:'select[location-dep-ref]'
		});
	}, 500);
	$('*[selectpicker]').selectpicker();
  $(window).keydown(function(event){
    if(event.keyCode == 13) {
      event.preventDefault();
      return false;
    }
  });

})(window, jQuery);

