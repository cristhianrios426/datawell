@extends('layouts.app')
@section('head')
	<meta name="entity" content="{{{ $entityName }}}">
@stop
@section('content')
<div class="container">
	@include('util.breadcrums.settings',['active'=>ucfirst($entitiesLabel)])
	<div class="row">
		<div class="col-xs-12">
			<form action="">
				<div class="panel panel-default">
					<div class="panel-heading">
						<div class="continer-fluid">
							<div class="row">
								<div class="col-xs-12">
									<div class="pull-left">
										<h4>{{{ ucfirst($entitiesLabel) }}}</h4>
									</div>
									<div class="pull-right">
										<a   href="{{{ route($entityName.'.create') }}}" class="btn btn-success">
											<i class="fa fa-plus"  aria-hidden="true"></i> Crear  {{{ $entityLabel }}}
										</a>
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
												<div class="form-group">
													<label for="">Nombre</label>
										       		<input type="text" name="name" class="form-control" value="">
										      	</div>
											</div>
											<div class="col-xs-12 col-sm-6 col-md-4 col-lg-3">
												<div class="form-group">
													<label for="">Tipo de servicio</label>
										       		<select name="id_service_type[]" multiple class="selectpicker form-control">
										       			@foreach ($serviceTypes as $m)
										       				<option  {{ ( isset($query['id_service_type']) && in_array($m->getKey(), $query['id_service_type']) ? 'selected' : '' ) }} value="{{{ $m->getKey() }}}">{{{ $m->name }}}</option>
										       			@endforeach
										       		</select>
										      	</div>
											</div>
											<div class="col-xs-12 col-sm-6 col-md-4 col-lg-3">
												<div class="form-group">
													<label for="">Pozo</label>
										       		<select name="id_well[]" multiple class="selectpicker form-control">
										       			@foreach ($wells as $m)
										       				<option  {{ ( isset($query['id_well']) && in_array($m->getKey(), $query['id_well']) ? 'selected' : '' ) }} value="{{{ $m->getKey() }}}">{{{ $m->name }}}</option>
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
						<button class="btn btn-primary">
							Buscar
						</button>
						<a href="{{ route($entityName.'.index') }}" class="btn btn-warning">
							Limpiar
						</a>
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
							  <li class="list-group-item"><strong>Pozo:</strong> {{{ $model->well ? $model->well->name : '' }}} </li>
							  <li class="list-group-item"><strong>Tipo de servicio:</strong> {{{ $model->type ? $model->type->name : '' }}} </li>
							  <li class="list-group-item"><strong>Tipo de sección:</strong> {{{ $model->section ? $model->section->name : '' }}} </li>
							  <li class="list-group-item"><strong>Descripci&oacute;n:</strong> {{{ $model->description }}} </li>
							</ul>
						</div>
						<div class="panel-footer text-right">
							
							<div class="btn-group">
							  <button class="btn btn-primary">Acciones</button>
							  <button data-toggle="dropdown" class="btn btn-primary dropdown-toggle"><span class="caret"></span></button>
							  <ul class="dropdown-menu">
								<li><a href="{{{ route($entityName.'.show', ['id'=>$model->id]) }}}"  >Ver detalles </a></li>
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
	<link rel="stylesheet" href="{{ asset('vendors/bootstrap-select/dist/css/bootstrap-select.min.css') }}">
	<script src="{{ asset('vendors/bootstrap-select/dist/js/bootstrap-select.min.js') }}"></script>
	<script src="{{ asset('vendors/bootstrap-select/dist/js/i18n/defaults-es_ES.min.js') }}"></script>
	<script src="{{ asset('js/scripts/index-well-controller.js') }}"></script>
@stop