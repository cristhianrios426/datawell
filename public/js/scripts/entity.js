(function(window, $){

	window.Entity = function(entity, attrs){
		this.attr = new Object();
		this.rootURL = window.URL+'/'+entity;
		if(attrs){
			this.set(attrs);
		}
	}
	window.Entity.prototype.set = function(ob){
		$.extend(this.attr, ob);
	}
	window.Entity.prototype.setId = function(id){
		this.attr.id = id;
	}	
	window.Entity.prototype.index = function(conf){
		var self = this;
		var p = $.ajax($.extend({
			dataType: 'json',
			url: self.rootURL
		}), conf);
		return p;
	}
	window.Entity.prototype.create = function(conf){
		var self = this;
		var c = $.extend({
			dataType: 'html',
			url: self.rootURL+'/create'
		},conf);
		var p = $.ajax(c);
		return p;
	}

	window.Entity.prototype.edit = function(conf){
		var self = this;
		var url = self.rootURL+'/'+self.attr.id+'/edit';
		var c = $.extend({
			dataType: 'html',
			url: url
		},conf);
		var p = $.ajax(c);
		return p;
	}
	window.Entity.prototype.show = function(conf){
		var self = this;
		var p = $.ajax($.extend({
			dataType: 'html',
			url: self.rootURL+'/'+self.attr.id
		},conf));
		return p;
	}
	window.Entity.prototype.delete = function(conf){
		var self = this;
		var p = $.ajax($.extend({
			dataType: 'html',
			type:'DELETE',
			url: self.rootURL+'/'+self.attr.id
		}, conf));
		return p;
	}
	window.Entity.prototype.fetch = function(conf){
		var self = this;
		var promise = $.ajax($.extend({
			dataType: 'json',
			url: self.rootURL+'/'+self.attr.id
		},conf));
		promise
			.then(function(data){
				$.extend(self.attr,data);
			});
		return p;
	}

	window.Entity.prototype.save = function(conf){
		var self = this;
		var method =  (this.attr.id) ? 'PUT' : 'POST';
		var url = (this.attr.id) ? self.rootURL+'/'+self.attr.id : self.rootURL;
		var p = $.ajax($.extend({
			type:method,
			dataType: 'json',
			url: url
		},conf));
		return p;
	}

	window.Entity.prototype.destroy = function(conf){
		var self = this;
		var p = $.ajax($.extend({
			dataType: 'json',
			type:'DELETE',
			url: self.rootURL+'/'+self.attr.id
		}, conf));
		return p;
	}

	/////////////////////////////////////////////////////////////////////

	window.CRUD = function(entityName){
		this.entityName = entityName;
		this.entity = new Entity(entityName);
	};

	

	window.CRUD.prototype.setEntity = function(entity){
		this.entity = entity || new window.Entity(this.entityName);
	}

	window.CRUD.prototype.edit = function($element){
		var deferred = $.Deferred();
		var self = this;
		window.loading(true);
		var jqXHR = this.entity.edit()
		jqXHR.then(function(html){
				$element.html(html);
				self.setView($element);
				window.loading(false);				
				deferred.resolve();
			}, function(){
				if(jqXHR.status !=  500) {$element.html(jqXHR.responseText);}
				deferred.reject(jqXHR.responseText);
				window.loading(false);		
			});
		return deferred.promise();
	};

	window.CRUD.prototype.create = function($element, config){
		var deferred = $.Deferred();
		var config = config || {};
		var self = this;
		window.loading(true);
		var jqXHR = this.entity.create()
		jqXHR.then(function(html){
				$element.html(html);
				self.setView($element);
				window.loading(false);				
				deferred.resolve();
			}, function(){
				if(jqXHR.status !=  500) {$element.html(jqXHR.responseText);}
				deferred.reject(jqXHR.responseText);
				window.loading(false);		
			});
		return deferred.promise();
	};

	window.CRUD.prototype.show = function($element){
		var deferred = $.Deferred();
		var self = this;
		window.loading(true);
		this.entity.show()
			.then(function(html){
				$element.html(html);
				self.setView($element);
				window.loading(false);				
				deferred.resolve();
			}, function(){
				window.loading(false);
			});
		return deferred.promise();
	};

	window.CRUD.prototype.delete = function($element){
		var deferred = $.Deferred();
		var self = this;
		window.loading(true);
		var jqXHR = this.entity.delete();
		jqXHR
			.then(function(html){
				$element.html(html);
				self.setView($element,{'method':'destroy'});
				window.loading(false);				
				deferred.resolve();
			}, function(){
				if(jqXHR.status !=  500) {$element.html(jqXHR.responseText);}
				window.loading(false);
			});
		return deferred.promise();
	};

	window.CRUD.prototype.save = function(data){
		var deferred = $.Deferred();
		var self = this;
		window.loading(true);
		this.entity.save({data:data})
			.then(function(){
				window.loading(false);
				deferred.resolve();
			}, function(){
				window.loading(false);		
			});
		return deferred.promise();
	};

	window.CRUD.prototype.htmlMessages = function(res){
		if(!res.messages){
			return false;
		}
		var messages = res.messages;			
		var type = messages.type ? 'alert-'+messages.type : 'alert-primary';
		var htmlMessages = messages.messages.join('<br/>');
		var $alert = $('<div>').addClass('alert '+type).html(htmlMessages);
		return $alert;
	}
	window.CRUD.prototype.setView = function($element,options){
		options = options || {};
		var self = this;
		var send = function($form){
			var data = $form.serialize();
			if(options.method ){
				var promise = self.entity[options.method]();
			}else{
				var promise = self.entity.save({
					data:data,
					dataType: 'json'
				});
			}
			window.loading(true);
			promise
				.then(function(data){
					$element.find('*[alert]').each(function(){
						var $alert = $(this);						
						var html = self.htmlMessages(data);
						if(html){
							html.append('<a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a>');
							html.appendTo($alert);
						}
					});
					document.location.reload();
					window.loading(false);
				}, function(xhr){
					var data = xhr.responseJSON;					
					$element.find('*[alert]').each(function(){
						var $alert = $(this);
						var html = self.htmlMessages(data);						
						if(html){	
							html.append('<a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a>');
							html.appendTo($alert);

						}
					});
					window.loading(false);
				});
		};

		$element.find('*[form-send]').each(function(){
			var $this = $(this);
			if($.fn.validate){
				$this.validate({
					submitHandler: function(){
						send($this);
						return false;
					}
				});
			}else{
				$this.on('submit', function(){
					send($this);
					return false;
				});
			}
		});
	}

	

})(window, jQuery)