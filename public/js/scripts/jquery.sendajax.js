(function(window, $){
	var sendAjax = function($form, options){
		var options = options || {};
		this.options = options;
		this.$form = $form;
		$.extend(this, options);
		this.boot(options);
	}

	sendAjax.prototype.boot = function(options){
		var self = this;
		if($.fn.validate){
			
			var validate = options.validate ? options.validate : {};
			validate.submitHandler = function(form){
				
				self.send();
				return false;
			}
			self.$form.validate(validate);
		}else{
			self.$form.on('submit', function(){
				self.send();
				return false;
			});
		}
	};
	sendAjax.prototype.send = function(){
		
		var self = this;
		var data = this.$form.serialize();
		var url = this.$form[0].action;
		var method = this.$form[0].method;
		var jqXHR = $.ajax({
			data:data,
			url:url,
			type:method,
			dataType:'json'
		});
		this.response(jqXHR);
		return jqXHR
	}

	sendAjax.prototype.response = function(jqXHR){
		var self = this;
		jqXHR.then(function(data){
			if(typeof data == 'object'){
				self.$form.find('*[alert]').each(function(){
					var $alert = $(this);
					var html = self.htmlMessages(data);						
					if(html){	
						html.append('<a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a>');
						html.appendTo($alert);
					}
				});	
				if(data.redirect){
					var timeout = data.delay || 0;
					setTimeout(function(){
						document.location.href = data.redirect;
					},timeout);
				}else if(data.reload){
					document.location.reload();
				}
			}			
		},function(jqXHR){
			var data = jqXHR.responseJSON || false;
			if(data){
				self.$form.find('*[alert]').each(function(){
					var $alert = $(this);
					var html = self.htmlMessages(data);						
					if(html){	
						html.append('<a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a>');
						html.appendTo($alert);
					}
				});
			}
		});
	}

	sendAjax.prototype.htmlMessages = function(res){
		if(!res.messages){
			return false;
		}
		var messages = res.messages;			
		var type = messages.type ? 'alert-'+messages.type : 'alert-primary';
		var htmlMessages = messages.messages.join('<br/>');
		var $alert = $('<div>').addClass('alert '+type).html(htmlMessages);
		return $alert;
	}

	$.sendAjax = sendAjax;

	$.fn.sendAjax = function(options){
		$(this).each(function(){			
			$(this).data('sendAjax', (new $.sendAjax( $(this), options ) ) );
		})
	};

})(window, jQuery);