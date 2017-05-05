(function(window, $){
	function nano(template, data) {
	  return template.replace(/\{([\w\.]*)\}/g, function(str, key) {
	    var keys = key.split("."), v = data[keys.shift()];
	    for (var i = 0, l = keys.length; i < l; i++) v = v[keys[i]];
	    return (typeof v !== "undefined" && v !== null) ? v : "";
	  });
	}

	$.fn.datawellUploader = function(options){
		$(this).each(function(){
			var $this = $(this);
			var config = {
				url: window.URL+'/upload-file',
				dataType: 'json'
			};
			$this.fileupload(config);
			var newFile = function(data){
				var t = nano(options.template, {id:$.fn.datawellUploader.unique()});
				var $el  = $(t);
				data.file = data.files[0];
				$el.find('[data-name]').text(data.file.name);
				$el.find('[data-loading]').show();
				var remove = function(){				
					var cofirm = window.confirm('Desea eliminar el archivo?');
					if(!cofirm){
						return false;
					}
					data.jqXHR.abort();
	            	$el.remove();
	            	return false;
				}

				$el.find('[data-remove]').on('click', remove);

				data.sendProgress =  function(p){
					$el.find('[data-progress]').text(p);
				}

				data.uploadDefer = $.Deferred();
				data.uploadDefer.promise()
					.then(function(data){
						var file = data.result.file;
						$el.find('[data-remove]').off('click', remove);
						var remove = function(data){

							var cofirm = window.confirm('Desea eliminar el archivo?');
							if(!cofirm){
								return false;
							}
							
							$.ajax({
								type:'DELETE',
								url: file.deleteUrl
							});
							$el.remove();
						};
						$el.find('[data-remove]').on('click', remove);
						$el.find('[data-loading]').hide();
						$el.find('[data-progress]').hide();
						$el.find('[data-servername]').val(file.name);
						$el.find('[data-clientname]').val(file.originalName);
						$el.find('[data-url]').attr( 'href', file.url);
					});
				data.$el = $el;
				$el.appendTo(options.list);
				return $el;
			}
			$this.on('fileuploadadd', function(e, data){
				var file = data.files[0];
			    var str = file.name;
		    	var patt = new RegExp(/(\.|\/)(jpg|jpeg|png|gif|pdf|zip|doc|docx|xls|xlsx|ppt|pptx)$/i);
		        var res = patt.test(str);
		        if(!res){
		            alert('tipo de archivo no permitido');
		            data.jqXHR.abort();
		            return false;
		        }
		        newFile(data);
			});

			$this.on('fileuploadprogress', function(e, data){
		        var progress = parseInt(data.loaded / data.total * 100, 10);
		        data.sendProgress( progress + '%');
			});

			$this.on('fileuploaddone', function(e, data){
				data.uploadDefer.resolve(data);
			});
			
		});
	};
	$.fn.datawellUploader._unique = 0;
	$.fn.datawellUploader.unique = function(){
		var r = $.fn.datawellUploader._unique;
		$.fn.datawellUploader._unique = $.fn.datawellUploader._unique +1;
		return r;
	};

})(window, jQuery);