$.ajaxSetup({
    headers: {
        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
    }
});

$(document).ajaxComplete(function(r,xhr) {
	xhr.then(
		function(){}, 
		function(){
			if(xhr.status == 401 ||  xhr.status == 403){
		  		alert('unauthorized');
		  		document.location.href = URL;
		  	}else if(xhr.status == 500){
		  		alert('unexpected error');
		  		window.loading(false);
		  	}else if(xhr.status == 550 ){
		  		alert('Missing token');
		  		window.location.reload();
		  	}
		});
  
});


window.loading = function(bool){
	if(bool){
		$('[loader]').addClass('init-loading');
		setTimeout(function(){
			$('[loader]').addClass('loading');
		},100);
	}else{
		$('[loader]').removeClass('loading');
		setTimeout(function(){
			$('[loader]').removeClass('init-loading');
		},100);
	}
};

$.getLocations = function(parent_id, list){
	var jqXHR = $.ajax({
		url: '/location-select',
		data:{list: list, parent_id:parent_id},
		type: 'POST'
	});
	return jqXHR;
};

$.fn.locationsOptions = function(locations){
		var locationListAttr = 'location-list';
		$(this).each(function(){			
			var $this = $(this);
			var listName = $this.attr(locationListAttr);			
			var value = $this.val();
			if(locations[listName]){
				var options = '<option value="" >Selecciona</option>';
				$.each(locations[listName],function(idx, model){
					
					options+= '<option value="'+model.id+'" >'+model.name+'</option>';
				});
			}else{
				var options = '<option value="" >No hay opciones válidas disponibles</option>';
			}
			$this.html(options);
			$this.val(value);
			if($this.data('selectpicker')){
				$this.data('selectpicker').refresh();
			}
		});			
};

$.fn.locationSelect = function(options){
	var options = $.extend(true, {}, $.fn.locationSelect.defaults, options);
	$(this).each(function(){
		
		var $select = $(this);
		var run = function(){		
			var locationListAttr = 'location-list';
			var list = [];			
			$(options.dependsSelector).each(function(){
				var $this = $(this);
				list.push($this.attr(locationListAttr));
			});
			window.loading(true);
			$select.trigger('locationSelect.sent');
			var promise = $.getLocations($select.val(), list);
			promise
				.then(function(list){
					$select.trigger('locationSelect.resolve');
					$(options.dependsSelector).locationsOptions(list);
					$select.trigger('locationSelect.rendered');
					window.loading(false);
				}, function(){
					$select.trigger('locationSelect.reject');
					window.loading(false);
				});			
		}
		$select.on('change', function(){
			run();
		});
		if(options.initRun){
			run();	
		}
	});	
};

$.fn.locationSelect.defaults = {
	dependsSelector : 'select[select-depends]',
	initRun: true
};

(function($){
	$(document).ready(function(){
		$('body').on('click', 'ul.dropdown-menu [data-toggle=dropdown]', function(event) {
			event.preventDefault(); 
			event.stopPropagation(); 
			$(this).parent().siblings().removeClass('open');
			$(this).parent().toggleClass('open');
		});
		
        
		$('body').on('click', '[data-toggle="collapse"]', function() {
		    $('.glyphicon.glyphicon-chevron-right, .glyphicon.glyphicon-chevron-down', this)
		      .toggleClass('glyphicon-chevron-right')
		      .toggleClass('glyphicon-chevron-down');
		});

		$('#contact-form').sendAjax();
	});
})($);
