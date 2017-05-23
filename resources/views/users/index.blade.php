@extends('layouts.app')
@section('content')
<div class="container">
	@include('util.breadcrums.settings',['active'=>ucfirst($entitiesLabel)])
	<div class="row">
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
									<button data-create data-toggle="modal" data-target="#modal-model" href="" class="btn btn-success">
										<i class="fa fa-plus"  aria-hidden="true"></i> Crear {{{ $entityLabel }}}
									</button>
								</div>
							</div>
						</div>
					</div>
				</div>
				<div class="panel-body">
					<div class="fluid-container">
						<div class="row">
							<div class="col-md-offset-6 col-md-6 col-xs-12">
								<form action="{{ route('user.index') }}">
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
								<th><a href="{{ $sortLinks['email']['url'] }}">Email <i class="fa fa-{{ $sortLinks['email']['type'] }}"></i></a></th>
								<th><a href="{{ $sortLinks['ide']['url'] }}">No. de identificaci&oacute;n <i class="fa fa-{{ $sortLinks['ide']['type'] }}"></i></a></th>
								<th><a href="">Rol</a></th>
								<th>Acciones</th>
							</tr>
						</thead>
						<tbody>
							@foreach ($models as $model)
								<tr>
									<td>{{{ $model->id }}}</td>
									<td>{{{ $model->name }}}</td>
									<td>{{{ $model->email }}}</td>
									<td>{{{ $model->ide }}}</td>
									<td>{{{ $model->roleName() }}}</td>
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
							<h2> No se han encontrado resultados </h2>
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
	<link rel="stylesheet" href="{{ asset('vendors/bootstrap-select/dist/css/bootstrap-select.min.css') }}">
    <script src="{{ asset('vendors/bootstrap-select/dist/js/bootstrap-select.js') }}"></script>
    <script src="{{ asset('vendors/bootstrap-select/dist/js/i18n/defaults-'.\Config::get('app.locale').'.js') }}"></script>
    <script src="{{ asset('js/scripts/entity.js') }}"></script>
    <script src="{{ asset('js/scripts/user-controller.js') }}"></script>
@stop