@extends('layouts.app')
@section('head')
	<meta name="entity" content="{{{ $entityName }}}">
@stop
@section('content')
<div class="container">
	<div class="row">
		@include('util.breadcrums.settings',['active'=>ucfirst($entitiesLabel)])
		<div class="col-xs-12">
			<div class="panel panel-default">
				<div class="panel-heading">
					<div class="continer-fluid">
						<div class="row">
							<div class="col-xs-12">
								<div class="pull-left">
									<h4>{{{ ucfirst($entitiesLabel) }}}</h4>
								</div>
								<div class="pull-right">
									@can('create',  \App\ORM\Setting::class)<button data-create data-toggle="modal" data-target="#modal-model" href="" class="btn btn-success">
										<i class="fa fa-plus"  aria-hidden="true"></i> Crear  {{{ $entityLabel }}}
									</button>@endcan
								</div>
							</div>
						</div>
					</div>
				</div>
				<div class="panel-body">
					<div class="fluid-container">
						<div class="row">
							<div class="col-md-offset-6 col-md-6 col-xs-12">
								<form action="{{ route($entityName.'.index') }}">
									<div class="input-group">
							       		<input type="text" name="term" class="form-control" value="{{{ (isset($query['term']) ? $query['term'] : '' ) }}}">
							        	<span class="input-group-btn">
							              	<button type="submit" class="btn btn-primary">Buscar</button>
							          	</span>
							      	</div>
							      	<br>
								</form>
							</div>
						</div>
					</div>
					@if($models->count() > 0)
					<table class="data-table table table-striped table-bordered dt-responsive nowrap">
						<thead>
							<tr>
								<th>ID</th>
								<th><a href="{{ $sortLinks['name']['url'] }}">Nombre <i class="fa fa-{{ $sortLinks['name']['type'] }}"></i></a></th>
								
								<th>Acciones</th>
							</tr>
						</thead>
						<tbody>
							@foreach ($models as $model)
								<tr>
									<td>{{{ $model->id }}}</td>
									<td>{{{ $model->name }}}</td>
									
									<td>
										<div class="btn-group">
										  <button class="btn btn-primary">Acciones</button>
										  <button data-toggle="dropdown" class="btn btn-primary dropdown-toggle"><span class="caret"></span></button>
										  <ul class="dropdown-menu">
											@can('update', $model) <li><a href="#" data-toggle="modal" data-target="#modal-model" data-edit="{{{ $model->getKey() }}}">Editar</a></li> @endcan
											@can('delete', $model) <li><a href="#" data-toggle="modal" data-target="#modal-model" data-remove="{{{ $model->getKey() }}}">Eliminar</a></li> @endcan
								
											@can('view', $model) <li><a href="#" data-toggle="modal" data-target="#modal-model" data-show="{{{ $model->getKey() }}}">Detalles</a></li> @endcan
								
										  </ul>
										</div>
									</td>
								</tr>
							@endforeach
						</tbody>
					</table>
					@else
						<div class="alert alert-primary">
							<h4> No se han encontrado resultados </h4>
						</div>
					@endif
					<div class="text-right">
						<div class="inline-block">{{ $models->render() }}</div> 	
					</div>
				</div>
			</div>

			<div class="modal fade " tabindex="-1" role="dialog" id="modal-model" aria-hidden="true" >
				<div class="modal-dialog ">
					<div class="modal-content" id="modal-content">
						
					</div>
				</div>
			</div>
		</div>
	</div>
</div>
@stop()
@section('footer')	
    <script src="{{ asset('vendors/bootstrap-colorpicker-master/dist/js/bootstrap-colorpicker.min.js') }}"></script>
    <link rel="stylesheet" href="{{ asset('vendors/bootstrap-colorpicker-master/dist/css/bootstrap-colorpicker.min.css') }}">
    <script src="{{ asset('js/scripts/entity.js') }}"></script>    
    <script src="{{ asset('js/scripts/crud-controller.js') }}"></script>
    <script src="{{ asset('js/scripts/well-type-controller.js') }}"></script>
@stop