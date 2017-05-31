@extends('layouts.app')
@section('head')
	<meta name="entity" content="{{{ $entityName }}}">
@stop
@section('content')
<div class="container">
	@include('util.breadcrums.settings',['active'=>ucfirst($entitiesLabel)])
	<div class="row">
		<div class="col-xs-12" style="margin-bottom: 22px">
			<div class="panel panel-default">
				<div class="panel-heading">
					<div class="row">
						<div class="col-xs-12">
							<div class="pull-left">
								<h4>Pozos</h4>	
							</div>
							@can('create', \App\ORM\Well::class)
							<div class="pull-right">
								<a   href="{{{ route($entityName.'.create') }}}" class="btn btn-success">
									<i class="fa fa-plus"  aria-hidden="true"></i> Crear  {{{ $entityLabel }}}
								</a>
							</div>
							@endcan
						</div>
					</div>
				</div>
				<div class="panel-body">
					<div class="map" id="map" style="height: 400px">
				
					</div>
				</div>				
			</div>
		</div>
	</div>
	<div class="row">
		<div class="col-xs-12">
			<form action="">
				<div class="panel panel-default">
					<div class="panel-heading">
						<div class="continer-fluid">
							<div class="row">
								<div class="col-xs-12">
									<div class="pull-left">
										<h4>{{{ 'Filtro de '.ucfirst($entitiesLabel) }}}</h4>
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
											<div class="col-xs-12 col-sm-6  col-md-4">
												<div class="form-group form-group-xs">													
										       		<input type="text" name="name" class="form-control" value="" placeholder="Nombre">
										      	</div>
											</div>
											<div class="col-xs-12 col-sm-6  col-md-4">
												<div class="form-group form-group-xs">
										       		<select name="service_type_id[]" multiple class="selectpicker form-control" title="Tipos de servicio">										       			
										       			@foreach ($serviceTypes as $m)
										       				<option  {{ ( isset($query['service_type_id']) && in_array($m->getKey(), $query['service_type_id']) ? 'selected' : '' ) }} value="{{{ $m->getKey() }}}">{{{ $m->name }}}</option>
										       			@endforeach
										       		</select>
										      	</div>
											</div>
											<div class="col-xs-12 col-sm-6  col-md-4">
												<div class="form-group form-group-xs">
										       		<input type="text" daterangepicker name="ended_at" class="form-control " value="{{{ isset($query['ended_at']) ? $query['ended_at'] : ''}}}" class="" placeholder="Fecha de servicios">
										      	</div>
											</div>
											<div class="col-xs-12 col-sm-6  col-md-4">

												<div class="form-group form-group-xs">
										       		<select  name="country_id" data-value="{{ isset($query['country_id']) ? $query['country_id'] : '' }}" class="form-control selectpicker " title="Pa&iacute;s" select-country >
										       			@foreach ($locations as $location)
										       				<option {{ ( isset($query['country_id']) && $query['country_id'] == $location->getKey() ? 'selected' : '' ) }} value="{{{ $location->getKey() }}}">{{{ $location->name }}}</option>
										       			@endforeach
										       		</select>
										      	</div>
											</div>
											
											<div class="col-xs-12 col-sm-6  col-md-4">
												<div class="form-group form-group-xs">										       		
										       		<select data-value="{{ isset($query['state_id']) ? $query['state_id'] : '' }}" select-state location-list="location" name="state_id" class="form-control selectpicker " title="Estado/Depart" ></select>
										      	</div>
											</div>
											<div class="col-xs-12 col-sm-6  col-md-4">
												<div class="form-group form-group-xs">
										       		<select data-value="{{ isset($query['city_id']) ? $query['city_id'] : '' }}" select-city location-list="location"  name="city_id" class="form-control selectpicker " title="Municipio" ></select>
										      	</div>
											</div>
											<div class="col-xs-12 col-sm-6  col-md-4">
												<div class="form-group form-group-xs">
										       		<select data-none-selected-text="Regiones" data-value="{{ isset($query['area_id'])  ?  json_encode($query['area_id']) : '' }}" name="area_id[]" depends-location location-list="area" multiple  title="Regiones" class=" selectpicker form-control"></select>
										      	</div>
											</div>
											
											<div class="col-xs-12 col-sm-6  col-md-4">
												<div class="form-group form-group-xs">													
										       		<select title="Campos" name="camp_id[]" data-value="{{ isset($query['camp_id'])  ?  json_encode($query['camp_id']) : '' }}" depends-location location-list="camp" multiple class=" selectpicker form-control"></select>
										      	</div>
											</div>
											<div class="col-xs-12 col-sm-6  col-md-4">
												<div class="form-group form-group-xs">
										       		<select name="cuenca_id[]" data-value="{{ isset($query['cuenca_id'])  ?  json_encode($query['cuenca_id']) : '' }}" title="Cuencas"  depends-location location-list="cuenca" multiple class=" selectpicker form-control"></select>
										      	</div>
											</div>
											<div class="col-xs-12 col-sm-6  col-md-4">
												<div class="form-group form-group-xs">													
										       		<select name="operator_id[]" title="Operadores" multiple class="selectpicker form-control">										       			
										       			@foreach ($operators as $m)
										       				<option {{ ( isset($query['operator_id']) && in_array($m->getKey(), $query['operator_id']) ? 'selected' : '' ) }} value="{{{ $m->getKey() }}}">{{{ $m->name }}}</option>
										       			@endforeach
										       		</select>
										      	</div>
											</div>

											<div class="col-xs-12 col-sm-6  col-md-4">
												<div class="form-group form-group-xs">
										       		<select name="well_type_id[]" title="tipos" multiple class="selectpicker form-control">
										       			@foreach ($types as $m)
										       				<option {{ ( isset($query['well_type_id']) && in_array($m->getKey(), $query['well_type_id']) ? 'selected' : '' ) }} value="{{{ $m->getKey() }}}">{{{ $m->name }}}</option>
										       			@endforeach
										       		</select>
										      	</div>
											</div>
											<div class="col-xs-12 col-sm-6  col-md-4">
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
											<div class="col-xs-12 col-sm-6  col-md-4">
												<div class="form-group form-group-xs">
										       		<select name="deviation_id[]" title="Tipos de desviaci&oacute;n" multiple class="selectpicker form-control">
										       			@foreach ($deviations as $m)
										       				<option {{ ( isset($query['deviation_id']) && in_array($m->getKey(), $query['deviation_id']) ? 'selected' : '' ) }} value="{{{ $m->getKey() }}}">{{{ $m->name }}}</option>
										       			@endforeach
										       		</select>
										      	</div>
											</div>										
											<div class="col-xs-12 col-sm-6  col-md-4">
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
						<a href={{{ route('well.index') }}} type="submit" class="btn btn-warning">Limpiar</a>
						<button type="submit" class="btn btn-primary">Buscar</button>
					</div>
				</div>
			</form>
		</div>
	</div>
	
	<div class="row">
		@if($models->count() > 0)
					
			@foreach ($models as $model)
				<div class="col-xs-12 col-md-6">
					<div class="panel panel-info ">
						<div class="panel-heading"><h4>{{{ $model->name }}}</h4></div>
						<div class="panel-body">
							<ul class="list-group">
							  <li class="list-group-item"><strong>Estado:</strong> 
							  	{{ $model->textState() }}						  	
							  </li>
							  <li class="list-group-item"><strong>Tipo de pozo:</strong> {{{ $model->type ? $model->type->name : '' }}} </li>
							  <li class="list-group-item"><strong>Ubicación:</strong> {{{ $model->location ? $model->location->fullName() : '' }}} </li>
							  <li class="list-group-item"><strong>Operador:</strong> {{{ $model->operator ? $model->operator->name : '' }}} </li>
							  <li class="list-group-item"><strong>Regi&oacute;n:</strong> {{{ $model->area ? $model->area->name : '' }}} </li>
							  <li class="list-group-item"><strong>Cuenca:</strong> {{{ $model->cuenca ? $model->cuenca->name : '' }}} </li>
							  <li class="list-group-item"><strong>Campo:</strong> {{{ $model->camp ? $model->camp->name : '' }}} </li>
							  <li class="list-group-item"><strong>Profundidad TVD (ft):</strong> {{{ $model->profundidad_tvd }}} </li>
							</ul>
						</div>
						<div class="panel-footer text-right">							
							<div class="btn-group">
							  <button class="btn btn-primary">Acciones</button>
							  <button data-toggle="dropdown" class="btn btn-primary dropdown-toggle"><span class="caret"></span></button>
							  <ul class="dropdown-menu">
									@can('view', $model)<li><a href="{{{ route($entityName.'.show', ['id'=>$model->id]) }}}"  >Ver detalles</a></li>@endcan
								 	@can('update', $model)<li><a href="{{{ route('service.create',['well_id'=>$model->getKey()]) }}}"  >A&ntilde;adir servicio</a></li>@endcan
									@can('update', $model)<li><a href="{{{ route($entityName.'.edit', ['id'=>$model->id]) }}}"  >Editar</a></li>@endcan
							  </ul>
							</div>
						</div>
					</div>
				</div>
			@endforeach
			<div class="col-xs-12">
				<div class="text-center">
					<div class="inline-block">{{ $models->render() }}</div> 	
				</div>	
			</div>
		@else
			<div class="col-xs-12">
				<div class="panel panel-info">
					<div class="alert alert-primary">
						<h4> No se han encontrado resultados </h4>
					</div>
				</div >
			</div>
		@endif
					
	</div>
</div>
@stop()
@section('footer')
	<link rel="stylesheet" href="https://unpkg.com/leaflet@1.0.3/dist/leaflet.css" />
	<script src="https://unpkg.com/leaflet@1.0.3/dist/leaflet.js"></script>
	<link rel="stylesheet" href="{{ asset('vendors/bootstrap-select/dist/css/bootstrap-select.min.css') }}">
	<script src="{{ asset('vendors/bootstrap-select/dist/js/bootstrap-select.min.js') }}"></script>
	<script src="{{ asset('vendors/bootstrap-select/dist/js/i18n/defaults-es_ES.min.js') }}"></script>
	<script src="{{ asset('js/scripts/index-well-controller.js') }}"></script>
	<script src="{{ asset('js/scripts/jquery.well-map.js') }}"></script>
	<script src="{{ asset('vendors/mustache/mustache.min.js') }}"></script>
	<script src="{{ asset('vendors/moment/moment.js') }}"></script>
	<script type="text/javascript" src="//cdn.jsdelivr.net/bootstrap.daterangepicker/2/daterangepicker.js"></script>
	<link rel="stylesheet" type="text/css" href="//cdn.jsdelivr.net/bootstrap.daterangepicker/2/daterangepicker.css" />
	@include('wells.bubble-map-template')
	<script>
		var all ={!! $all->toJson() !!}
	</script>
	<!--<script src="{{ asset('js/scripts/filter.js') }}"></script>-->
	<script>
		if(!all.length){
			alert('No se encontraron resultados');
		}
		
		$('#map').wellMap({type: 'osm', data: (all && all.length ? all : []), popUpTemplate:$('#poup-template').html() });
		
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
				 opens: 'left',
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