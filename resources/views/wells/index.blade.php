@extends('layouts.app')
@section('head')
	<meta name="entity" content="{{{ $entityName }}}">
@stop
@section('content')
<div class="container">
	<div class="row">
		<div class="col-xs-12" style="margin-bottom: 22px">
			<div class="panel panel-default">
				<div class="panel-heading">
					<div class="row">
						<div class="col-xs-12">
							<div class="pull-left">
								<h4>Pozos</h4>	
							</div>
							<div class="pull-right">
								<a   href="{{{ route($entityName.'.create') }}}" class="btn btn-success">
									<i class="fa fa-plus"  aria-hidden="true"></i> Crear  {{{ $entityLabel }}}
								</a>
							</div>
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
											<div class="col-xs-12 col-sm-6 col-md-4 col-lg-3">
												<div class="form-group form-group-xs">
													<label for="">Nombre</label>
										       		<input type="text" name="name" class="form-control" value="">
										      	</div>
											</div>
											<div class="col-xs-12 col-sm-6 col-md-4 col-lg-3">
												<div class="form-group form-group-xs">
													<label for="">Tipo de servicio</label>
										       		<select name="id_well_type[]" multiple class="selectpicker form-control">
										       			
										       			@foreach ($serviceTypes as $m)
										       				<option  {{ ( isset($query['id_well_type']) && in_array($m->getKey(), $query['id_well_type']) ? 'selected' : '' ) }} value="{{{ $m->getKey() }}}">{{{ $m->name }}}</option>
										       			@endforeach
										       		</select>
										      	</div>
											</div>
											<div class="col-xs-12 col-sm-6 col-md-4 col-lg-3">
												<div class="form-group form-group-xs">
													<label for="">Pa&iacute;s</label>
										       		<select name="country" class="form-control">
										       			<option value=""></option>
										       		</select>
										      	</div>
											</div>
											<div class="col-xs-12 col-sm-6 col-md-4 col-lg-3">
												<div class="form-group form-group-xs">
													<label for="">Estado/Depart/Provincia</label>
										       		<select name="state" class="form-control">
										       			<option value=""></option>
										       		</select>
										      	</div>
											</div>
											<div class="col-xs-12 col-sm-6 col-md-4 col-lg-3">
												<div class="form-group form-group-xs">
													<label for="">Municipio</label>
										       		<select name="city" class="form-control">
										       			<option value=""></option>
										       		</select>
										      	</div>
											</div>
											<div class="col-xs-12 col-sm-6 col-md-4 col-lg-3">
												<div class="form-group form-group-xs">
													<label for="">Regi&oacute;n</label>
										       		<select name="id_area[]" multiple class=" selectpicker form-control">
										       			
										       			@foreach ($areas as $m)
										       				<option  {{ ( isset($query['id_area']) && in_array($m->getKey(), $query['id_area']) ? 'selected' : '' ) }} value="{{{ $m->getKey() }}}">{{{ $m->name }}}</option>
										       			@endforeach
										       		</select>
										      	</div>
											</div>
											<div class="col-xs-12 col-sm-6 col-md-4 col-lg-3">
												<div class="form-group form-group-xs">
													<label for="">Cuenca</label>
										       		<select name="id_cuenca[]" multiple class=" selectpicker form-control">
										       			
										       			@foreach ($cuencas as $m)
										       				<option {{ ( isset($query['id_cuenca']) && in_array($m->getKey(), $query['id_cuenca']) ? 'selected' : '' ) }} value="{{{ $m->getKey() }}}">{{{ $m->name }}}</option>
										       			@endforeach
										       		</select>
										      	</div>
											</div>
											<div class="col-xs-12 col-sm-6 col-md-4 col-lg-3">
												<div class="form-group form-group-xs">
													<label for="">Campo</label>
										       		<select name="id_camp[]" multiple class=" selectpicker form-control">
										       			
										       			@foreach ($camps as $m)
										       				<option value="{{{ $m->getKey() }}}">{{{ $m->name }}}</option>
										       			@endforeach
										       		</select>
										      	</div>
											</div>
											<div class="col-xs-12 col-sm-6 col-md-4 col-lg-3">
												<div class="form-group form-group-xs">
													<label for="">Operador</label>
										       		<select name="id_operator[]" multiple class="selectpicker form-control">
										       			
										       			@foreach ($operators as $m)
										       				<option {{ ( isset($query['id_operator']) && in_array($m->getKey(), $query['id_operator']) ? 'selected' : '' ) }} value="{{{ $m->getKey() }}}">{{{ $m->name }}}</option>
										       			@endforeach
										       		</select>
										      	</div>
											</div>
											<div class="col-xs-12 col-sm-6 col-md-4 col-lg-3">
												<div class="form-group form-group-xs">
													<label for="">Tipo de pozo</label>
										       		<select name="id_type[]" multiple class="selectpicker form-control">
										       			@foreach ($types as $m)
										       				<option {{ ( isset($query['id_type']) && in_array($m->getKey(), $query['id_type']) ? 'selected' : '' ) }} value="{{{ $m->getKey() }}}">{{{ $m->name }}}</option>
										       			@endforeach
										       		</select>
										      	</div>
											</div>
											<div class="col-xs-12 col-sm-6 col-md-4 col-lg-3">
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
					<div class="panel panel-info">
						<div class="panel-heading"><h4>{{{ $model->name }}}</h4></div>
						<div class="panel-body">
							<ul class="list-group">
							  <li class="list-group-item"><strong>Tipo de pozo:</strong> {{{ $model->type ? $model->type->name : '' }}} </li>
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
								<li><a href="{{{ route($entityName.'.show', ['id'=>$model->id]) }}}"  >Ver detalles</a></li>
								 <li><a href="{{{ route('service.create',['id_well'=>$model->getKey()]) }}}"  >A&ntilde;adir servicio</a></li>
								<li><a href="{{{ route($entityName.'.edit', ['id'=>$model->id]) }}}"  >Editar</a></li>
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
			<div class="alert alert-primary">
				<h4> No se han encontrado resultados </h4>
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
		$('#map').wellMap({type: 'osm', data: models.data, popUpTemplate:$('#poup-template').html() });
	</script>
@stop