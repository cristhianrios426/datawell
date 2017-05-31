@extends('layouts.front')
@section('head')
	<meta name="entity" content="well">
@stop
@section('content')
<div class="container">
	<div class="row">
		<div class="col-xs-3">
			<form action="{{{ url('/') }}}" method="GET">
				<div class="panel panel-default">
					<div class="panel-heading">
						<div class="continer-fluid">
							<div class="row">
								<div class="col-xs-12">
									<div class="pull-left">
										<h4>Servicios a Pozos</h4>
									</div>									
								</div>
							</div>
						</div>
					</div>
					<div class="panel-body">
						<div class="fluid-container">
							<div class="row">
								<div class="col-xs-12">
									<div class="fluid-container">
										<div class="row">
											<div class="col-xs-12 ">
												<div class="form-group form-group-xs">													
										       		<input type="text" name="name" class="form-control" value="" placeholder="Nombre">
										      	</div>
											</div>
											<div class="col-xs-12 ">
												<div class="form-group form-group-xs">
										       		<select name="service_type_id[]" multiple class="selectpicker form-control" title="Tipos de servicio">										       			
										       			@foreach ($serviceTypes as $m)
										       				<option  {{ ( isset($query['service_type_id']) && in_array($m->getKey(), $query['service_type_id']) ? 'selected' : '' ) }} value="{{{ $m->getKey() }}}">{{{ $m->name }}}</option>
										       			@endforeach
										       		</select>
										      	</div>
											</div>
											
											<div class="col-xs-12 ">

												<div class="form-group form-group-xs">
										       		<select  name="country_id" data-value="{{ isset($query['country_id']) ? $query['country_id'] : '' }}" class="form-control selectpicker " title="Pa&iacute;s" select-country >
										       			@foreach ($locations as $location)
										       				<option {{ ( isset($query['country_id']) && $query['country_id'] == $location->getKey() ? 'selected' : '' ) }} value="{{{ $location->getKey() }}}">{{{ $location->name }}}</option>
										       			@endforeach
										       		</select>
										      	</div>
											</div>
											
											<div class="col-xs-12 ">
												<div class="form-group form-group-xs">										       		
										       		<select data-value="{{ isset($query['state_id']) ? $query['state_id'] : '' }}" select-state location-list="location" name="state_id" class="form-control selectpicker " title="Estado/Depart" ></select>
										      	</div>
											</div>
											<div class="col-xs-12 ">
												<div class="form-group form-group-xs">
										       		<select data-value="{{ isset($query['city_id']) ? $query['city_id'] : '' }}" select-city location-list="location"  name="city_id" class="form-control selectpicker " title="Municipio" ></select>
										      	</div>
											</div>
											<div class="col-xs-12 ">
												<div class="form-group form-group-xs">
										       		<select data-none-selected-text="Regiones" data-value="{{ isset($query['area_id'])  ?  json_encode($query['area_id']) : '' }}" name="area_id[]" depends-location location-list="area" multiple  title="Regiones" class=" selectpicker form-control"></select>
										      	</div>
											</div>
											
											<div class="col-xs-12 ">
												<div class="form-group form-group-xs">													
										       		<select title="Campos" name="camp_id[]" data-value="{{ isset($query['camp_id'])  ?  json_encode($query['camp_id']) : '' }}" depends-location location-list="camp" multiple class=" selectpicker form-control"></select>
										      	</div>
											</div>
											<div class="col-xs-12 ">
												<div class="form-group form-group-xs">
										       		<select name="cuenca_id[]" data-value="{{ isset($query['cuenca_id'])  ?  json_encode($query['cuenca_id']) : '' }}" title="Cuencas"  depends-location location-list="cuenca" multiple class=" selectpicker form-control"></select>
										      	</div>
											</div>
											<div class="col-xs-12 ">
												<div class="form-group form-group-xs">													
										       		<select name="operator_id[]" title="Operadores" multiple class="selectpicker form-control">										       			
										       			@foreach ($operators as $m)
										       				<option {{ ( isset($query['operator_id']) && in_array($m->getKey(), $query['operator_id']) ? 'selected' : '' ) }} value="{{{ $m->getKey() }}}">{{{ $m->name }}}</option>
										       			@endforeach
										       		</select>
										      	</div>
											</div>

											<div class="col-xs-12 ">
												<div class="form-group form-group-xs">
										       		<select name="well_type_id[]" title="Tipos de pozo" multiple class="selectpicker form-control">
										       			@foreach ($types as $m)
										       				<option {{ ( isset($query['well_type_id']) && in_array($m->getKey(), $query['well_type_id']) ? 'selected' : '' ) }} value="{{{ $m->getKey() }}}">{{{ $m->name }}}</option>
										       			@endforeach
										       		</select>
										      	</div>
											</div>
											<div class="col-xs-12 ">
												<div class="form-group form-group-xs">
										       		<select title="Profundidad TVD (ft)" name="profundidad_tvd" class="selectpicker form-control">
										       			<option value="">Selecciona</option>
										       			<option {{ (isset($query['profundidad_tvd']) && $query['profundidad_tvd'] == '0,5000' ? 'selected="selected"' : '' ) }} value="0,5000">[0 - 5.000)</option>
										       			<option {{ (isset($query['profundidad_tvd']) && $query['profundidad_tvd'] == '5000,10000' ? 'selected="selected"' : '' ) }} value="5000,10000">[5.000,10.000)</option>
										       			<option {{ (isset($query['profundidad_tvd']) && $query['profundidad_tvd'] == '10000,15000' ? 'selected="selected"' : '' ) }} value="10000,15000">[10.000,15.000)</option>
										       			<option {{ (isset($query['profundidad_tvd']) && $query['profundidad_tvd'] == '15000,20000' ? 'selected="selected"' : '' ) }} value="15000,20000">[15.000,20.000)</option>
										       			<option {{ (isset($query['profundidad_tvd']) && $query['profundidad_tvd'] == '20000,25000' ? 'selected="selected"' : '' ) }} value="20000,25000">[20.000,25.000)</option>
										       			<option {{ (isset($query['profundidad_tvd']) && $query['profundidad_tvd'] == '25000,1000000' ? 'selected="selected"' : '' ) }} value="25000,1000000">[25.000,>)</option>
										       		</select>
										      	</div>
											</div>
											<div class="col-xs-12 ">
												<div class="form-group form-group-xs">
										       		<select name="deviation_id[]" title="Tipos de desviaci&oacute;n" multiple class="selectpicker form-control">
										       			@foreach ($deviations as $m)
										       				<option {{ ( isset($query['deviation_id']) && in_array($m->getKey(), $query['deviation_id']) ? 'selected' : '' ) }} value="{{{ $m->getKey() }}}">{{{ $m->name }}}</option>
										       			@endforeach
										       		</select>
										      	</div>
											</div>										
											<div class="col-xs-12 ">
												<div class="form-group form-group-xs">
										       		<select name="section_id[]" title="Secciones" multiple class="selectpicker form-control">
										       			@foreach ($sections as $m)
										       				<option {{ ( isset($query['section_id']) && in_array($m->getKey(), $query['section_id']) ? 'selected' : '' ) }} value="{{{ $m->getKey() }}}">{{{ $m->name }}}</option>
										       			@endforeach
										       		</select>
										      	</div>
											</div>
										</div>
									</div>
								</div>
								<div class="col-xs-12">
									
								</div>
							</div>
						</div>
					</div>
					<div class="panel-footer text-right">
						<a href="{{{ url('/') }}}" type="submit" class="btn-warning btn-sm btn">Limpiar</a>
						<button type="submit" class="btn-primary btn-sm btn">Buscar</button>
					</div>
				</div>
			</form>
		</div>
		<div class="col-xs-9">
			<div id="map" style="height: 500px;"></div>
		</div>
	</div>	
	
</div>
@stop()
@section('footer')
	<script src="https://maps.googleapis.com/maps/api/js?key=AIzaSyDmYAG8HycDku4aHLFgHOb-cjje9LJLqbA" async defer></script>
	<link rel="stylesheet" href="https://unpkg.com/leaflet@1.0.3/dist/leaflet.css" />
	<script src="https://unpkg.com/leaflet@1.0.3/dist/leaflet.js"></script>
	<script src='https://unpkg.com/leaflet.gridlayer.googlemutant@latest/Leaflet.GoogleMutant.js'></script>
	<link rel="stylesheet" href="{{ asset('vendors/bootstrap-select/dist/css/bootstrap-select.min.css') }}">
	<script src="{{ asset('vendors/bootstrap-select/dist/js/bootstrap-select.min.js') }}"></script>
	<script src="{{ asset('vendors/bootstrap-select/dist/js/i18n/defaults-es_ES.min.js') }}"></script>
	<script src="{{ asset('js/scripts/index-well-controller.js') }}"></script>
	<script src="{{ asset('js/scripts/jquery.well-map.js') }}"></script>
	<script src="{{ asset('vendors/mustache/mustache.min.js') }}"></script>
	<script src="{{ asset('vendors/moment/moment.js') }}"></script>
	<script type="text/javascript" src="//cdn.jsdelivr.net/bootstrap.daterangepicker/2/daterangepicker.js"></script>
	<link rel="stylesheet" type="text/css" href="//cdn.jsdelivr.net/bootstrap.daterangepicker/2/daterangepicker.css" />
	@include('wells.bubble-map-template-home')
	<script>
		var all ={!! $all->toJson() !!}
	</script>
	<script>		
		if(!all.length){
			alert('No se encontraron resultados');
		}
		
		$('#map').wellMap({type: 'google', data: (all && all.length ? all : []), popUpTemplate:$('#poup-template').html() });
		
		setTimeout(function() {
			$('select[select-country]').on('locationSelect.sent', function(){				
				$('select[select-state], select[select-city]').html('');
			});
			$('select[select-state]').on('locationSelect.sent', function(){
				$('select[select-city]').html('');
			});

			$('select[select-state]').on('locationSelect.change', function(){
				var self = this;
				setTimeout(function() {

					$(self).trigger('change');
				}, 100);
			});

			$('select[select-city]').on('locationSelect.change', function(){
				setTimeout(function() {
					$(this).trigger('change');
				}, 100);
			});

			$('select[select-country]').locationSelect({
				initRun: true,
				dependsSelector: 'select[depends-location], select[select-state]'
			});
			$('select[select-state]').locationSelect({
				initRun: false,
				sendNull: false,
				dependsSelector: 'select[depends-location], select[select-city]'
			});

			$('select[select-city]').locationSelect({
				initRun: false,
				sendNull: false,
				dependsSelector: 'select[depends-location]'
			});
		}, 500);
		$('[daterangepicker]').daterangepicker({
				 autoUpdateInput: false,
				locale: {
		      		format: 'YYYY-MM-DD'
		      	},ranges: {
		           '\u00DAltimos 30 Days': [moment().subtract(29, 'days'), moment()],
		           'Este mes': [moment().startOf('month'), moment().endOf('month')],
		           'Ultimo mes': [moment().subtract(1, 'month').startOf('month'), moment().subtract(1, 'month').endOf('month')],
		           'Ultimo a\u00F1o': [moment().startOf('year'), moment()]
		        }
		});
		$('[daterangepicker]').on('apply.daterangepicker', function(ev, picker) {
	      $(this).val(picker.startDate.format('YYYY-MM-DD') + ' - ' + picker.endDate.format('YYYY-MM-DD'));
	    });

	    $('[daterangepicker]').on('cancel.daterangepicker', function(ev, picker) {
	      $(this).val('');
	    });


	</script>
@stop