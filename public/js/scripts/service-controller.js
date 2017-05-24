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
		if($('#save-service').valid()){
			$('#assigned_to').addClass('required');
			$('#select-assigned').modal('show');
			$('#select-assigned').one('hidden.bs.modal', function(){
				$('#assigned_to').removeClass('required');
			});
			var promise = $.ajax({
				url: '/valid-supervisor',
				data:{
					well_id: $('#select-well').val()
				},
				type: 'post'
			});
			window.loading(true);			
			promise
				.then(function(res){
					var options = '<option value="" >Selecciona</option>';
					$.each(res,function(idx, model){						
						options+= '<option value="'+model.id+'" >'+model.name+'</option>';
					});
					$('#select-supervisor').html(options);
					window.loading(false);
				}, function(res){
					window.loading(false);
				});
		}
	})
	$('.selectpicker').selectpicker();
	$('.selectpicker').click(function(){
	   if($(this).val() ==''){ $(this).trigger('change');}
	 });
	window.filterTypes = function(bu){
		var val = $('select[service-type]').eq(0).val();
		$('select[service-type]').find('option').hide();
		$('select[service-type]').find('option[business-unit="'+bu+'"]').show()
		$('select[service-type]').val(val);
		//$('select[service-type]').eq(0).data('selectpicker').refresh();
	}
	$('select[business-unit]').on('change', function(){		
		if($(this).val() != ''){
			window.filterTypes($(this).val());
		}
	});
	setTimeout(function() {
		if($('select[business-unit]').eq(0).val() != ''){
			window.filterTypes($('select[business-unit]').eq(0).val());
		}
	}, 300);


})(window, jQuery);