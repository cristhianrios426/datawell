@extends('layouts.app')
@section('head')
	<meta name="entity" content="{{{ $entityName }}}">
@stop
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
									@can('create', $classname)<button data-create data-toggle="modal" data-target="#modal-model" href="" class="btn btn-success">
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
							<div class="col-xs-12">
								<div class="just-padding">
									<div class="list-group list-group-root well">
										@foreach($models as $model)
											@include('locations.list-item', ['model'=>$model])
										@endforeach
									</div>
								</div>
							</div>
						</div>
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
    <script src="{{ asset('js/scripts/location-controller.js') }}"></script>
@stop
