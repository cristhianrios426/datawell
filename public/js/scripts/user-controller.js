(function(window, $){
	window.selectpicker = function(){
		$('.selectpicker').each(function(){
			var $this = $(this);
			if($.fn.selectpicker && !$this.data('selectpicker')){
				$this.selectpicker();
			}
		});
		var showClients = function(){
			if($('#role_id').val() == 4){
				$('#wrapt-clients').show();
			}else{
				$('#wrapt-clients').hide();
			}
		};
		showClients();
		$('body').on('change', '#role_id', showClients );
	}
	var crud = new window.CRUD('user');
	$('body').on('click', '*[data-create]', function(){
		var $this = $(this);
		crud.setEntity();
		crud.create($('#modal-model .modal-content'))
			.then(function(){
				window.selectpicker();
			});
	});

	$('body').on('click', '[data-edit]', function(){		
		var $this = $(this);
		crud.entity.setId($this.data('edit'));
		crud.edit($('#modal-model .modal-content'))
			.then(function(){
				window.selectpicker();
			});
	});
	$('body').on('click', '*[data-show]', function(){
		var $this = $(this);
		crud.entity.setId($this.data('show'));
		crud.show($('#modal-model .modal-content'));
	});
	$('body').on('click', '*[data-remove]', function(){
		var $this = $(this);
		crud.entity.setId($this.data('remove'));
		crud.delete($('#modal-model .modal-content'))
			.then(function(){
				window.selectpicker();
			});
	});

})(window, jQuery)