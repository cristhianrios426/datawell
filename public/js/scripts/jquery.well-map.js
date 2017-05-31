(function(window, $, L){

	$.wellMap = (function(window, $, L){
		var wellMap = function($el, options){
			this.$el = $el;
			this.options = options;
		}

		$.extend(wellMap,{
			defaults: {}
		});
		
		$.extend(wellMap.prototype,{
			boot: function(){
				var self = this;
				var el = this.$el[0];
				if(this.options.type == 'google'){
					var layer = L.gridLayer.googleMutant({
					    type: 'satellite' // valid values are 'roadmap', 'satellite', 'terrain' and 'hybrid'
					});

				}else{
					var osmUrl='http://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png';
					var osmAttrib='Map data © <a href="http://openstreetmap.org">OpenStreetMap</a> contributors';
					var layer = new L.TileLayer(osmUrl, { attribution: osmAttrib});	
				}
				
				var map = L.map(el).setView([4.386951, -72.872222],5);
				map.addLayer(layer);

				this.markers = [];
				this.latlongs = [];
				if(this.options.data && this.options.data.length > 0){
					$.each(this.options.data, function(idx, obj){
						if(obj.lat != ''  && obj.long != ''){							
							var latlong = L.latLng(obj.lat, obj.long);
							var marker = L.marker(latlong);
							var output = Mustache.render(self.options.popUpTemplate, obj);
							marker.bindPopup(output);
							self.markers.push(marker);
							self.latlongs.push(latlong);
							marker.addTo(map);
						}						
					});					
					this.bounds = L.latLngBounds(self.latlongs);
					var rzoom = (map.getBoundsZoom(this.bounds) - 1) ;
					var zoom = rzoom > 5 ? 5 : rzoom;
					map.setView(this.bounds.getCenter(), zoom);
				}

				this.map = map;

			}
		});

		return wellMap;

	})(window, $, L);

	$.fn.wellMap = function(options){
		var options = $.extend($.wellMap.defaults,options);
		$(this).each(function(){
			var $this = $(this);
			var wellMap = new $.wellMap($this, options);
			wellMap.boot();
			$this.data('wellMap', wellMap);
		})
	};

})(window, jQuery, L);