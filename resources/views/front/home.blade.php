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
										       		<select name="id_well_type[]" multiple class="selectpicker form-control" title="Tipos de servicio">
										       			
										       			@foreach ($serviceTypes as $m)
										       				<option  {{ ( isset($query['id_well_type']) && in_array($m->getKey(), $query['id_well_type']) ? 'selected' : '' ) }} value="{{{ $m->getKey() }}}">{{{ $m->name }}}</option>
										       			@endforeach
										       		</select>
										      	</div>
											</div>
											<div class="col-xs-12 ">
												<div class="form-group form-group-xs">													
										       		<select name="country" class="selectpicker form-control">
										       			<option value="" {{ !isset($query['id_country']) ? 'selected' : '' }} >Pa&iacute;s</option>
										       			<option value=""></option>
										       		</select>
										      	</div>
											</div>
											<div class="col-xs-12 ">
												<div class="form-group form-group-xs">													
										       		<select name="id_state" class=" selectpicker form-control">
														<option  >Estado/Depart/Provincia</option>
										       			<option value=""></option>
										       		</select>
										      	</div>
											</div>
											<div class="col-xs-12 ">
												<div class="form-group form-group-xs">
										       		<select name="id_city" class=" selectpicker form-control">
										       			<option value="">Municipio</option>
										       		</select>
										      	</div>
											</div>
											<div class="col-xs-12 ">
												<div class="form-group form-group-xs">
										       		<select name="id_area[]" multiple class=" selectpicker form-control" title="Región">
										       			
										       			@foreach ($areas as $m)
										       				<option  {{ ( isset($query['id_area']) && in_array($m->getKey(), $query['id_area']) ? 'selected' : '' ) }} value="{{{ $m->getKey() }}}">{{{ $m->name }}}</option>
										       			@endforeach
										       		</select>
										      	</div>
											</div>
											<div class="col-xs-12 ">
												<div class="form-group form-group-xs">
										       		<select name="id_cuenca[]" multiple class=" selectpicker form-control"  title="Cuenca">
										       			@foreach ($cuencas as $m)
										       				<option {{ ( isset($query['id_cuenca']) && in_array($m->getKey(), $query['id_cuenca']) ? 'selected' : '' ) }} value="{{{ $m->getKey() }}}">{{{ $m->name }}}</option>
										       			@endforeach
										       		</select>
										      	</div>
											</div>
											<div class="col-xs-12 ">
												<div class="form-group form-group-xs">
													
										       		<select name="id_camp[]" multiple class=" selectpicker form-control"  title="Campo">
										       			
										       			@foreach ($camps as $m)
										       				<option value="{{{ $m->getKey() }}}">{{{ $m->name }}}</option>
										       			@endforeach
										       		</select>
										      	</div>
											</div>
											<div class="col-xs-12 ">
												<div class="form-group form-group-xs">													
										       		<select name="id_operator[]" multiple class="selectpicker form-control" title="Operador">
										       			@foreach ($operators as $m)
										       				<option {{ ( isset($query['id_operator']) && in_array($m->getKey(), $query['id_operator']) ? 'selected' : '' ) }} value="{{{ $m->getKey() }}}">{{{ $m->name }}}</option>
										       			@endforeach
										       		</select>
										      	</div>
											</div>

											<div class="col-xs-12 ">
												<div class="form-group form-group-xs">
										       		<select name="id_type[]" multiple class="selectpicker form-control" title="Tipo de pozo">
										       			
										       			@foreach ($types as $m)
										       				<option {{ ( isset($query['id_type']) && in_array($m->getKey(), $query['id_type']) ? 'selected' : '' ) }} value="{{{ $m->getKey() }}}">{{{ $m->name }}}</option>
										       			@endforeach
										       		</select>
										      	</div>
											</div>
											<div class="col-xs-12 ">
												<div class="form-group form-group-xs">
														
													<label for="">Profundidad TVD (ft)</label>
										       		<select name="deep_range" class="form-control">
										       			<option value="">Selecciona</option>
										       			<option value="<5000"> Menor que 5.000</option>
										       			<option value="5000-10000">Entre 5.000 y 10.000</option>
										       			<option value="10000-15000">Entre 10.000 y 15.000</option>
										       			<option value="15000-20000">Entre 15.000 y 20.000</option>
										       			<option value="20000-25000">Entre 20.000 y 25.000</option>
										       			<option value=">25000">Mayor que 25.000</option>
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
	<script type="text/template" id="poup-template">
		<table style="min-width: 200px;">
			<tr>
				<td colspan="2" style="text-align: center;"><strong><h5>@{{ name }}</h5></strong></td>
			</tr>
			<tr>
				<td style="padding: 0px 8px;"><strong>Tipo de pozo </strong></td>
				<td>@{{ type.name }}</td>
			</tr>			
			<tr>
				<td style="padding: 0px 8px;"><strong>Coordenada en X </strong></td>
				<td>@{{ x }}</td>
			</tr>
			<tr>
				<td style="padding: 0px 8px;"><strong>Coordenada en Y</strong></td>
				<td>@{{ y }}</td>
			</tr>
			<tr>
				<td style="padding: 0px 8px;"><strong>Coordenada en Z</strong></td>
				<td>@{{ z }}</td>
			</tr>
			<tr>
				<td style="padding: 0px 8px;"><strong>Sistema de coordenadas</strong></td>
				<td>@{{ coor_sys.name }}</td>
			</tr>
			<tr>
				<td style="padding: 0px 8px;"><strong>profundidad TVD (ft)</strong></td>
				<td>@{{ profundidad_tvd }}</td>
			</tr>
			<tr>
				<td style="padding: 0px 8px;"><strong>profundidad MD (ft)</strong></td>
				<td>@{{ profundidad_tvd }}</td>
			</tr>			
			<tr>
				<td style="padding: 0px 8px;"><strong>Well kb elev</strong></td>
				<td>@{{ well_kb_elev }}</td>
			</tr>
			<tr>
				<td style="padding: 0px 8px;"><strong>Rotaty elev</strong></td>
				<td>@{{ rotaty_elev }}</td>
			</tr>
			<tr>
				<td style="padding: 0px 8px;"><strong>Regi&oacute;n</strong></td>
				<td>@{{ area.name }}</td>
			</tr>
			<tr>
				<td style="padding: 0px 8px;"><strong>Cuenca</strong></td>
				<td>@{{ cuenca.name }}</td>
			</tr>
			<tr>
				<td style="padding: 0px 8px;"><strong>Bloque</strong></td>
				<td>@{{ block.name }}</td>
			</tr>
		</table>
	</script>
	<script>
		var models ={!! $models->toJson() !!}
		console.log(models);
		$('#map').wellMap({type: 'google', data: models.data, popUpTemplate:$('#poup-template').html() });
	</script>
@stop