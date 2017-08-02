@extends('layouts.app')
@section('content')
<div class="container">
	<div class="row">
		<div class="col-xs-12">
			<ol class="breadcrumb">
			  <li><a href="{{{ url('/') }}}">Inicio</a></li>			  
			  <li class="active">Ayuda</li>			  
			  <li class="active">Manual de usuario</li>
			</ol>
		</div>
	</div>
	<div class="row">
		<div class="col-xs-12">
			<div class="panel panel-default">
				<div class="panel-body">
					@if ($models->count() > 0)
						<table class="data-table table table-striped table-bordered dt-responsive nowrap">
							<thead>
								<tr>
									<th>Nombre</th>					
									<th>Archivo</th>								
								</tr>
							</thead>
							<tbody>
								@foreach ($models as $model)
									<tr>
										<td>{{{ $model->name }}}</td>						
										<td> <a target="_blank" href="{{ $model->downloadUrl()}}">Descargar</a></td>
									</tr>
								@endforeach
							</tbody>
						</table>
					@else
					<div class="alert alert-warning">
			          <h4>No hay ningún manual disponible</h4>
			        </div>
					@endif
					
				</div>
			</div>
		</div>
	</div>
</div>
@stop()
