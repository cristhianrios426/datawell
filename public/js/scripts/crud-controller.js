(function(window, $){
	var entityName = $('meta[name="entity"]').attr('content');
	window.afterCRUDView = function(res){
		$('.selectpicker').each(function(){
			var $this = $(this);
			if($.fn.selectpicker && !$this.data('selectpicker')){
				$this.selectpicker();
			}
		});
	}
	window.afterCreateView = window.afterEditView = window.afterDeleteView = window.afterCRUDView;
	if(entityName != ''){
		var crud = new window.CRUD(entityName);
		$('body').on('click', '*[data-create]', function(){
			var $this = $(this);
			crud.setEntity();
			crud.create($('#modal-model .modal-content'))
				.then(function(){
					window.afterCreateView();
				});
		});

		$('body').on('click', '[data-edit]', function(){		
			var $this = $(this);
			crud.entity.setId($this.data('edit'));
			crud.edit($('#modal-model .modal-content'))
				.then(function(){
					window.afterEditView();
				});;
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
					window.afterDeleteView();
				});
		});
	}
	

})(window, jQuery)